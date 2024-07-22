<?php
namespace App\Repositories\Paciente;

use App\Interfaces\Paciente\PacienteInterface;
use App\Models\Paciente;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;

class PacienteRepository implements PacienteInterface
{
    public function __construct(protected Paciente $pacientes){}

    public function query($orderColumn = 'id', $orderDirection = 'desc')
    {
        $query = $this->pacientes->newQuery();

        if ($orderColumn === 'hospital_nombre') {
            $query->leftJoin('users as u', 'u.id', '=', 'pacientes.user_id')
                ->leftJoin('hospitals as h', 'h.id', '=', 'u.hospital_id')
                ->orderBy('h.nombre', $orderDirection)
                ->select('pacientes.*');
        } else {
            $query->orderBy($orderColumn, $orderDirection);
        }

        return $query;
    }

    public function find($id): Paciente|Collection|null
    {
        return $this->pacientes->find($id);
    }

    public function findWithTrashed($id): Paciente|Collection|null
    {
        return $this->pacientes->withTrashed()->find($id);
    }

    public function all(): Collection
    {
        return $this->pacientes->all();
    }

    public function pacientesActivos(): Collection
    {
        return $this->pacientes->with(['contratos' => function ($query) {
            $query->latest();
        }])->whereHas('contratos', function ($query) {
            $query->whereIn('estado_orden', [4, 5]);
        })->get();
    }

    public function pacientesInactivos(): Collection
    {
        return $this->pacientes->with(['contrato' => function ($query) {
            $query->latest();
        }])->whereHas('contrato', function ($query) {
            $query->whereIn('estado_orden', [6]);
        })->get();
    }

    public function pacientesPendientes(): Collection
    {
        return $this->pacientes->with(['contrato' => function ($query) {
            $query->latest();
        }])->whereHas('contrato', function ($query) {
            $query->whereIn('estado_orden', [0, 1]);
        })->get();
    }

    public function allWithTrashed(): Collection
    {
        return $this->pacientes->withTrashed()->get();
    }

    public function allOnlyTrashed(): Collection
    {
        return $this->pacientes->onlyTrashed()->get();
    }

    public function create(array $data): Paciente|Collection|null
    {
        return $this->pacientes->create($data);
    }

    public function checkReniec($dni)
    {
        $client = new Client(['base_uri' => config('reniec.url'), 'verify' => false]);
        $parameters = [
            'http_errors' => false,
            'connect_timeout' => 5,
            'headers' => [
                'Authorization' => 'Bearer ' . config('reniec.token'),
                'Referer' => 'https://apis.net.pe/',
                'User-Agent' => 'laravel/guzzle',
                'Accept' => 'application/json',
            ],
            'query' => ['numero' => $dni],
        ];

        $res = $client->request('GET', 'v2/reniec/dni', $parameters);

        if ($res->getStatusCode() != 200) {
//            dd($res->getBody()->getContents());
            throw new \Exception("Error al consultar Reniec. Código: " . $res->getStatusCode());
        }

        $response = json_decode($res->getBody()->getContents(), true);
        dd($response);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("Error al decodificar la respuesta de Reniec: " . json_last_error_msg());
        }

        if (!isset($response['nombres'], $response['apellidoPaterno'], $response['apellidoMaterno'])) {
            throw new \Exception("La respuesta de Reniec no contiene los campos esperados. Verifique el token de Reniec y avise al administrador del sistema.");
        }

        return $response;
    }
}

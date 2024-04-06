<?php

namespace App\Http\Controllers;

use App\Http\Requests\Usuarios\ActualizarRequest;
use App\Http\Requests\Usuarios\CrearRequest;
use App\Models\Hospital;
use App\Models\User;
use App\Services\Logs\LogService;
use App\Services\User\UserServices;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class UsuariosController extends Controller
{
    protected $userService;
    protected $logService;

    public function __construct(UserServices $userService, LogService $logService)
    {
        $this->userService = $userService;
        $this->logService = $logService;
    }

    public function index()
    {
        return view('usuario.index', ['usuarios' => $this->userService->usuariosActivos(), 'inactivos' => $this->userService->usuariosInactivos(), 'eliminados' => $this->userService->allOnlyTrashed()]);
    }

    public function create()
    {
        $hospitals = $this->getHospitalOptions();
        $roles = $this->getRoleOptions();

        return view('usuario.create', compact('hospitals', 'roles'));
    }

    public function store(CrearRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->userService->create($request->all());
            $this->logService->create('Creacion Usuarios');
            DB::commit();
            DB::rollBack();
            session()->flash('alert', ['type' => 'success', 'message' => 'Operación realizada con éxito']);
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Se Ha Atrapado una Exception en UsuariosController::store: '.$e->getMessage().' - '. $e->getCode().' - '. $e->getTraceAsString());
            session()->flash('alert', ['type' => 'danger', 'message' => 'Hubo una Excepcion al Crear el Usuario: ' . $e->getMessage()]);
        }catch (\Error $er) {
            DB::rollBack();
            Log::error('Se Ha Atrapado un Error en UsuariosController::store: '.$er->getMessage().' - '. $er->getCode().' - '. $er->getTraceAsString());
            session()->flash('alert', ['type' => 'danger', 'message' => 'Hubo un error al Crear el Usuario: ' . $er->getMessage()]);

        }catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Se Ha Atrapado un Throwable en UsuariosController::store: '.$th->getMessage().' - '. $th->getCode().' - '. $th->getTraceAsString());
            session()->flash('alert', ['type' => 'danger', 'message' => 'Hubo un Throw al Crear el Usuario: ' . $th->getMessage()]);
        } finally {
            DB::rollBack();
            return redirect()->route('usuarios.index');
        }
    }

    public function show(User $usuario)
    {
        if ($usuario->email_verified_at != null) {
            $anteriorItem = User::query()->whereNotNull('email_verified_at')->where('id', '<', $usuario->id)->get()->last();
            $siguienteItem = User::query()->whereNotNull('email_verified_at')->where('id', '>', $usuario->id)->orderBy('id', 'asc')->first();
        }

        if ($usuario->email_verified_at === null) {
            $anteriorItem = User::query()->where('email_verified_at', null)->where('id', '<', $usuario->id)->get()->last();
            $siguienteItem = User::query()->where('email_verified_at', null)->where('id', '>', $usuario->id)->orderBy('id', 'asc')->first();
        }
        if ($usuario->deleted_at != null) {
            $anteriorItem = User::query()->onlyTrashed()->where('id', '<', $usuario->id)->get()->last();
            $siguienteItem = User::query()->onlyTrashed()->where('id', '>', $usuario->id)->orderBy('id', 'asc')->first();
        }


        $config = [
            'title' => 'Detalles del Usuario: ' . $usuario->nombre,
            'back' => route('usuarios.index'),
            'siguiente' => $siguienteItem ? route('usuarios.show', $siguienteItem->id) : null,
            'anterior' => $anteriorItem ? route('usuarios.show', $anteriorItem->id) : null,
            'fields' => [
                'Nombre' => $usuario->name.' '.$usuario->apellido,
                'Hospital' => $usuario->hospital->nombre,
                'Correo Electrónico' => $usuario->email,
                'Nombre de Usuario' => $usuario->username,
                'Roles' => $usuario->roles->pluck('name')->implode(', '),
                'Estado' => $usuario->email_verified_at ? 'Activo' : 'Inactivo',
                'Creado' => $usuario->created_at->format('d/m/Y H:i:s') .' ' . $usuario->created_at->diffForHumans(),
                'Actualizado' => $usuario->updated_at->format('d/m/Y H:i:s') .' ' . $usuario->updated_at->diffForHumans(),
            ],
            'actions' => [
                'Editar' => [
                    'url' => route('usuarios.edit', $usuario),
                    'color' => 'bg-blue-500',
                    'hover' => 'bg-blue-700',
                    'icono' => 'fa fa-edit',
                ],
                'Borrar' => [
                    'url' => route('usuarios.destroy', $usuario),
                    'color' => 'bg-red-500',
                    'hover' => 'bg-red-700',
                    'icono' => 'fa fa-trash',
                ],
            ],
        ];

        if ($usuario->deleted_at != null) {
            $config['fields']['Eliminado'] = $usuario->deleted_at->format('d/m/Y H:i:s') .' ' . $usuario->deleted_at->diffForHumans() ;
            $config['actions']['Restaurar'] = [
                'url' => route('usuarios.restore', $usuario),
                'color' => 'bg-green-500',
                'hover' => 'bg-green-700',
                'icono' => 'fa fa-trash-restore',
            ];
            $config['actions']['Eliminar Definitivamente'] = [
                'url' => route('usuarios.destroy', $usuario),
                'color' => 'bg-red-500',
                'hover' => 'bg-red-700',
                'icono' => 'fa fa-trash',
            ];
            unset($config['actions']['Borrar']);
        }
        return view('usuario.show', compact('usuario', 'config', 'anteriorItem', 'siguienteItem'));
    }

    public function edit(User $usuario)
    {
        $hospitals = $this->getHospitalOptions();
        $roles = $this->getRoleOptions();
        return view('usuario.edit', compact('hospitals', 'roles', 'usuario'));
    }

    public function update(ActualizarRequest $request, User $usuario)
    {
        try {
            DB::beginTransaction();
            $this->userService->update($usuario, $request->all());
            $this->logService->create('Actualizacion Usuarios');
            DB::commit();
            session()->flash('alert', ['type' => 'success', 'message' => 'Operación realizada con éxito']);
            return redirect()->route('usuarios.index');
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Se Ha Atrapado una Exception en UsuariosController::store: '.$e->getMessage().' - '. $e->getCode().' - '. $e->getTraceAsString());
            return back()->withErrors('Hubo una Excepcion al Crear el Usuario: ' . $e->getMessage());
        }catch (\Error $er) {
            DB::rollBack();
            Log::error('Se Ha Atrapado un Error en UsuariosController::store: '.$er->getMessage().' - '. $er->getCode().' - '. $er->getTraceAsString());
            return back()->withErrors('Hubo un error al Crear el Usuario: ' . $er->getMessage());
        }catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Se Ha Atrapado un Throwable en UsuariosController::store: '.$th->getMessage().' - '. $th->getCode().' - '. $th->getTraceAsString());
            return back()->withErrors('Hubo un Throw al Crear el Usuario: ' . $th->getMessage());
        }
    }

    public function delete(User $usuario)
    {
        //TODO: Pasar a un servicio y su correspondiente Repositorio....
        $nombre = $usuario->name;

        $usuario->delete();
        session()->flash('alert', ['type' => 'danger', 'message' => "Operacion realizada con Exito El Usuario $nombre fue eliminado"]);
        return redirect()->route('usuario.index');
    }

    public function restore(User $usuario)
    {
        //TODO: Pasar a un servicio y su correspondiente Repositorio....

        dd($usuario);
        $nombre = $usuario->name;
        $usuario->restore();
        session()->flash('alert', ['type' => 'success', 'message' => "Operacion realizada con Exito El Usuario $nombre fue Restaurado"]);
        return redirect()->route('usuarios.index');
    }

    public function destroy(User $usuario)
    {
        //TODO: Pasar a un servicio y su correspondiente Repositorio....

        dd($usuario);
        $nombre = $usuario->name;
        $usuario->forceDelete();
        session()->flash('alert', ['type' => 'danger', 'message' => "Operacion realizada con Exito El Usuario $nombre fue Eliminado Definitivamente"]);
        return redirect()->route('usuario.index');
    }

    public function impersonate(User $usuario)
    {
        //TODO: Pasar a un servicio y su correspondiente Repositorio....

        session()->put('impersonate', Auth::id());
        Auth::login($usuario);
        return redirect()->route('usuarios.index');
    }

    public function stopImpersonating()
    {
        //TODO: Pasar a un servicio y su correspondiente Repositorio....

        Auth::loginUsingId(session()->get('impersonate'));
        session()->forget('impersonate');
        return redirect()->route('index');
    }

    private function getHospitalOptions()
    {
        if (Auth::user()->hasAnyRole('SuperAdmin', 'Dueño')) {
            return Hospital::query()->pluck('nombre', 'id');
        } else {
            return Hospital::query()->where('id', Auth::user()->hospital_id)->pluck('nombre', 'id');
        }
    }

    private function getRoleOptions()
    {
        $user = Auth::user();
        $userRoles = $this->getUserRoles();

        foreach ($userRoles as $role => $exclusions) {
            if ($role === 'default') {
                return [];
            }

            if ($user->hasRole($role)) {
                return $this->filterRoles($exclusions);
            }
        }

        return [];
    }

    private function getUserRoles()
    {
        return [
            'SuperAdmin' => [],
            'Dueño' => ['SuperAdmin'],
            'Administrador' => ['SuperAdmin', 'Dueño'],
            'Gerencia' => ['SuperAdmin', 'Dueño', 'Administrador'],
            'Hospitales' => ['SuperAdmin', 'Dueño', 'Administrador', 'Gerencia'],
            'default' => []
        ];
    }

    private function filterRoles(array $exclusions)
    {
        $query = Role::query();

        foreach ($exclusions as $exclusion) {
            $query->where('name', '!=', $exclusion);
        }

        return $query->pluck('name', 'id');
    }
}

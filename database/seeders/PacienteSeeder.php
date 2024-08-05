<?php

namespace Database\Seeders;

use App\Models\Archivo;
use App\Models\Carrito;
use App\Models\Concentrador;
use App\Models\Contrato;
use App\Models\ContratoFechas;
use App\Models\ContratoUsuario;
use App\Models\Direccion;
use App\Models\Diagnostico;
use App\Models\Paciente;
use App\Models\Producto;
use App\Models\Regulador;
use App\Models\Tanque;
use App\Models\Telefono;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PacienteSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < rand(10, 100); $i++) {
            $paciente = Paciente::factory()->create();
            $contrato = Contrato::factory()->create(['paciente_id' => $paciente->id]);

            $creacion_documentos = [
                Archivo::TIPO_SOLICITUD_OXIGENOTERAPIA,
                Archivo::TIPO_DNI_PACIENTE,
                Archivo::TIPO_DNI_CUIDADOR,
                Archivo::TIPO_DECLARACION_DOMICILIO,
                Archivo::TIPO_CROQUIS_DIRECCION,
                Archivo::TIPO_OTROS,
            ];

            foreach ($creacion_documentos as $doc) {
                Archivo::factory()->create([
                    'contrato_id' => $contrato->id,
                    'paciente_id' => $paciente->id,
                    'tipo' => $doc,
                    'nombre' => $doc . '_' . now()->format('Y_m_d') . '.pdf',
                    'ruta' => 'archivos/' . strtolower(str_replace(' ', '-', $paciente->name)) . '-' . strtolower(str_replace(' ', '-', $paciente->surname)) . '-' . $paciente->id . '/' . $doc . '_' . now()->timestamp . '.pdf',
                ]);
            }

            for ($j = 0; $j <= 1; $j++) {
                $contrato = Contrato::factory()->create(['paciente_id' => $paciente->id]);

                Diagnostico::factory()->create(['contrato_id' => $contrato->id]);
                ContratoFechas::factory()->create();
                ContratoUsuario::factory()->create();
                Direccion::factory()->create();

                for ($k = 0; $k <= rand(1, 3); $k++) {
                    Telefono::factory()->create();
                }

                $aprobacion_documentos = [
                    Archivo::TIPO_ENTREGA_DISPOSITIVOS,
                    Archivo::TIPO_GUIA_REMISION,
                ];

                foreach ($aprobacion_documentos as $doc) {
                    Archivo::factory()->create([
                        'contrato_id' => $contrato->id,
                        'paciente_id' => $paciente->id,
                        'tipo' => $doc,
                        'nombre' => $doc . '_' . now()->format('Y_m_d') . '.pdf',
                        'ruta' => 'archivos/' . strtolower(str_replace(' ', '-', $paciente->name)) . '-' . strtolower(str_replace(' ', '-', $paciente->surname)) . '-' . $paciente->id . '/' . $contrato->id . '/' . $doc . '_' . now()->timestamp . '.pdf',
                    ]);
                }

                $durante_contrato_documentos = [
                    Archivo::TIPO_CAMBIO_CONSUMIBLE,
                    Archivo::TIPO_CAMBIO_MAQUINA,
                    Archivo::TIPO_CAMBIO_DOSIS,
                    Archivo::TIPO_CAMBIO_DIRECCION,
                    Archivo::TIPO_INFORME_INCIDENCIA,
                    Archivo::TIPO_RESPUESTA_INCIDENCIA,
                ];

                for ($l = 0; $l <= rand(0, count($durante_contrato_documentos) - 1); $l++) {
                    $doc = $durante_contrato_documentos[array_rand($durante_contrato_documentos)];
                    Archivo::factory()->create([
                        'contrato_id' => $contrato->id,
                        'paciente_id' => $paciente->id,
                        'tipo' => $doc,
                        'nombre' => $doc . '_' . now()->format('Y_m_d') . '.pdf',
                        'ruta' => 'archivos/' . strtolower(str_replace(' ', '-', $paciente->name)) . '-' . strtolower(str_replace(' ', '-', $paciente->surname)) . '-' . $paciente->id . '/' . $contrato->id . '/' . $doc . '_' . now()->timestamp . '.pdf',
                    ]);
                }

                $finalizacion_documento = Archivo::TIPO_RECOJO_DISPOSITIVOS;
                Archivo::factory()->create([
                    'contrato_id' => $contrato->id,
                    'paciente_id' => $paciente->id,
                    'tipo' => $finalizacion_documento,
                    'nombre' => $finalizacion_documento . '_' . now()->format('Y_m_d') . '.pdf',
                    'ruta' => 'archivos/' . strtolower(str_replace(' ', '-', $paciente->name)) . '-' . strtolower(str_replace(' ', '-', $paciente->surname)) . '-' . $paciente->id . '/' . $contrato->id . '/' . $finalizacion_documento . '_' . now()->timestamp . '.pdf',
                ]);

                $concentrador = Concentrador::factory()->create();
                $concentradorProducto = Producto::factory()->create([
                    'productable_type' => Concentrador::class,
                    'productable_id' => $concentrador->id,
                ]);
                DB::table('contrato_productos')->insert([
                    'contrato_id' => $contrato->id,
                    'producto_id' => $concentradorProducto->id,
                ]);

                if (rand(0, 100) < 75) {
                    $tanque = Tanque::factory()->create();
                    $tanqueProducto = Producto::factory()->create([
                        'productable_type' => Tanque::class,
                        'productable_id' => $tanque->id,
                    ]);
                    DB::table('contrato_productos')->insert([
                        'contrato_id' => $contrato->id,
                        'producto_id' => $tanqueProducto->id,
                    ]);

                    if (rand(0, 100) < 20) {
                        $regulador = Regulador::factory()->create();
                        $reguladorProducto = Producto::factory()->create([
                            'productable_type' => Regulador::class,
                            'productable_id' => $regulador->id,
                        ]);
                        DB::table('contrato_productos')->insert([
                            'contrato_id' => $contrato->id,
                            'producto_id' => $reguladorProducto->id,
                        ]);

                        $carrito = Carrito::factory()->create();
                        $carritoProducto = Producto::factory()->create([
                            'productable_type' => Carrito::class,
                            'productable_id' => $carrito->id,
                        ]);
                        DB::table('contrato_productos')->insert([
                            'contrato_id' => $contrato->id,
                            'producto_id' => $carritoProducto->id,
                        ]);
                    }
                }
            }
        }
    }
}

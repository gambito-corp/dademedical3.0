<div class="container mx-auto py-4">

    <!-- Zona de Información -->
    <div class="bg-white shadow-md rounded p-4 mb-6">
        <h2 class="text-lg font-bold">Información del Contrato</h2>
        La Orden de Servicio Fue Ingresada el Dia (Dia / mes / Año)
        y su última actualización fue el (Dia / mes / Año) al Estado (Estado de la Orden)
        el usuario que realizó la última actualización fue (Nombre del Usuario) [si había una Impersonación marcar un Asterisco...]

        Estado actual de La Orden: {{ \App\Models\Contrato::ESTADO_ORDEN[$contract->estado_orden] ?? $contract->estado_orden }}
    </div>

    <!-- Zona de Detalle -->
    <div class="bg-white shadow-md rounded p-4 mb-6">
        <h2 class="text-lg font-bold mb-4">Detalles del Contrato</h2>
        <!-- Flex container con dos columnas -->
        <div class="grid grid-cols-2 gap-4">
            <!-- Primera Columna -->
            <div>
                <h3 class="text-lg font-bold mb-2">Listado de Equipos asignados Actualmente</h3>
                <ul>
                    <li>Equipo 1</li>
                    <li>Equipo 2</li>
                    <li>Equipo 3</li>
                </ul>
            </div>
            <!-- Segunda Columna -->
            <div>
                <h3 class="text-lg font-bold mb-2">Dirección Actual de Los Equipos</h3>
                <ul>
                    <li>Distrito: <b>{{ $contract->direccion->distrito }}</b></li>
                    <li>Dirección: <b>{{ $contract->direccion->calle }}</b></li>
                    <li>Referencia: <b>{{ $contract->direccion->referencia }}</b></li>
                </ul>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4 mt-8">
            <!-- Primera Columna -->
            <div>
                <h3 class="text-lg font-bold mb-2">Datos de Contacto</h3>
                <ul>
                    <li>Familiar de Referencia: <b>{{ $contract->direccion->responsable }}</b> </li>
                    @forelse($contract->telefonos as $telefono)
                        <li>Número: <b>{{ $telefono->numero }}</b></li>
                    @empty
                        <li>No Existen números de Teléfono asignados a este Paciente...</li>
                    @endforelse
                </ul>
            </div>
            <!-- Segunda Columna -->
            <div>
                <h3 class="text-lg font-bold mb-2">Datos Clínicos</h3>
                <ul>
                    <li>Nº Historia Clínica: <b>{{ $contract->ultimoDiagnosticoAprobado()->historia_clinica }}</b></li>
                    <li>Diagnóstico: <b>{{ $contract->ultimoDiagnosticoAprobado()->diagnostico }}</b></li>
                    <li>Dosis: <b>{{ $contract->ultimoDiagnosticoAprobado()->dosis }}</b></li>
                    <li>Frecuencia: <b>{{ $contract->ultimoDiagnosticoAprobado()->frecuencia }}</b></li>
                    <li>Traqueotomía: <b>{{ $contract->traqueotomia == 0 ? 'No' : 'Sí' }}</b></li>
                </ul>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4 mt-8">
            <!-- Primera Columna -->
            <div class="grid grid-cols-2 gap-4 mt-8">
                <!-- Primera Columna -->
                <div>
                    <h3 class="text-lg font-bold mb-2">Datos del Paciente</h3>
                    <ul>
                        <li>Nombre: <b>{{ $contract->paciente->name }}</b></li>
                        <li>Apellidos: <b>{{ $contract->paciente->surname }}</b></li>
                        <li>Edad: <b>{{ $contract->paciente->edad }}</b></li>
                        <li>DNI: <b>{{ $contract->paciente->dni }}</b></li>
                        <li>Origen: <b>{{ \App\Models\Paciente::ORIGEN[$contract->paciente->origen] ?? $contract->paciente->origen }}</b></li>
                        <li>Primer Ingreso: <b>{{ $contract->paciente->primer_ingreso == 1 ? 'Sí' : 'No' }}</b></li>
                    </ul>
                </div>
                <!-- Segunda Columna -->
                <div>
                    <h3 class="text-lg font-bold mb-2">Datos del Personal</h3>
                    <ul>
                        <li>Emisor: <b>{{ $contract->contratoUsuario->solicitante->FullName ?? 'N/A' }}</b></li>
                        <li>Aprobador: <b>{{ $contract->contratoUsuario->aprobador->FullName ?? 'N/A' }}</b></li>
                        <li>Dado de Baja Por: <b>{{ $contract->contratoUsuario->bajador->FullName ?? 'N/A' }}</b></li>
                        <li>Aprobado la Baja por: <b>{{ $contract->contratoUsuario->finalizador->FullName ?? 'N/A' }}</b></li>
                    </ul>
                </div>
            </div>
            <!-- Segunda Columna -->
            <div>
                <h3 class="text-lg font-bold mb-2">Listado de Documentos del Paciente</h3>
                <ul>
                    @forelse($contract->archivos as $archivo)
                        <li class="mb-2 flex justify-between items-center">
                            {{ $archivo->nombre }}
                            <!-- Botón para abrir el modal -->
                            <button wire:click="openModal('{{ $archivo->ruta }}')" class="bg-blue-500 text-white px-4 py-2 rounded">
                                Ver Documento
                            </button>
                        </li>
                    @empty
                        <li>No Existen Documentos Asociados a este Paciente...</li>
                    @endforelse
                </ul>
            </div>
        </div>
        @if($contract->estado_orden == 0)
            <!-- Incluir el componente Livewire OsSolicitado -->
            <livewire:contracts.forms.os-solicitado :contract="$contract" />
        @elseif($contract->estado_orden == 1)
            <!-- Puedes incluir otro formulario o componente para estado_orden == 1 -->
            <p>Otro formulario para estado_orden == 1</p>
        @else
            <p>No hay formularios disponibles para este estado.</p>
        @endif
    </div>

    <!-- Modal para mostrar el documento -->
    @if($showDocument)
        <div id="documentModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-1/2">
                <h2 class="text-lg font-bold mb-4">Documento</h2>

                @if($urlImagen)
                    <!-- Mostrar el documento en un iframe -->
                    <iframe id="documentIframe" src="{{ $urlImagen }}" width="100%" height="400px"></iframe>
                @else
                    <p>No se pudo cargar el documento.</p>
                @endif

                <!-- Botones: cerrar y descargar -->
                <div class="mt-4 flex justify-between">
                    <!-- Botón para cerrar el modal -->
                    <button wire:click="closeModal" class="bg-red-500 text-white px-4 py-2 rounded">
                        Cerrar
                    </button>

                    <!-- Botón de descarga -->
                    <a href="{{ $urlImagen }}" class="bg-blue-500 text-white px-4 py-2 rounded" download>
                        Descargar
                    </a>
                </div>
            </div>
        </div>
    @endif

</div>

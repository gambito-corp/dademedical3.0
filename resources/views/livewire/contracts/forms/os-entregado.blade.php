<div class="container mx-auto py-4">
    <!-- Formulario -->
    <div class="bg-white shadow-md rounded p-4">
        <h2 class="text-lg font-bold mb-4">Orden de Servicio Entregada</h2>

        <!-- Mensajes de estado -->
        @if (session()->has('status'))
            <div class="bg-green-100 text-green-700 p-2 mb-4 rounded">
                {{ session('status') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="bg-red-100 text-red-700 p-2 mb-4 rounded">
                {{ session('error') }}
            </div>
        @endif

        <!-- Mostrar la fecha de solicitud de recojo si ya está asignada -->
        @if($contract->contratoFechas->fecha_solicitud_recojo)
            <div class="mb-4">
                <p><strong>Fecha de Solicitud de Recojo:</strong> {{ \Carbon\Carbon::parse($contract->contratoFechas->fecha_solicitud_recojo)->format('d/m/Y') }}</p>
            </div>
        @endif

        <!-- Formulario -->
        <form wire:submit.prevent="asignarFechaSolicitudRecojo">
            <!-- Fecha de Solicitud de Recojo -->
            <div class="mb-4">
                <label for="fecha_solicitud_recojo" class="block text-sm font-medium text-gray-700">Fecha de Solicitud de Recojo</label>
                <input type="date" wire:model="fecha_solicitud_recojo" id="fecha_solicitud_recojo" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                @error('fecha_solicitud_recojo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Botones -->
            <div class="flex space-x-4">
                <!-- Botón Imprimir Ficha de Recogida -->
                <button type="button" wire:click="imprimirFichaRecogida" class="bg-blue-500 text-white px-4 py-2 rounded">
                    Imprimir Ficha de Recogida
                </button>

                <!-- Botón Asignar Fecha de Solicitud de Recojo -->
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">
                    Asignar Fecha de Solicitud de Recojo
                </button>
            </div>
        </form>
    </div>
</div>

<div class="container mx-auto py-4">
    <!-- Formulario -->
    <div class="bg-white shadow-md rounded p-4">
        <h2 class="text-lg font-bold mb-4">Orden de Servicio en Proceso de Recojo</h2>

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

        <!-- Formulario -->
        <form wire:submit.prevent="finalizarOS">
            <!-- Fecha de Recogida -->
            <div class="mb-4">
                <label for="fecha_recogida" class="block text-sm font-medium text-gray-700">Fecha de Recogida</label>
                <input type="date" wire:model="fecha_recogida" id="fecha_recogida" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                @error('fecha_recogida') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Ficha de Recogida -->
            <div class="mb-4">
                <label for="ficha_recogida" class="block text-sm font-medium text-gray-700">Ficha de Recogida</label>
                <input type="file" wire:model="ficha_recogida" id="ficha_recogida" class="mt-1 block w-full">
                @error('ficha_recogida') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                <!-- Mostrar progreso de carga -->
                <div wire:loading wire:target="ficha_recogida">Cargando...</div>
            </div>

            <!-- Botón Finalizar OS -->
            @if($mostrarBotonFinalizar)
                <div class="flex space-x-4">
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">
                        Finalizar OS
                    </button>
                </div>
            @endif
        </form>
    </div>
</div>

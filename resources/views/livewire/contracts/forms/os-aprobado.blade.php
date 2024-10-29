<div class="container mx-auto py-4">
    <!-- Formulario -->
    <div class="bg-white shadow-md rounded p-4">
        <h2 class="text-lg font-bold mb-4">Actualizar Orden de Servicio</h2>

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
        <form wire:submit.prevent="submit">
            <!-- Fecha de Entrega -->
            <div class="mb-4">
                <label for="fecha_entrega" class="block text-sm font-medium text-gray-700">Fecha de Entrega</label>
                <input type="date" wire:model.live="fecha_entrega" id="fecha_entrega" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                @error('fecha_entrega') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            @if($mostrarInputFiles)
                <!-- Ficha de Instalación -->
                <div class="mb-4">
                    <label for="ficha_instalacion" class="block text-sm font-medium text-gray-700">Ficha de Instalación</label>
                    <input type="file" wire:model.live="ficha_instalacion" id="ficha_instalacion" class="mt-1 block w-full">
                    @error('ficha_instalacion') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                    <!-- Mostrar progreso de carga -->
                    <div wire:loading wire:target="ficha_instalacion">Cargando...</div>
                </div>

                <!-- Guía de Remisión -->
                <div class="mb-4">
                    <label for="guia_remision" class="block text-sm font-medium text-gray-700">Guía de Remisión</label>
                    <input type="file" wire:model.live="guia_remision" id="guia_remision" class="mt-1 block w-full">
                    @error('guia_remision') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                    <!-- Mostrar progreso de carga -->
                    <div wire:loading wire:target="guia_remision">Cargando...</div>
                </div>
            @endif

            <!-- Botones -->
            <div class="flex space-x-4">
                @if($mostrarBotonCancelar)
                    <!-- Botón Anular OS -->
                    <button type="button" wire:click="cancelarOS" class="bg-red-500 text-white px-4 py-2 rounded">
                        Anular OS
                    </button>
                @endif

                @if($mostrarBotonAprobar)
                    <!-- Botón Entregar OS -->
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">
                        Entregar OS
                    </button>
                @endif
            </div>
        </form>
    </div>
</div>

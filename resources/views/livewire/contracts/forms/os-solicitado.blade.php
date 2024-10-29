<div class="container mx-auto py-4">
    <!-- Formulario -->
    <div class="bg-white shadow-md rounded p-4">
        <h2 class="text-lg font-bold mb-4">Asignación de Equipos</h2>

        <!-- Inputs -->
        <div class="grid grid-cols-2 gap-4">
            <!-- Ejemplo de campo con nuevo enfoque para Máquina -->
{{--            --}}
            <div x-data="{ open: false, itemSelected: false, maquinaCodigo: @entangle('maquinaCodigo') }" class="relative">
                <label for="maquina" class="block text-sm font-medium text-gray-700">Máquina</label>

                <!-- Si el item está seleccionado mostramos el P -->
                <template x-if="itemSelected">
                    <div class="flex items-center space-x-2">
                        <p><strong x-text="$wire.maquinaCodigo"></strong></p>
{{--                        --}}
                        <button @click="itemSelected = false; maquinaCodigo = ''; $wire.set('maquina', null)" class="text-red-500">X</button>
                    </div>
                </template>

                <!-- Si el item no está seleccionado mostramos el input -->
                <template x-if="!itemSelected">
                    <div>
                        <input type="text"
                               wire:keydown.debounce.300ms="buscarMaquina"
                               wire:model.debounce.300ms="maquinaCodigo"
                               @focus="open = true"
                               @blur="setTimeout(() => { open = false }, 200)"
                               class="mt-1 block w-full p-2 border border-gray-300 rounded-md"
                               placeholder="Buscar Máquina...">

                        <!-- Desplegable -->
                        @if(!empty($maquinas))
                            <ul x-show="open && $wire.maquinaCodigo !== ''"
                                x-transition
                                class="absolute z-10 bg-white border border-gray-300 mt-1 w-full max-h-40 overflow-y-auto">
                                @foreach($maquinas as $item)
                                    <li wire:click="seleccionarMaquina({{ $item['id'] }})"
                                        @click="open = false; itemSelected = true"
                                        class="p-2 hover:bg-gray-200 cursor-pointer">
                                        {{ $item['codigo'] }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </template>
            </div>

            <!-- Tanque -->
            <div x-data="{ open: false, itemSelected: false, tanqueCodigo: @entangle('tanqueCodigo') }" class="relative">
                <label for="tanque" class="block text-sm font-medium text-gray-700">Tanque</label>

                <template x-if="itemSelected">
                    <div class="flex items-center space-x-2">
                        <p><strong x-text="$wire.tanqueCodigo"></strong></p>
                        <button @click="itemSelected = false; tanqueCodigo = ''; $wire.set('tanque', null)" class="text-red-500">X</button>
                    </div>
                </template>

                <template x-if="!itemSelected">
                    <div>
                        <input type="text"
                               wire:keydown.debounce.300ms="buscarTanque"
                               wire:model.debounce.300ms="tanqueCodigo"
                               @focus="open = true"
                               @blur="setTimeout(() => { open = false }, 200)"
                               class="mt-1 block w-full p-2 border border-gray-300 rounded-md"
                               placeholder="Buscar Tanque...">

                        <!-- Desplegable -->
                        @if(!empty($tanques))
                            <ul x-show="open && $wire.tanqueCodigo !== ''"
                                x-transition
                                class="absolute z-10 bg-white border border-gray-300 mt-1 w-full max-h-40 overflow-y-auto">
                                @foreach($tanques as $item)
                                    <li wire:click="seleccionarTanque({{ $item['id'] }})"
                                        @click="open = false; itemSelected = true"
                                        class="p-2 hover:bg-gray-200 cursor-pointer">
                                        {{ $item['codigo'] }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </template>
            </div>

            <!-- Regulador -->
            <div x-data="{ open: false, itemSelected: false, reguladorCodigo: @entangle('reguladorCodigo') }" class="relative">
                <label for="regulador" class="block text-sm font-medium text-gray-700">Regulador</label>

                <template x-if="itemSelected">
                    <div class="flex items-center space-x-2">
                        <p><strong x-text="$wire.reguladorCodigo"></strong></p>
                        <button @click="itemSelected = false; reguladorCodigo = ''; $wire.set('regulador' = null)" class="text-red-500">X</button>
                    </div>
                </template>

                <template x-if="!itemSelected">
                    <div>
                        <input type="text"
                               wire:keydown.debounce.300ms="buscarRegulador"
                               wire:model.debounce.300ms="reguladorCodigo"
                               @focus="open = true"
                               @blur="setTimeout(() => { open = false }, 200)"
                               class="mt-1 block w-full p-2 border border-gray-300 rounded-md"
                               placeholder="Buscar Regulador...">

                        <!-- Desplegable -->
                        @if(!empty($reguladores))
                            <ul x-show="open && $wire.reguladorCodigo !== ''"
                                x-transition
                                class="absolute z-10 bg-white border border-gray-300 mt-1 w-full max-h-40 overflow-y-auto">
                                @foreach($reguladores as $item)
                                    <li wire:click="seleccionarRegulador({{ $item['id'] }})"
                                        @click="open = false; itemSelected = true"
                                        class="p-2 hover:bg-gray-200 cursor-pointer">
                                        {{ $item['codigo'] }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </template>
            </div>

            <!-- Carrito -->
            <div x-data="{ open: false, itemSelected: false, carritoCodigo: @entangle('carritoCodigo') }" class="relative">
                <label for="carrito" class="block text-sm font-medium text-gray-700">Carrito</label>

                <template x-if="itemSelected">
                    <div class="flex items-center space-x-2">
                        <p><strong x-text="$wire.carritoCodigo"></strong></p>
                        <button @click="itemSelected = false; carritoCodigo = ''; $wire.set('carrito' = null)" class="text-red-500">X</button>
                    </div>
                </template>

                <template x-if="!itemSelected">
                    <div>
                        <input type="text"
                               wire:keydown.debounce.300ms="buscarCarrito"
                               wire:model.debounce.300ms="carritoCodigo"
                               @focus="open = true"
                               @blur="setTimeout(() => { open = false }, 200)"
                               class="mt-1 block w-full p-2 border border-gray-300 rounded-md"
                               placeholder="Buscar Carrito...">

                        <!-- Desplegable -->
                        @if(!empty($carritos))
                            <ul x-show="open && $wire.carritoCodigo !== ''"
                                x-transition
                                class="absolute z-10 bg-white border border-gray-300 mt-1 w-full max-h-40 overflow-y-auto">
                                @foreach($carritos as $item)
                                    <li wire:click="seleccionarCarrito({{ $item['id'] }})"
                                        @click="open = false; itemSelected = true"
                                        class="p-2 hover:bg-gray-200 cursor-pointer">
                                        {{ $item['codigo'] }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </template>
            </div>
        </div>

        <!-- Botones -->
        <div class="mt-6 flex space-x-4">
            @if(!$showDownloadButton && !$showApproveButton)
                <button  wire:click="rejectOS" class="bg-red-500 text-white px-4 py-2 rounded">
                    Rechazar OS
                </button>
            @endif

            @if($showDownloadButton)
                <button wire:click="downloadInstallationSheet" class="bg-blue-500 text-white px-4 py-2 rounded">
                    Descargar Ficha de Instalación
                </button>
            @endif

            @if($showApproveButton)
                <button wire:click="approveOS" class="bg-green-500 text-white px-4 py-2 rounded">
                    Aprobar OS
                </button>
            @endif
        </div>

        @if (session()->has('status'))
            <div class="mt-4 p-2 bg-green-100 text-green-700">
                {{ session('status') }}
            </div>
        @endif
    </div>
</div>

<div class="max-w-2xl mx-auto">
    <form wire:submit="updateIncidence" class="space-y-6">
        <!-- Tipo de Incidencia -->
        <div>
            <label for="tipo_incidencia" class="block text-sm font-medium text-gray-700">
                Tipo de Incidencia
            </label>
            <select wire:model="tipo_incidencia" id="tipo_incidencia"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="">Seleccione tipo</option>
                <option value="fallo de maquina">{{ __('Fallo de Maquina') }}</option>
                <option value="fallo de accesorio">{{ __('Fallo de Accesorio') }}</option>
                <option value="fallo de manipulacion">{{ __('Fallo de Manipulacion') }}</option>
                <option value="otros">{{ __('Otros') }}</option>
            </select>
            @error('tipo_incidencia')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Descripción de la Incidencia -->
        <div>
            <label for="incidencia" class="block text-sm font-medium text-gray-700">
                Descripción
            </label>
            <textarea wire:model="incidencia" id="incidencia" rows="4"
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
            @error('incidencia')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Respuesta -->
        <div>
            <label for="respuesta" class="block text-sm font-medium text-gray-700">
                Respuesta
            </label>
            <textarea wire:model="respuesta" id="respuesta" rows="4"
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
            @error('respuesta')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Tipo de Resolución -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Tipo de Resolución</label>
            <div class="mt-2">
                <label class="inline-flex items-center">
                    <input type="checkbox" wire:model="cambio_concentrador" value="cambio_concentrador">
                    <span class="ml-2">Cambio de Concentrador</span>
                </label>
                <div wire:if="cambio_concentrador">
                    <div x-data="{ open: false, itemSelected: false, concentradorCodigo: @entangle('concentradorCodigo') }" class="relative">
                        <label for="concentrador" class="block text-sm font-medium text-gray-700">Concentrador</label>

                        <!-- Si el item está seleccionado mostramos el P -->
                        <template x-if="itemSelected">
                            <div class="flex items-center space-x-2">
                                <p><strong x-text="$wire.concentradorCodigo"></strong></p>
                                <button @click="itemSelected = false; concentradorCodigo = ''; $wire.set('concentrador', null)" class="text-red-500">X</button>
                            </div>
                        </template>

                        <!-- Si el item no está seleccionado mostramos el input -->
                        <template x-if="!itemSelected">
                            <div>
                                <input type="text"
                                       wire:keydown.debounce.300ms="buscarConcentrador"
                                       wire:model.debounce.300ms="concentradorCodigo"
                                       @focus="open = true"
                                       @blur="setTimeout(() => { open = false }, 200)"
                                       class="mt-1 block w-full p-2 border border-gray-300 rounded-md"
                                       placeholder="Buscar Concentrador...">
                                <!-- Desplegable -->
                                @if(!empty($concentradores))
                                    <ul x-show="open && $wire.concentradorCodigo !== ''"
                                        x-transition
                                        class="absolute z-10 bg-white border border-gray-300 mt-1 w-full max-h-40 overflow-y-auto">
                                        @foreach($concentradores as $concentrador)
                                            <li wire:click="seleccionarConcentrador({{ $concentrador->id }})"
                                                @click="open = false; itemSelected = true"
                                                class="p-2 hover:bg-gray-200 cursor-pointer">
                                                {{ $concentrador->codigo }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <label class="inline-flex items-center">
                <input type="checkbox" wire:model="cambio_tanque" value="cambio_tanque">
                <span class="ml-2">Cambio de Tanque</span>
            </label>
            <div wire:if="cambio_tanque">
                <div x-data="{ open: false, itemSelected: false, tanqueCodigo: @entangle('tanqueCodigo') }" class="relative">
                    <label for="tanque" class="block text-sm font-medium text-gray-700">Tanque</label>

                    <!-- Si el item está seleccionado mostramos el P -->
                    <template x-if="itemSelected">
                        <div class="flex items-center space-x-2">
                            <p><strong x-text="$wire.tanqueCodigo"></strong></p>
                            <button @click="itemSelected = false; tanqueCodigo = ''; $wire.set('tanque', null)" class="text-red-500">X</button>
                        </div>
                    </template>

                    <!-- Si el item no está seleccionado mostramos el input -->
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
                                    @foreach($tanques as $tanque)
                                        <li wire:click="seleccionarTanque({{ $tanque->id }})"
                                            @click="open = false; itemSelected = true"
                                            class="p-2 hover:bg-gray-200 cursor-pointer">
                                            {{ $tanque->codigo }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </template>
                </div>
            </div>

            <label class="inline-flex items-center">
                <input type="checkbox" wire:model="cambio_regulador" value="cambio_regulador">
                <span class="ml-2">Cambio de Regulador</span>
            </label>
            <div wire:if="cambio_regulador">
                <div x-data="{ open: false, itemSelected: false, reguladorCodigo: @entangle('reguladorCodigo') }" class="relative">
                    <label for="regulador" class="block text-sm font-medium text-gray-700">Regulador</label>

                    <!-- Si el item está seleccionado mostramos el P -->
                    <template x-if="itemSelected">
                        <div class="flex items-center space-x-2">
                            <p><strong x-text="$wire.reguladorCodigo"></strong></p>
                            <button @click="itemSelected = false; reguladorCodigo = ''; $wire.set('regulador', null)" class="text-red-500">X</button>
                        </div>
                    </template>

                    <!-- Si el item no está seleccionado mostramos el input -->
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
                                    @foreach($reguladores as $regulador)
                                        <li wire:click="seleccionarRegulador({{ $regulador->id }})"
                                            @click="open = false; itemSelected = true"
                                            class="p-2 hover:bg-gray-200 cursor-pointer">
                                            {{ $regulador->codigo }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </template>
                </div>
            </div>

            <label class="inline-flex items-center">
                <input type="checkbox" wire:model="cambio_carrito" value="cambio_carrito">
                <span class="ml-2">Cambio de Carrito</span>
            </label>
            <div wire:if="cambio_carrito">
                <div x-data="{ open: false, itemSelected: false, carritoCodigo: @entangle('carritoCodigo') }" class="relative">
                    <label for="carrito" class="block text-sm font-medium text-gray-700">Carrito</label>

                    <!-- Si el item está seleccionado mostramos el P -->
                    <template x-if="itemSelected">
                        <div class="flex items-center space-x-2">
                            <p><strong x-text="$wire.carritoCodigo"></strong></p>
                            <button @click="itemSelected = false; carritoCodigo = ''; $wire.set('carrito', null)" class="text-red-500">X</button>
                        </div>
                    </template>

                    <!-- Si el item no está seleccionado mostramos el input -->
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
                                    @foreach($carritos as $carrito)
                                        <li wire:click="seleccionarCarrito({{ $carrito->id }})"
                                            @click="open = false; itemSelected = true"
                                            class="p-2 hover:bg-gray-200 cursor-pointer">
                                            {{ $carrito->codigo }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </template>
                </div>
            </div>

            <label class="inline-flex items-center">
                <input type="checkbox" wire:model="envio_consumible" value="envio_consumible">
                <span class="ml-2">Envío de Consumible</span>
            </label>

            <!-- Subida de Archivo -->
            <div wire:if="cambio_concentrador || cambio_tanque || cambio_regulador || cambio_carrito">
                <label for="archivo_resolucion" class="block text-sm font-medium text-gray-700 mt-2">
                    Archivo de Resolución (opcional)
                </label>
                <input type="file" wire:model="archivo_resolucion" id="archivo_resolucion"
                       class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                @error('archivo_resolucion')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Estado -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Estado</label>
            <div class="mt-2">
                <label class="inline-flex items-center">
                    <input type="checkbox" wire:model="active"
                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <span class="ml-2">Cerrar Incidencia</span>
                </label>
            </div>
        </div>

        <!-- Botones de Acción -->
        <div class="flex justify-end space-x-3 pt-5">
            <button type="button" wire:click="$dispatch('closeModal')"
                    class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                Cancelar
            </button>
            <button type="submit"
                    class="rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700">
                Guardar Cambios
            </button>
        </div>
    </form>
</div>

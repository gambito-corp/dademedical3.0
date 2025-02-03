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
                <option value="tecnica">Técnica</option>
                <option value="administrativa">Administrativa</option>
                <option value="otros">Otros</option>
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

        <!-- Estado -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Estado</label>
            <div class="mt-2">
                <label class="inline-flex items-center">
                    <input type="checkbox" wire:model="active"
                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <span class="ml-2">Activa</span>
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

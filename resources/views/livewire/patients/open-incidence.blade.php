<div>
    <form wire:submit.prevent="submit">
        <div class="mb-4">
            <h2 class="font-semibold text-xl">{{ __('Reporte de Incidencias') }}</h2>
        </div>



        <div class="mb-4">
            <label for="incidenceType" class="block text-sm font-medium text-gray-700">{{ __('Estado de Aprobación') }}</label>
            <select wire:model="incidenceType" id="incidenceType" class="mt-1 block w-full border-gray-300 rounded-md">
                <option value="">{{ __('Seleccione un tipo de incidencia') }}</option>
                <option value="fallo de maquina">{{ __('Fallo de Maquina') }}</option>
                <option value="fallo de accesorio">{{ __('Fallo de Accesorio') }}</option>
                <option value="fallo de manipulacion">{{ __('Fallo de Manipulacion') }}</option>
                <option value="otros">{{ __('Otros') }}</option>
            </select>
            @error('incidenceType')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <textarea name="description" wire:model.defer="description" class="form-control w-full">{{ $description }}</textarea>
        </div>

        <div class="flex justify-end">
            <button type="button" wire:click="close" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">
                {{ __('Cancelar') }}
            </button>
            <button  wire:loading.remove type="submit" class="bg-green-500 text-white px-4 py-2 rounded">
                {{ __('Crear Incidencia') }}
            </button>
            <div wire:loading>
                Saving Incidence...
            </div>
        </div>
    </form>
</div>

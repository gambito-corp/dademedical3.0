<div>
    <form wire:submit.prevent="approve">
        <div class="mb-4">
            <h2 class="font-semibold text-xl">{{ __('Aprobación de Cambio de Dosis') }}</h2>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">{{ __('El Paciente') }}</label>
            <p>{{ $patient->name }} {{ $patient->surname }}</p>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">{{ __('Dosis Actual') }}</label>
            <p>{{ $diagnostico->dosis }}</p>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">{{ __('Nueva Dosis Solicitada') }}</label>
            <p>{{ $doseChangeRequest->dosis }}</p>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">{{ __('Frecuencia Actual') }}</label>
            <p>{{ $diagnostico->frecuencia }}</p>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">{{ __('Nueva Frecuencia Solicitada') }}</label>
            <p>{{ $doseChangeRequest->frecuencia }}</p>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">{{ __('Documento de Cambio de Dosis') }}</label>
            @if($typeDocument === 'pdf')
                <!-- Mostrar el documento en un iframe -->
                <iframe id="documentIframe" src="{{route('archives.get', $archivoId)}}" width="100%" height="400px"></iframe>
            @else
                <img src="{{route('archives.get', $archivoId)}}" alt="">
            @endif
        </div>


        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">{{ __('Comentarios') }}</label>
            <p>{{ $doseChangeRequest->comentarios }}</p>
        </div>

        <div class="mb-4">
            <label for="approvalStatus" class="block text-sm font-medium text-gray-700">{{ __('Estado de Aprobación') }}</label>
            <select wire:model="approvalStatus" id="approvalStatus" class="mt-1 block w-full border-gray-300 rounded-md">
                <option value="approved">{{ __('Aprobar') }}</option>
                <option value="rejected">{{ __('Rechazar') }}</option>
            </select>
            @error('approvalStatus')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end">
            <button type="button" wire:click="close" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">
                {{ __('Cancelar') }}
            </button>
            <button  wire:loading.remove type="submit" class="bg-green-500 text-white px-4 py-2 rounded">
                {{ __('Procesar Solicitud') }}
            </button>
            <div wire:loading>
                Saving Dose...
            </div>
        </div>
    </form>
</div>

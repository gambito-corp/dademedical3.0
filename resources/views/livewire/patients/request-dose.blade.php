<div>
    <form wire:submit.prevent="save">
            <div class="step-two">
                <h2 class="font-semibold text-xl">{{ __('paciente.Medical Information') }}</h2>
                <x-input-field name="historia_clinica" :label="__('paciente.Clinical History')"  :value="$patient->contrato->diagnostico->historia_clinica" />
                <x-input-field name="diagnostico" :label="__('paciente.Diagnosis')"  :value="$patient->contrato->diagnostico->diagnostico" />
                <x-input-field name="dosis" :label="__('paciente.Dose')" type="text" :value="$patient->contrato->diagnostico->dosis" />
                <x-input-field name="frecuencia" :label="__('paciente.Oxygen Hours')" type="text" :value="$patient->contrato->diagnostico->frecuencia" />
                <textarea name="comentarios" >
                    Hola Mundo
                </textarea>
                @error('comentarios')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <x-input-field name="file" :label="__('paciente.Oxygen Therapy Request')" type="file" />
            </div>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">{{ __('paciente.Save') }}</button>
    </form>
</div>

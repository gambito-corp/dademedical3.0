<div>
    <form wire:submit.prevent="save">
        <!-- Step 2: Información Médica -->
        @if($currentStep == 1)
            <div class="step-two">
                <h2 class="font-semibold text-xl">{{ __('paciente.Medical Information') }}</h2>
                <x-input-field name="patientData.tipo_origen" :label="__('paciente.Origin Type')" type="select" :options="[2 => 'Consulta Externa', 3 => 'UDO']" :value="$patientData['tipo_origen']" />
                <x-input-field name="patientData.edad" :label="__('paciente.Age')" type="text" :value="$patientData['edad']" />
            </div>
        @endif

        <!-- Step 3: Información de Contacto -->
        @if($currentStep == 2)
            <div class="step-three">
                <h2 class="font-semibold text-xl">{{ __('paciente.Contact Information') }}</h2>
                <x-input-field name="patientData.familiar_responsable" :label="__('paciente.Responsible Family Member')" type="text" :value="$patientData['familiar_responsable']" />
                @foreach($telefonos as $index => $telefono)
                    <x-input-field name="telefonos.{{ $index }}" :label="__('paciente.Phone') . ' ' . ($index + 1)" type="text" :value="$telefono" />
                    @if($index > 0)
                        <button type="button" wire:click="removeTelefono({{ $index }})" class="bg-red-500 text-white px-2 py-1 rounded mt-1">{{ __('Eliminar') }}</button>
                    @endif
                @endforeach
                <button type="button" wire:click="addTelefono" class="bg-blue-500 text-white px-2 py-1 rounded mt-2">{{ __('paciente.Add Phone') }}</button>

                @if($errors->has('telefonos'))
                    <p class="mt-2 text-sm text-red-600">{{ $errors->first('telefonos') }}</p>
                @endif

                <!-- Campo para subir 'otros' archivos -->
                <x-input-field name="otros" :label="__('paciente.Others')" type="file" />
            </div>
        @endif

        <div class="flex justify-between mt-4">
            @if($currentStep > 1)
                <button type="button" wire:click="previousStep" class="bg-gray-500 text-white px-4 py-2 rounded">{{ __('paciente.Previous') }}</button>
            @endif

            @if($currentStep < $totalSteps)
                <button type="button" wire:click="nextStep" class="bg-blue-500 text-white px-4 py-2 rounded">{{ __('paciente.Next') }}</button>
            @else
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">{{ __('paciente.Save') }}</button>
            @endif
        </div>
    </form>
</div>

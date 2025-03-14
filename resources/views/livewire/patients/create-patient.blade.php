<div>
    <form wire:submit.prevent="save">
        <!-- Step 1: Información Básica -->
        @if($currentStep == 1)
            <div class="step-one">
                <h2 class="font-semibold text-xl">{{ __('paciente.Basic Information') }}</h2>
                <x-input-field name="paciente.hospital" :label="__('paciente.Hospital')" type="select" :options="$hospitals" />
                <x-input-field name="paciente.documento_tipo" :label="__('paciente.Document Type')" type="select" :options="['DNI' => 'DNI', 'Pasaporte']" />
                <x-input-field name="paciente.numero_documento" :label="__('paciente.Document Number')" type="text" />

                <label for="paciente.nombres" class="block text-sm font-medium text-gray-700">nombres</label>
                <input
                    type="text"
                    name="paciente.nombres"
                    id="paciente.nombres"
                    wire:model.live.lazy="paciente.nombres"
                    value="{{$paciente['nombres']}}"
                    class="mt-1 block w-full border-gray-300
                   focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                >
                <label for="paciente.apellidos" class="block text-sm font-medium text-gray-700">apellidos</label>
                <input
                    type="text"
                    name="paciente.apellidos"
                    id="paciente.apellidos"
                    wire:model="paciente.apellidos"
                    value="{{$paciente['apellidos']}}"
                    class="mt-1 block w-full border-gray-300
                   focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                >
            </div>
        @endif

        <!-- Step 2: Información Médica -->
        @if($currentStep == 2)
            <div class="step-two">
                <h2 class="font-semibold text-xl">{{ __('paciente.Medical Information') }}</h2>
                <x-input-field name="paciente.tipo_origen" :label="__('paciente.Origin Type')" type="select" :options="[2 => 'Consulta Externa', 3 => 'UDO']" />
                <x-input-field name="paciente.edad" :label="__('paciente.Age')" type="text" />
                <x-input-field name="paciente.traqueotomia" :label="__('paciente.Tracheostomy')" type="select" :options="[1 => 'Sí', 0 => 'No']" />
                <x-input-field name="paciente.horas_oxigeno" :label="__('paciente.Oxygen Hours')" type="text" />
                <x-input-field name="paciente.dosis" :label="__('paciente.Dose')" type="text" />
                <x-input-field name="paciente.diagnostico" :label="__('paciente.Diagnosis')" type="text" />
                <x-input-field name="paciente.historia_clinica" :label="__('paciente.Clinical History')" type="text" />
            </div>
        @endif

        <!-- Step 3: Información de Contacto -->
        @if($currentStep == 3)
            <div class="step-three">
                <h2 class="font-semibold text-xl">{{ __('paciente.Contact Information') }}</h2>
                <x-input-field name="paciente.distrito" :label="__('paciente.District')" type="select" :options="$distritos" />
                <x-input-field name="paciente.direccion" :label="__('paciente.Address')" type="text" />
                <x-input-field name="paciente.referencia" :label="__('paciente.Reference')" type="text" />
                <x-input-field name="paciente.familiar_responsable" :label="__('paciente.Responsible Family Member')" type="text" />
                @foreach($telefonos as $index => $telefono)
                    <x-input-field name="telefonos.{{ $index }}" :label="__('paciente.Phone') . ' ' . ($index + 1)" type="text" />
                    @if($index > 0)
                        <button type="button" wire:click="removeTelefono({{ $index }})" class="bg-red-500 text-white px-2 py-1 rounded mt-1">{{ __('Eliminar') }}</button>
                    @endif
                @endforeach
                <button type="button" wire:click="addTelefono" class="bg-blue-500 text-white px-2 py-1 rounded mt-2">{{ __('paciente.Add Phone') }}</button>

                @if($errors->has('telefonos'))
                    <p class="mt-2 text-sm text-red-600">{{ $errors->first('telefonos') }}</p>
                @endif
            </div>
        @endif

        <!-- Step 4: Documentación -->
        @if($currentStep == 4)
            <div class="step-four">
                <h2 class="font-semibold text-xl">{{ __('paciente.Documentation') }}</h2>
                <x-input-field name="paciente.solicitud_oxigenoterapia" :label="__('paciente.Oxygen Therapy Request')" type="file" />
                <x-input-field name="paciente.declaracion_jurada" :label="__('paciente.Affidavit')" type="file" />
                <x-input-field name="paciente.documento_identidad" :label="__('paciente.Identity Document')" type="file" />
                <x-input-field name="paciente.documento_identidad_cuidador" :label="__('paciente.Caregiver Identity Document')" type="file" />
                <x-input-field name="paciente.croquis" :label="__('paciente.Sketch')" type="file" />
                <x-input-field name="paciente.otros" :label="__('paciente.Others')" type="file" />
            </div>
        @endif

        <div class="flex justify-between mt-4">
            @if($currentStep > 1)
                <button type="button" wire:click="previousStep" class="bg-gray-500 text-white px-4 py-2 rounded">{{ __('paciente.Previous') }}</button>
            @endif

            @if($currentStep < $totalSteps)
                <button type="button" wire:click="nextStep" class="bg-blue-500 text-white px-4 py-2 rounded">{{ __('paciente.Next') }}</button>
            @else
                <button wire:loading.remove type="submit" class="bg-green-500 text-white px-4 py-2 rounded">{{ __('paciente.Save') }}</button>

                <div wire:loading>
                    Creating Patient...
                </div>
            @endif
        </div>
    </form>
</div>

<div>
    <form wire:submit.prevent="save">
        <!-- Step 1: Información Básica -->
        @if($currentStep == 1)
            <div class="step-one">
                <h2 class="font-semibold text-xl">Información Básica</h2>
                <x-input-field name="paciente.hospital" label="Hospital" type="select" :options="$hospitals" />
                <x-input-field name="paciente.documento_tipo" label="Documento de Identidad / Pasaporte" type="select" :options="['DNI' => 'DNI', 'Pasaporte' => 'Pasaporte']" />
                <x-input-field name="paciente.numero_documento" label="Número de Documento" />
                <x-input-field name="paciente.nombres" label="Nombres" />
                <x-input-field name="paciente.apellidos" label="Apellidos" />
            </div>
        @endif

        <!-- Step 2: Información Médica -->
        @if($currentStep == 2)
            <div class="step-two">
                <h2 class="font-semibold text-xl">Información Médica</h2>
                <x-input-field name="paciente.tipo_origen" label="Tipo de Origen" type="select" :options="['Consulta Externa', 'UDO']" />
                <x-input-field name="paciente.edad" label="Edad" />
                <x-input-field name="paciente.traqueotomia" label="Traqueotomía" type="select" :options="[1 => 'Sí', 0 => 'No']" />
                <x-input-field name="paciente.horas_oxigeno" label="Horas de Oxígeno" />
                <x-input-field name="paciente.dosis" label="Dosis" />
                <x-input-field name="paciente.diagnostico" label="Diagnóstico" />
                <x-input-field name="paciente.historia_clinica" label="Historia Clínica" />
            </div>
        @endif

        <!-- Step 3: Información de Contacto -->
        @if($currentStep == 3)
            <div class="step-three">
                <h2 class="font-semibold text-xl">Información de Contacto</h2>
                <x-input-field name="paciente.distrito" label="Distrito" type="select" :options="['Distrito 1', 'Distrito 2']" />
                <x-input-field name="paciente.direccion" label="Dirección" />
                <x-input-field name="paciente.referencia" label="Referencia" />
                <x-input-field name="paciente.familiar_responsable" label="Familiar Responsable" />
                <x-input-field name="paciente.telefono1" label="Teléfono 1" />
                <x-input-field name="paciente.telefono2" label="Teléfono 2" />
            </div>
        @endif

        <!-- Step 4: Documentación -->
        @if($currentStep == 4)
            <div class="step-four">
                <h2 class="font-semibold text-xl">Documentación</h2>
                <x-input-field name="paciente.solicitud_oxigenoterapia" label="Solicitud de Oxigenoterapia" type="file" />
                <x-input-field name="paciente.declaracion_jurada" label="Declaración Jurada de Domicilio" type="file" />
                <x-input-field name="paciente.documento_identidad" label="Documento de Identidad" type="file" />
                <x-input-field name="paciente.documento_identidad_cuidador" label="Documento de Identidad del Cuidador" type="file" />
                <x-input-field name="paciente.croquis" label="Croquis" type="file" />
                <x-input-field name="paciente.otros" label="Otros" type="file" />
            </div>
        @endif

        <div class="flex justify-between mt-4">
            @if($currentStep > 1)
                <button type="button" wire:click="previousStep" class="bg-gray-500 text-white px-4 py-2 rounded">Anterior</button>
            @endif

            @if($currentStep < $totalSteps)
                <button type="button" wire:click="nextStep" class="bg-blue-500 text-white px-4 py-2 rounded">Siguiente</button>
            @else
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Guardar</button>
            @endif
        </div>
    </form>
</div>

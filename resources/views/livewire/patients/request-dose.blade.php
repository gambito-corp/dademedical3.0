<div>
    <form wire:submit.prevent="save">
        <div class="step-two">
            <h2 class="font-semibold text-xl">{{ __('paciente.Medical Information') }}</h2>
            <x-input-field name="historia_clinica" :label="__('paciente.Clinical History')" :value="$patient->contrato->diagnostico->historia_clinica" />
            <x-input-field name="diagnostico" :label="__('paciente.Diagnosis')" :value="$patient->contrato->diagnostico->diagnostico" />
            <x-input-field name="dosis" :label="__('paciente.Dose')" type="text" :value="$patient->contrato->diagnostico->dosis" />
            <x-input-field name="frecuencia" :label="__('paciente.Oxygen Hours')" type="text" :value="$patient->contrato->diagnostico->frecuencia" />
            <textarea name="comentarios" wire:model.defer="comentarios" class="form-control w-full">{{ $comentarios }}</textarea>
            @error('comentarios')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
            <x-input-field name="file" :label="__('paciente.Oxygen Therapy Request')" type="file" wire:model="file" />
            @error('file')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">{{ __('paciente.Save') }}</button>

        @if($archivosCambioDosis->isNotEmpty())
            <div class="file-slider relative w-full max-w-2xl mx-auto mt-6">
                <h4 class="text-lg font-bold mb-4">{{ __('Archivos de Cambio de Dosis') }}</h4>

                <!-- Slider -->
                <div class="overflow-hidden relative">
                    <!-- Contenedor de las imágenes o PDFs -->
                    <div class="whitespace-nowrap transition-all duration-300 ease-in-out">

                        @foreach($archivosCambioDosis as $index => $archivo)
                            <!-- Cada archivo será un "slide" -->
                            <input type="radio" name="slider" id="slide-{{ $index }}" class="hidden peer" @if($index === 0) checked @endif />
                            <div class="peer-checked:block hidden w-full">
                                @if (in_array(pathinfo($archivo->ruta, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']))
                                    <!-- Visualización de imagen -->
                                    <img src="{{ $this->showDocument($archivo->ruta) }}" alt="{{ $archivo->nombre }}" class="w-full h-auto">
                                @elseif(pathinfo($archivo->ruta, PATHINFO_EXTENSION) === 'pdf')
                                    <!-- Visualización de PDF -->
                                    <iframe src="{{ $this->showDocument($archivo->ruta) }}" class="w-full h-96"></iframe>
                                @else
                                    <!-- Enlace de descarga si el archivo no es imagen ni PDF -->
                                    <a href="{{ $this->showDocument($archivo->ruta) }}" target="_blank" class="text-blue-500 underline">
                                        {{ __('Ver archivo') }}
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Controles del slider (botones para cambiar entre imágenes) -->
                <div class="flex justify-center space-x-4 mt-4">
                    @foreach($archivosCambioDosis as $index => $archivo)
                        <label for="slide-{{ $index }}" class="cursor-pointer">
                            <span class="block w-3 h-3 rounded-full @if($index === 0) bg-blue-500 @else bg-gray-400 @endif"></span>
                        </label>
                    @endforeach
                </div>
            </div>
        @else
            <p>{{ __('No hay archivos de cambio de dosis asociados a este contrato.') }}</p>
        @endif

    </form>
</div>

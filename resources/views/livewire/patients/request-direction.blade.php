<div>
    <form wire:submit.prevent="save">
        <div class="step-three">
            <h2 class="font-semibold text-xl">{{ __('paciente.Contact Information') }}</h2>
            <x-input-field name="distrito" :label="__('paciente.District')" type="select" :options="$distritos" />
            <x-input-field name="direccion" :label="__('paciente.Address')" type="text" />
            <x-input-field name="referencia" :label="__('paciente.Reference')" type="text" />
            <x-input-field name="responsable" :label="__('paciente.Responsible Family Member')" type="text" />
            <x-input-field name="file" :label="'documento de cambio de direccion' " type="file" wire:model="file" />
            @error('file')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <button wire:loading.remove type="submit" class="bg-green-500 text-white px-4 py-2 rounded">{{ __('paciente.Save') }}</button>
        <div wire:loading>
            Requesting new Direction...
        </div>

        @if($archivosCambioDireccion->isNotEmpty())
            <div class="file-slider relative w-full max-w-2xl mx-auto mt-6">
                <h4 class="text-lg font-bold mb-4">{{ __('Archivos de Cambio de Dosis') }}</h4>

                <!-- Slider -->
                <div class="overflow-hidden relative">
                    <!-- Contenedor de las imágenes o PDFs -->
                    <div class="whitespace-nowrap transition-all duration-300 ease-in-out">

                        @foreach($archivosCambioDireccion as $index => $archivo)
                            @if(in_array(pathinfo($archivo->ruta, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']))
                                <img src="{{route('archives.get', $this->encrypter($archivo->id))}}" alt="">
                            @else
                                <iframe id="documentIframe" src="{{route('archives.get', $this->encrypter($archivo->id))}}" width="100%" height="400px"></iframe>
                            @endif
                        @endforeach
                    </div>
                </div>

            </div>
        @else
            <p>{{ __('No hay archivos de cambio de dosis asociados a este contrato.') }}</p>
        @endif

    </form>
</div>

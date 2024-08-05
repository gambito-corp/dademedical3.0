<div>
    <form wire:submit.prevent="save" enctype="multipart/form-data">
        <div class="mb-4 flex flex-wrap items-center">
            <div class="w-full md:w-6/12 md:pr-2 mb-4 md:mb-0">
                <label for="hospital_id" class="block mb-1 text-gray-700">{{ __('users.hospital') }}</label>
                <x-select id="hospital_id" name="hospital_id" class="w-full" wire:model="usuario.hospital">
                    @foreach($hospitals as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </x-select>
                <x-error for="usuario.hospital" />
            </div>
            <div class="w-full md:w-6/12 md:pr-2 mb-4 md:mb-0">
                <label for="role" class="block mb-1 text-gray-700">{{ __('users.roles') }}</label>
                <x-select id="role" name="role" class="w-full" wire:model.defer="usuario.role">
                    @foreach($roles as $id => $rol)
                        <option value="{{ $id }}">{{ $rol }}</option>
                    @endforeach
                </x-select>
                <x-error for="usuario.role" />
            </div>
            <!-- Resto de los campos -->
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <x-label for="usuario.name" :value="__('users.name')" />
                <x-input id="usuario.name" class="block mt-1 w-full" type="text" name="usuario.name" wire:model="usuario.name"/>
                <x-error for="usuario.name" />
            </div>

            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <x-label for="usuario.surname" :value="__('users.surname')" />
                <x-input id="usuario.surname" class="block mt-1 w-full" type="text" name="usuario.surname" wire:model="usuario.surname"/>
                <x-error for="usuario.surname" />
            </div>

            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <x-label for="usuario.email" :value="__('users.email')" />
                <x-input id="usuario.email" class="block mt-1 w-full" type="email" email="usuario.email" wire:model="usuario.email"/>
                <x-error for="usuario.email" />
            </div>

            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <x-label for="usuario.username" :value="__('users.username')" />
                <x-input id="usuario.username" class="block mt-1 w-full" type="text" name="usuario.username" wire:model="usuario.username"/>
                <x-error for="usuario.username" />
            </div>
        </div>

        <!-- Omitir campos de restablecimiento de contraseña si no se proporciona funcionalidad de restablecimiento de contraseña -->

        <input type="submit" id="theme-toggle" class="px-4 py-2 rounded bg-blue-500 text-white hover:bg-blue-600 focus:outline-none transition-colors" value="{{ __('users.edit') }}" />
        <x-danger-button wire:click="close">
            {{ __('users.close') }}
        </x-danger-button>
    </form>
</div>

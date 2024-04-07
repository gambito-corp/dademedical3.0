<div>
    <form wire:submit="save" enctype="multipart/form-data">
        <div class="mb-4 flex flex-wrap items-center">
                <div class="w-full md:w-6/12 md:pr-2 mb-4 md:mb-0">
                    <label for="hospital_id" class="block mb-1 text-gray-700">Hospital</label>
                    <x-select id="hospital_id" name="hospital_id" class="w-full" wire:model.live="usuario.hospital">
                        @foreach($hospitals as $id => $name)
                            <option value="{{ $id }}" {{ old('hospital_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </x-select>
                </div>
                <div class="w-full md:w-6/12 md:pr-2 mb-4 md:mb-0">
                    <label for="rol" class="block mb-1 text-gray-700">Roles</label>
                    <x-select id="rol" name="rol" class="w-full" wire:model.live="usuario.role">
                        @foreach($roles as $id => $rol)
                            <option value="{{ $id }}" {{ old('hospital_id') == $id ? 'selected' : '' }}>{{ $rol }}</option>
                        @endforeach
                    </x-select>
                </div>
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <x-label for="usuario.name" :value="'Nombre'" />
                    <x-input id="usuario.name" class="block mt-1 w-full" type="text" name="usuario.name" :value="old('usuario.name')" wire:model.live="usuario.name" />
                    <x-error for="usuario.name" />
                </div>

                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <x-label for="usuario.surname" :value="'Apellido'" />
                    <x-input id="usuario.surname" class="block mt-1 w-full" type="text" name="usuario.surname" :value="old('usuario.surname')" wire:model.live="usuario.surname" />
                    <x-error for="usuario.surname" />
                </div>
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <x-label for="usuario.username" :value="'Username'" />
                    <x-input id="usuario.username" class="block mt-1 w-full" type="text" name="usuario.username" :value="old('usuario.username')" wire:model.live="usuario.username" />
                    <x-error for="usuario.username" />
                </div>
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <x-label for="usuario.email" :value="'Email'" />
                    <x-input id="usuario.email" class="block mt-1 w-full" type="email" email="usuario.email" :value="old('usuario.email')" wire:model.live="usuario.email" />
                    <x-error for="usuario.email" />
                </div>
        </div>

        <div class="mb-4 flex flex-wrap items-center">
            <div x-data="{ showPassword: false }" class="w-full md:w-6/12 mb-4 md:mb-0 md:pr-2 relative">
                <x-label for="password" :value="'Contraseña'" />
                <div class="relative">
                    <input type="password" id="password" name="password"
                           x-bind:type="showPassword ? 'text' : 'password'"
                           class="w-full border rounded-md py-2 px-3 focus:outline-none {{$errors->first('usuario.password') ? 'border-red-500' : ' border-gray-300'}}"
                           wire:model.live="usuario.password"
                    >
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <button type="button" x-on:click="showPassword = !showPassword" class="focus:outline-none" tabindex="-1">
                            <i x-show="!showPassword" class="far fa-eye text-gray-400"></i>
                            <i x-show="showPassword" class="far fa-eye-slash text-gray-400"></i>
                        </button>
                    </div>
                    <x-error for="usuario.password" />
                </div>
            </div>

            <div x-data="{ showConfirmPassword: false }" class="w-full md:w-6/12 mb-4 md:mb-0 md:pr-2 relative">
                <x-label for="password_confirmation" :value="'Confirmar Contraseña'" />
                <div class="relative">
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           x-bind:type="showConfirmPassword ? 'text' : 'password'"
                           class="w-full border rounded-md py-2 px-3 focus:outline-none {{$errors->first('usuario.password_confirmation') ? 'border-red-500' : ' border-gray-300'}}"
                           wire:model.live="usuario.password_confirmation">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <button type="button" x-on:click="showConfirmPassword = !showConfirmPassword" class="focus:outline-none" tabindex="-1">
                            <i x-show="!showConfirmPassword" class="far fa-eye text-gray-400"></i>
                            <i x-show="showConfirmPassword" class="far fa-eye-slash text-gray-400"></i>
                        </button>
                    </div>
                    <x-error for="password_confirmation" />
                </div>
            </div>
        </div>
        <div class="mb-4 flex flex-wrap items-center">

            <x-label for="usuario.profile_photo_path" :value="'Foto'" />
            <input type="file" id="usuario.profile_photo_path" name="usuario.profile_photo_path" class="w-full border rounded-md py-2 px-3 focus:outline-none @if((old('usuario.profile_photo_path') && !$errors->first('usuario.profile_photo_path'))) border-green-500 @elseif($errors->first('usuario.profile_photo_path')) border-red-500  @else border-gray-300 @endif" value="{{ old('usuario.profile_photo_path') }}" wire:model.live="usuario.profile_photo_path" />
            <x-error for="profile_photo_path" />
        </div>
        <input type="submit" id="theme-toggle" class="px-4 py-2 rounded bg-blue-500 text-white hover:bg-blue-600 focus:outline-none transition-colors" value="Crear" />
        <x-danger-button wire:click="close">
            {{ __('Cerrar') }}
        </x-danger-button>
    </form>
</div>

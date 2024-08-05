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

        <div class="mb-4 flex flex-wrap items-center">
            <div x-data="{ showPassword: false }" class="w-full md:w-6/12 mb-4 md:mb-0 md:pr-2 relative">
                <x-label for="password" :value="__('users.password')" />
                <div class="relative">
                    <input type="password" id="password" name="password"
                           x-bind:type="showPassword ? 'text' : 'password'"
                           class="w-full border rounded-md py-2 px-3 focus:outline-none {{$errors->first('usuario.password') ? 'border-red-500' : ' border-gray-300'}}"
                           wire:model="usuario.password"
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
                <x-label for="password_confirmation" :value="__('users.confirm_password')" />
                <div class="relative">
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           x-bind:type="showConfirmPassword ? 'text' : 'password'"
                           class="w-full border rounded-md py-2 px-3 focus:outline-none {{$errors->first('usuario.password_confirmation') ? 'border-red-500' : ' border-gray-300'}}"
                           wire:model="usuario.password_confirmation">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <button type="button" x-on:click="showConfirmPassword = !showConfirmPassword" class="focus:outline-none" tabindex="-1">
                            <i x-show="!showConfirmPassword" class="far fa-eye text-gray-400"></i>
                            <i x-show="showConfirmPassword" class="far fa-eye-slash text-gray-400"></i>
                        </button>
                    </div>
                    <x-error for="usuario.password_confirmation" />
                </div>
            </div>
        </div>
        <div class="mb-4 flex flex-wrap items-center">
            <x-label for="usuario.profile_photo_path" :value="__('users.photo')" />
            <input type="file" id="usuario.profile_photo_path" name="usuario.profile_photo_path" class="w-full border rounded-md py-2 px-3 focus:outline-none @if((old('usuario.profile_photo_path') && !$errors->first('usuario.profile_photo_path'))) border-green-500 @elseif($errors->first('usuario.profile_photo_path')) border-red-500  @else border-gray-300 @endif" value="{{ old('usuario.profile_photo_path') }}" wire:model="usuario.profile_photo_path" />
            <x-error for="usuario.profile_photo_path" />
        </div>
        <input type="submit" id="theme-toggle" class="px-4 py-2 rounded bg-blue-500 text-white hover:bg-blue-600 focus:outline-none transition-colors" value="{{ __('users.create') }}" />
        <x-danger-button wire:click="close">
            {{ __('users.close') }}
        </x-danger-button>
    </form>
</div>

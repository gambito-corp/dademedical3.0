<x-app-layout>
    <x-slot name="header">
        <div class="flex">
            <a href="{{route('usuarios.index')}}" class="mr-4 leading-tight relative inline cursor-pointer text-xl font-medium before:bg-violet-600  before:absolute before:-bottom-1 before:block before:h-[2px] before:w-full before:origin-bottom-right before:scale-x-0 before:transition before:duration-300 before:ease-in-out hover:before:origin-bottom-left hover:before:scale-x-100">
                <i class="fas fa-arrow-left mr-2"></i> {{__('Back')}}
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('users.User Edit') }} {{ $usuario->name }} {{ $usuario->surname }}
            </h2>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="mt-5 md:mt-0 md:col-span-2">
                <div class="bg-gray-100 transition-colors duration-300">
                    <div class="container mx-auto p-4">
                        <div class="bg-white shadow rounded-lg p-6">
                            <h1 class="text-xl font-semibold mb-4 text-gray-900">Informacion Personal</h1>
                            <form action="{{ route('usuarios.actualizar', $usuario) }}" method="POST"  autocomplete="off">
                                @method('PUT')
                                @csrf
                                <div class="mb-4 flex flex-wrap items-center">
                                    <div class="w-full md:w-6/12 md:pr-2 mb-4 md:mb-0">
                                        <label for="hospital_id" class="block mb-1 text-gray-700">Hospital</label>
                                        <select id="hospital_id" name="hospital_id" class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:border-blue-500 transition-height duration-1000 ease-in-out">
                                            @foreach($hospitals as $id => $name)
                                                <option value="{{ $id }}" {{ (old('hospital_id') ?? $usuario->hospital_id) == $id ? 'selected' : '' }}>
                                                    {{ $name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="w-full md:w-6/12 md:pr-2 mb-4 md:mb-0">
                                        <label for="rol" class="block mb-1 text-gray-700">Roles</label>
                                        <select id="rol" name="rol" class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:border-blue-500 transition-height duration-1000 ease-in-out">
                                            @foreach($roles as $id => $rol)
                                                <option value="{{ $id }}" {{ (old('rol') ?? $usuario->roles->first()->id) == $id ? 'selected' : '' }}>{{ $rol }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <livewire:components.atoms.input-text :name="'name'" :label="'Nombre'" :error="$errors->first('name')" :columns="5" :success="(old('name') && !$errors->has('surname'))" :value="(old('name') ?? $usuario->name)"/>
                                    <livewire:components.atoms.input-text :name="'surname'" :label="'Apellido'" :error="$errors->first('surname')" :columns="5" :success="(old('surname') && !$errors->has('surname'))" :value="(old('surname') ?? $usuario->surname)"/>
                                </div>
                                <div class="mb-4 flex flex-wrap items-center">
                                    <livewire:components.atoms.input-text :name="'email'" :label="'Email'" :error="$errors->first('email')" :columns="6" :success="(old('email') && !$errors->has('email'))" :value="(old('email') ?? $usuario->email)"/>
                                    <livewire:components.atoms.input-text :name="'username'" :label="'Nombre de Usuario'" :error="$errors->first('username')" :columns="6" :success="(old('username') && !$errors->has('username'))" :value="(old('username') ?? $usuario->username)"/>
                                </div>
                                <div class="mb-4 flex flex-wrap items-center">

                                    <div x-data="{ showPassword: false }" class="w-full md:w-6/12 mb-4 md:mb-0 md:pr-2 relative">
                                        <label for="password" class="block mb-1 text-gray-700">Contraseña</label>
                                        <div class="relative">
                                            <input type="password" id="password" name="password"
                                                   x-bind:type="showPassword ? 'text' : 'password'"
                                                   class="w-full border rounded-md py-2 px-3 focus:outline-none @if((old('password') && !$errors->first('password'))) border-green-500 @elseif($errors->first('password')) border-red-500  @else border-gray-300 @endif"
                                                   value="{{ old('password') }}" autocomplete="new-password">
                                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                <button type="button" x-on:click="showPassword = !showPassword" class="focus:outline-none" tabindex="-1">
                                                    <i x-show="!showPassword" class="far fa-eye text-gray-400"></i>
                                                    <i x-show="showPassword" class="far fa-eye-slash text-gray-400"></i>
                                                </button>
                                            </div>
                                            @if($errors->first('password'))
                                                <p class="absolute inset-y-0 left-2 h-1 top-0 flex items-start pr-3 text-red-500 text-xs transition-opacity duration-500 ease-in-out opacity-100 animate-slide-in" style="top: 10%;">
                                                    {{ $errors->first('password') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>

                                    <div x-data="{ showConfirmPassword: false }" class="w-full md:w-6/12 mb-4 md:mb-0 md:pr-2 relative">
                                        <label for="password_confirmation" class="block mb-1 text-gray-700">Confirmar Contraseña</label>
                                        <div class="relative">
                                            <input type="password" id="password_confirmation" name="password_confirmation"
                                                   x-bind:type="showConfirmPassword ? 'text' : 'password'"
                                                   class="w-full border rounded-md py-2 px-3 focus:outline-none @if((old('password_confirmation') && !$errors->first('password_confirmation'))) border-green-500 @elseif($errors->first('password_confirmation')) border-red-500  @else border-gray-300 @endif"
                                                   value="{{old('password_confirmation')}}" autocomplete="off">
                                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                <button type="button" x-on:click="showConfirmPassword = !showConfirmPassword" class="focus:outline-none" tabindex="-1">
                                                    <i x-show="!showConfirmPassword" class="far fa-eye text-gray-400"></i>
                                                    <i x-show="showConfirmPassword" class="far fa-eye-slash text-gray-400"></i>
                                                </button>
                                            </div>
                                            @if($errors->first('password_confirmation'))
                                                <p class="absolute inset-y-0 left-2 h-1 top-0 flex items-start pr-3 text-red-500 text-xs transition-opacity duration-500 ease-in-out opacity-100 animate-slide-in" style="top: 10%;">
                                                    {{ $errors->first('password_confirmation') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <input type="submit" id="theme-toggle" class="px-4 py-2 rounded bg-blue-500 text-white hover:bg-blue-600 focus:outline-none transition-colors" value="Crear" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


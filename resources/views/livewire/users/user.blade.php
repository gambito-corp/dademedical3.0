@push('body-classes') id_usuarios @endpush
<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('users.users_panel') }}
        </h2>
    </x-slot>
    <div class="py-4">
        <div class="max-w-screen mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 space-y-4">
                    <div class="flex justify-end space-x-2">
                        <button
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-xl"
                            title="{{ __('users.create_user') }}"
                            wire:click="openModal('create')">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <div class="flex justify-between space-x-2">
                        <div class="{{ $currentFilter == 'active' ? 'bg-blue-700 text-white' : 'bg-white text-blue-500 border border-blue-500 hover:text-white hover:border-0 ' }} w-1/3 p-2 hover:bg-blue-700 font-bold py-2 px-4 rounded-xl transition-all duration-300" wire:click="changeUsers('active')">
                            <span>{{ __('users.active_users') }}</span>
                        </div>
                        <div class="{{ $currentFilter == 'inactive' ? 'bg-blue-700 text-white' : 'bg-white text-blue-500 border border-blue-500 hover:text-white hover:border-0 ' }} w-1/3 p-2 hover:bg-blue-700 font-bold py-2 px-4 rounded-xl transition-all duration-300" wire:click="changeUsers('inactive')">
                            <span>{{ __('users.inactive_users') }}</span>
                        </div>
                        <div class="{{ $currentFilter == 'deleted' ? 'bg-blue-700 text-white' : 'bg-white text-blue-500 border border-blue-500 hover:text-white hover:border-0 ' }} w-1/3 p-2 hover:bg-blue-700 font-bold py-2 px-4 rounded-xl transition-all duration-300" wire:click="changeUsers('deleted')">
                            <span>{{ __('users.deleted_users') }}</span>
                        </div>
                    </div>
                    <div class="flex justify-between space-x-2">
                        <div class="w-1/2 mr-2">
                            <div>
                                <label for="inputSelect"></label>
                                <input
                                    class="border border-gray-300 p-2 w-full rounded-xl"
                                    name="inputSelect"
                                    id="inputSelect"
                                    type="text"
                                    placeholder="{{ __('users.pagination_placeholder') }}"
                                    wire:model="paginate"
                                    wire:click.self="showPagination">
                                @if($showDropdown)
                                    <div class="border border-gray-300 max-h-48 overflow-y-auto">
                                        @forelse($paginacion as $key => $item)
                                            <div class="p-2 hover:bg-gray-100" wire:click="selectedPaginate('{{ $item }}')" wire:key="{{$key}}">{{ $item }}</div>
                                        @empty
                                            <div class="p-2">{{ __('users.no_users') }}</div>
                                        @endforelse
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="w-1/2 flex items-center space-x-4">
                            <div class="w-full ml-2">
                                <label for="inputSelectSearch"></label>
                                <input
                                    class="border border-gray-300 p-2 w-full rounded-xl"
                                    name="inputSelectSearch"
                                    id="inputSelectSearch"
                                    type="text"
                                    placeholder="{{ __('users.search_placeholder') }}"
                                    wire:model.live="search">
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between space-x-2">
                        <div class="min-w-full">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider ">
                                        {{ __('users.order') }}
                                    </th>
                                    <th wire:click="sortBy('name')" class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                        {{ __('users.name') }} @if($orderColumn == 'name') <i class="fas fa-sort-{{$orderDirection == 'asc' ? 'up' : 'down'}}"></i> @endif
                                    </th>
                                    <th wire:click="sortBy('surname')" class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                        {{ __('users.surname') }} @if($orderColumn == 'surname') <i class="fas fa-sort-{{$orderDirection == 'asc' ? 'up' : 'down'}}"></i> @endif
                                    </th>
                                    <th wire:click="sortBy('email')" class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                        {{ __('users.email') }} @if($orderColumn == 'email') <i class="fas fa-sort-{{$orderDirection == 'asc' ? 'up' : 'down'}}"></i> @endif
                                    </th>
                                    <th wire:click="sortBy('roles')" class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                        {{ __('users.role') }} @if($orderColumn == 'roles') <i class="fas fa-sort-{{$orderDirection == 'asc' ? 'up' : 'down'}}"></i> @endif
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('users.actions') }}
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($data as $key => $usuario)
                                    <tr wire:key="usuario-{{ $usuario->id }}">
                                        <td class="px-6 py-4 whitespace-no-wrap">
                                            <div class="flex items-center">
                                                <div>
                                                    <div class="text-sm leading-5 text-gray-900">
                                                        {{ $key + 1 }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap">
                                            <div class="flex items-center">
                                                <div>
                                                    <div class="text-sm leading-5 text-gray-900">
                                                        {{ $usuario->name }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap">
                                            <div class="flex items-center">
                                                <div>
                                                    <div class="text-sm leading-5 text-gray-900">
                                                        {{ $usuario->surname }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap">
                                            <div class="flex items-center">
                                                <div>
                                                    <div class="text-sm leading-5 text-gray-900">
                                                        {{ $usuario->email }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap">
                                            <div class="flex items-center">
                                                <div>
                                                    <div class="text-sm leading-5 text-gray-900">
                                                        {{ $usuario->roles->pluck('name')->implode(', ') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap">
                                            <div class="flex items-center">
                                                <div class="text-sm leading-5 text-gray-900">
                                                    <div class="flex items-center space-x-1">
                                                        <!-- Botón Editar Usuario -->
                                                        <button title="{{ __('users.edit_user') }}" class="p-2 rounded bg-blue-500 text-white hover:bg-blue-600 focus:outline-none"  wire:click="openModal('edit', {{ $usuario->id }})">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <!-- Botón Mostrar Usuario -->
                                                        <button title="{{ __('users.show_user') }}" class="p-2 rounded bg-green-500 text-white hover:bg-green-600 focus:outline-none" wire:click="openModal('show', {{$usuario->id}})">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <!-- Botón Impersonar Usuario -->
                                                        @if($this->canImpersonate($usuario))
                                                            <button title="{{ __('users.impersonate_user') }}" class="p-2 rounded bg-yellow-500 text-white hover:bg-yellow-600 focus:outline-none" wire:click="openModal('impersonate', {{ $usuario->id }})">
                                                                <i class="fas fa-user-secret"></i>
                                                            </button>
                                                        @endif
                                                        <!-- Botón Borrar Usuario -->
                                                        @if($currentFilter != 'deleted')
                                                            <button title="{{ __('users.delete_user') }}" class="p-2 rounded bg-red-500 text-white hover:bg-red-600 focus:outline-none" wire:click="openModal('delete',{{$usuario->id}})">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        @endif
                                                        <!-- Botón Restablecer Usuario -->
                                                        @if($currentFilter == 'deleted')
                                                            <button title="{{ __('users.restore_user') }}" class="p-2 rounded bg-orange-500 text-white hover:bg-orange-600 focus:outline-none" wire:click="openModal('restore', {{ $usuario->id }})">
                                                                <i class="fas fa-recycle"></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="px-6 py-4 whitespace-no-wrap" colspan="6">
                                            <div class="text-sm leading-5 text-gray-900">
                                                {{ __('users.no_users') }}
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Enlaces de paginación personalizados -->
                    <div class="m-4">
                        {{ $data->links('components.custom-pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modales (ejemplos) -->
    @if($modalCreate)
        <x-dialog-modal wire:model="modalCreate" :maxWidth="'full'">
            <x-slot name="title">
                {{ __('users.create_user') }}
            </x-slot>
            <x-slot name="content">
                <livewire:users.create-user />
            </x-slot>
            <x-slot name="footer"></x-slot>
        </x-dialog-modal>
    @endif

    @if($modalEdit)
        <x-dialog-modal wire:model="modalEdit" :maxWidth="'full'">
            <x-slot name="title">
                {{ __('users.edit_user') }}
            </x-slot>
            <x-slot name="content">
                <livewire:users.edit-user :user="$user"/>
            </x-slot>
            <x-slot name="footer"></x-slot>
        </x-dialog-modal>
    @endif

    @if($modalShow)
        <x-dialog-modal wire:model="modalShow" :maxWidth="'full'">
            <x-slot name="title">
                {{ __('users.show_user') }}
            </x-slot>
            <x-slot name="content">
                <livewire:users.user-show :user="$user"/>
            </x-slot>
            <x-slot name="footer"></x-slot>
        </x-dialog-modal>
    @endif

    @if($modalImpersonate)
        <x-dialog-modal wire:model="modalImpersonate" :maxWidth="'sm'">
            <x-slot name="title">
                {{ __('users.impersonate_user') }} {{ $user->name }} {{ $user->surname }}
            </x-slot>
            <x-slot name="content">
                {{ __('users.impersonate_confirmation', ['name' => $user->name, 'surname' => $user->surname]) }}
            </x-slot>
            <x-slot name="footer">
                <x-button wire:click="impersonateUser" class="bg-blue-500 mr-4 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('users.impersonate') }}
                </x-button>
                <x-danger-button wire:click="closeModal('impersonate')" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('users.cancel') }}
                </x-danger-button>
            </x-slot>
        </x-dialog-modal>
    @endif

    @if($modalDelete)
        <x-dialog-modal wire:model="modalDelete" :maxWidth="'sm'">
            <x-slot name="title">
                {{ __('users.delete_user') }} {{ $user->name }} {{ $user->surname }}
            </x-slot>
            <x-slot name="content">
                {{ __('users.delete_confirmation', ['name' => $user->name, 'surname' => $user->surname]) }}
            </x-slot>
            <x-slot name="footer">
                <x-button wire:click="closeModal('delete')" class="bg-blue-500 mr-4 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('users.cancel') }}
                </x-button>
                <x-danger-button wire:click="delete()" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('users.delete') }}
                </x-danger-button>
            </x-slot>
        </x-dialog-modal>
    @endif

    @if($modalRestore)
        <x-dialog-modal wire:model="modalRestore" :maxWidth="'sm'">
            <x-slot name="title">
                {{ __('users.restore_user') }} {{ $user->name }} {{ $user->surname }}
            </x-slot>
            <x-slot name="content">
                {{ __('users.restore_confirmation', ['name' => $user->name, 'surname' => $user->surname]) }}
            </x-slot>
            <x-slot name="footer">
                <x-button wire:click="restore()" class="bg-blue-500 mr-4 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('users.restore') }}
                </x-button>
                <x-danger-button wire:click="closeModal('impersonate')" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('users.cancel') }}
                </x-danger-button>
            </x-slot>
        </x-dialog-modal>
    @endif
</div>

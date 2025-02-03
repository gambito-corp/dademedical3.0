<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel de Incidencia') }}
        </h2>
    </x-slot>
    <div class="py-4">
        <div class="max-w-screen mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 space-y-4">
                    <div class="flex justify-between space-x-2">
                        <div class="{{ $currentFilter == 'active' ? 'bg-blue-700 text-white' : 'bg-white text-blue-500 border border-blue-500 hover:text-white hover:border-0 ' }} w-1/2 p-2 hover:bg-blue-700 font-bold py-2 px-4 rounded-xl transition-all duration-300" wire:click="changeIncidence('active')">
                            <span>{{ __('Incidencia Activas') }}</span>
                        </div>
                        <div class="{{ $currentFilter == 'inactive' ? 'bg-blue-700 text-white' : 'bg-white text-blue-500 border border-blue-500 hover:text-white hover:border-0 ' }} w-1/2 p-2 hover:bg-blue-700 font-bold py-2 px-4 rounded-xl transition-all duration-300" wire:click="changeIncidence('inactive')">
                            <span>{{ __('Incidencia Resueltas') }}</span>
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
                                    placeholder="{{''}}"
                                    wire:model="paginate"
                                    wire:click.self="showPagination">
                                @if($showDropdown)
                                    <div class="border border-gray-300 max-h-48 overflow-y-auto">
                                        @forelse($paginacion as $key => $item)
                                            <div class="p-2 hover:bg-gray-100" wire:click="selectedPaginate('{{ $item }}')" wire:key="{{$key}}">{{ $item }}</div>
                                        @empty
                                            <div class="p-2">{{ __('Searching Elements') }}</div>
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
                                    placeholder="{{ __('Enter your search') }}"
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
                                        {{ __('paciente.Order') }} #
                                    </th>
                                    <th wire:click="sortBy('paciente.nombre')" class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                        Paciente @if($orderColumn == 'paciente.nombre') <i class="fas fa-sort-{{$orderDirection == 'asc' ? 'up' : 'down'}}"></i> @endif
                                    </th>
                                    <th wire:click="sortBy('usuario.nombre')" class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                        Emisor
                                        @if($orderColumn == 'usuario.nombre') <i class="fas fa-sort-{{$orderDirection == 'asc' ? 'up' : 'down'}}"></i> @endif
                                    </th>
                                    <th wire:click="sortBy('usuario.hospitales')" class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                        Sede @if($orderColumn == 'usuario.hospitales') <i class="fas fa-sort-{{$orderDirection == 'asc' ? 'up' : 'down'}}"></i> @endif
                                    </th>
                                    <th wire:click="sortBy('incidencia')" class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                        Comentario @if($orderColumn == 'incidencia') <i class="fas fa-sort-{{$orderDirection == 'asc' ? 'up' : 'down'}}"></i> @endif
                                    </th>
                                    @if($currentFilter === 'inactive')
                                        <th wire:click="sortBy('respuesta')" class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                            Respuesta @if($orderColumn == 'respuesta') <i class="fas fa-sort-{{$orderDirection == 'asc' ? 'up' : 'down'}}"></i> @endif
                                        </th>
                                    @endif
                                    <th wire:click="sortBy('fecha_incidencia')" class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                        Fecha de Incidencia @if($orderColumn == 'fecha_incidencia') <i class="fas fa-sort-{{$orderDirection == 'asc' ? 'up' : 'down'}}"></i> @endif
                                    </th>
                                    @if($currentFilter === 'inactive')
                                        <th  wire:click="sortBy('fecha_respuesta')" class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                            Fecha de Respuesta @if($orderColumn == 'fecha_respuesta') <i class="fas fa-sort-{{$orderDirection == 'asc' ? 'up' : 'down'}}"></i> @endif
                                        </th>
                                    @endif
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('paciente.Actions') }}
                                    </th>

                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($data as $key => $item)
                                    <tr wire:key="paciente-{{ $item->id }}">
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
                                                        {{ $item->contrato?->paciente?->fullName ?? 'N/A' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap">
                                            <div class="flex items-center">
                                                <div>
                                                    <div class="text-sm leading-5 text-gray-900">
                                                        {{ $item->user?->fullName ?? 'N/A' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap">
                                            <div class="flex items-center">
                                                <div>
                                                    <div class="text-sm leading-5 text-gray-900">
                                                        {{ $item->user?->hospital?->nombre ?? 'N/A' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap">
                                            <div class="flex items-center">
                                                <div>
                                                    <div class="text-sm leading-5 text-gray-900">
                                                        {{ $item->incidencia }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        @if($currentFilter === 'inactive')
                                            <td class="px-6 py-4 whitespace-no-wrap">
                                                <div class="flex items-center">
                                                    <div>
                                                        <div class="text-sm leading-5 text-gray-900">
                                                            {{ $item->respuesta }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        @endif
                                        <td class="px-6 py-4 whitespace-no-wrap">
                                            <div class="flex items-center">
                                                <div>
                                                    <div class="text-sm leading-5 text-gray-900">
                                                        {{ $item->fecha_incidencia ?? 'N/A' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        @if($currentFilter === 'inactive')
                                            <td class="px-6 py-4 whitespace-no-wrap">
                                                <div class="flex items-center">
                                                    <div>
                                                        <div class="text-sm leading-5 text-gray-900">
                                                            {{ $item->fecha_respuesta ?? 'N/A' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        @endif
                                        <td class="px-6 py-4 whitespace-no-wrap">
                                            <div class="flex items-center">
                                                <div class="text-sm leading-5 text-gray-900">
                                                    <div class="flex items-center space-x-2 my-4">
                                                        <button
                                                            class="text-green-500 hover:text-green-700"
                                                            title="editar incidencia"
                                                            wire:click="openModal('edit', {{ $item->id }})">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="px-6 py-4 whitespace-no-wrap" colspan="6">
                                            <div class="text-sm leading-5 text-gray-900">
                                                Sin Incidencias que mostrar

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
    @if($modalEdit)
        <x-dialog-modal wire:model="modalEdit" :maxWidth="'full'">
            <x-slot name="title">
                Editar Incidencia
            </x-slot>
            <x-slot name="content">
{{--                @dump($incidencia)--}}
                <livewire:incidences.edit-incidence :incidenceId="$incidencia->id"/>
            </x-slot>
            <x-slot name="footer"></x-slot>
        </x-dialog-modal>
    @endif

</div>

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel de Incidencias') }}
        </h2>
    </x-slot>
    <div class="py-4">
        <div class="max-w-screen mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 space-y-4">
                    <div class="flex justify-between space-x-2">
                        <div class="{{ $currentFilter == 'active' ? 'bg-blue-700 text-white' : 'bg-white text-blue-500 border border-blue-500 hover:text-white hover:border-0 ' }} w-1/2 p-2 hover:bg-blue-700 font-bold py-2 px-4 rounded-xl transition-all duration-300" wire:click="changeIncidence('active')">
                            <span>{{ __('Incidencias Activas') }}</span>
                        </div>
                        <div class="{{ $currentFilter == 'inactive' ? 'bg-blue-700 text-white' : 'bg-white text-blue-500 border border-blue-500 hover:text-white hover:border-0 ' }} w-1/2 p-2 hover:bg-blue-700 font-bold py-2 px-4 rounded-xl transition-all duration-300" wire:click="changeIncidence('inactive')">
                            <span>{{ __('Incidencias Resueltas') }}</span>
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
                                    <th wire:click="sortBy('comentario')" class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                        Comentario @if($orderColumn == 'comentario') <i class="fas fa-sort-{{$orderDirection == 'asc' ? 'up' : 'down'}}"></i> @endif
                                    </th>
                                    <th wire:click="sortBy('fecha_incidencia')" class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                        Fecha de Incidencia @if($orderColumn == 'fecha_incidencia') <i class="fas fa-sort-{{$orderDirection == 'asc' ? 'up' : 'down'}}"></i> @endif
                                    </th>
                                    <th  wire:click="sortBy('fecha_respuesta')" class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                        Fecha de Respuesta @if($orderColumn == 'fecha_respuesta') <i class="fas fa-sort-{{$orderDirection == 'asc' ? 'up' : 'down'}}"></i> @endif
                                    </th>

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
                                        <td class="px-6 py-4 whitespace-no-wrap">
                                            <div class="flex items-center">
                                                <div>
                                                    <div class="text-sm leading-5 text-gray-900">
                                                        {{ $item->fecha_incidencia ?? 'N/A' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap">
                                            <div class="flex items-center">
                                                <div>
                                                    <div class="text-sm leading-5 text-gray-900">
                                                        {{ $item->fecha_respuesta ?? 'N/A' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-no-wrap">
                                            <div class="flex items-center">
                                                <div class="text-sm leading-5 text-gray-900">
                                                    <div class="flex items-center space-x-2 my-4">
                                                        <button
                                                            class="text-green-500 hover:text-green-700"
                                                            title="{{ __('paciente.Edit') }}"
                                                            wire:click="openModal('edit', {{ $item->id }})">
                                                            <i class="fas fa-edit"></i>
                                                        </button>

                                                        <!-- Botón para solicitar un cambio de dosis -->
                                                        <button
                                                            class="text-blue-500 hover:text-blue-700"
                                                            title="{{ __('paciente.Request Dose Change') }}"
                                                            wire:click="openModal('changeDose', {{ $item->id }})">
                                                            <i class="fas fa-syringe"></i>
                                                        </button>
                                                        <!-- Botón para solicitar un cambio de Direccion -->
                                                        <button
                                                            class="text-blue-500 hover:text-blue-700"
                                                            title="{{ __('paciente.Request Direction Change') }}"
                                                            wire:click="openModal('changeDirecction', {{ $item->id }})">
                                                            <i class="fa-solid fa-location-dot"></i>
                                                        </button>




                                                        <!-- Botón para abrir una incidencia -->
                                                        <button
                                                            class="text-red-500 hover:text-red-700"
                                                            title="{{ __('paciente.Open Incident') }}"
                                                            wire:click="openModal('incidence', {{ $item->id }})">
                                                            <i class="fas fa-exclamation-triangle"></i>
                                                        </button>
                                                        {{--
                                                           <!-- Botón para dar de alta al paciente -->
                                                           @can('dar-alta')
                                                               <button
                                                                   class="text-gray-500 hover:text-gray-700"
                                                                   title="{{ __('paciente.Discharge Patient') }}"
                                                                   wire:click="openModal('alta', {{ $item->id }})">
                                                                   <i class="fas fa-user-times"></i>
                                                               </button>
                                                           @endcan
                                                       --}}

                                                        <!-- Botón para aprobar un cambio de dosis -->
                                                        @can('aprobar-dosis')
                                                            @if($item->diagnosticoPendiente)
                                                                <button
                                                                    class="text-indigo-500 hover:text-indigo-700"
                                                                    title="{{ __('paciente.Approve Dose Change') }}"
                                                                    wire:click="openModal('aproveDose', {{ $item->id }})">
                                                                    <i class="fas fa-check-circle"></i>
                                                                </button>
                                                            @endif
                                                        @endcan

                                                        <!-- Botón para aprobar un cambio de dirección -->
                                                        @can('aprobar-direccion')
                                                            @if($item->direccionPendiente)
                                                                <button
                                                                    class="text-indigo-500 hover:text-indigo-700"
                                                                    title="{{ __('paciente.Approve Address Change') }}"
                                                                    wire:click="openModal('aproveDirecction', {{ $item->id }})">
                                                                    <i class="fas fa-thumbs-up"></i>
                                                                </button>
                                                            @endif
                                                        @endcan
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="px-6 py-4 whitespace-no-wrap" colspan="6">
                                            <div class="text-sm leading-5 text-gray-900">
                                                {{ __('paciente.No patients to show') }}
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
{{--                        {{ $data->links('components.custom-pagination') }}--}}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

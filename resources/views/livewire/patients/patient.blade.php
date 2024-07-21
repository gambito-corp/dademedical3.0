<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('patient.Patients Panel') }}
        </h2>
    </x-slot>
    <div class="py-4">
        <div class="max-w-screen mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 space-y-4">
                    <div class="flex justify-end space-x-2">
                        <button
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-xl"
                            title="Crear Usuario"
                            wire:click="openModal('create')">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <div class="flex justify-between space-x-2">
                        <div class="{{ $currentFilter == 'active' ? 'bg-blue-700 text-white' : 'bg-white text-blue-500 border border-blue-500 hover:text-white hover:border-0 ' }} w-1/2 p-2 hover:bg-blue-700 font-bold py-2 px-4 rounded-xl transition-all duration-300" wire:click="changePatient('active')">
                            <span>Pacientes Activos</span>
                        </div>
                        <div class="{{ $currentFilter == 'inactive' ? 'bg-blue-700 text-white' : 'bg-white text-blue-500 border border-blue-500 hover:text-white hover:border-0 ' }} w-1/2 p-2 hover:bg-blue-700 font-bold py-2 px-4 rounded-xl transition-all duration-300" wire:click="changePatient('inactive')">
                            <span>Pacientes Inactivos</span>
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
                                    placeholder="Paginación"
                                    wire:model="paginate"
                                    wire:click.self="showPagination">
                                @if($showDropdown)
                                    <div class="border border-gray-300 max-h-48 overflow-y-auto">
                                        @forelse($paginacion as $key => $item)
                                            <div class="p-2 hover:bg-gray-100" wire:click="selectedPaginate('{{ $item }}')" wire:key="{{$key}}">{{ $item }}</div>
                                        @empty
                                            <div class="p-2">Buscando Elementos...</div>
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
                                    placeholder="escribe tu búsqueda..."
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
                                        Orden #
                                    </th>
                                    <th wire:click="sortBy('name')" class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                        Nombre @if($orderColumn == 'name') <i class="fas fa-sort-{{$orderDirection == 'asc' ? 'up' : 'down'}}"></i> @endif
                                    </th>
                                    <th wire:click="sortBy('surname')" class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                        Apellido @if($orderColumn == 'surname') <i class="fas fa-sort-{{$orderDirection == 'asc' ? 'up' : 'down'}}"></i> @endif
                                    </th>
                                    <th wire:click="sortBy('dni')" class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                        Dni @if($orderColumn == 'dni') <i class="fas fa-sort-{{$orderDirection == 'asc' ? 'up' : 'down'}}"></i> @endif
                                    </th>
                                    <th wire:click="sortBy('hospital_nombre')" class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                        Sede @if($orderColumn == 'hospital_nombre') <i class="fas fa-sort-{{$orderDirection == 'asc' ? 'up' : 'down'}}"></i> @endif
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        Acciones
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($data as $key => $item)
                                    <tr wire:key="usuario-{{ $item->id }}">
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
                                                        {{ $item->name }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap">
                                            <div class="flex items-center">
                                                <div>
                                                    <div class="text-sm leading-5 text-gray-900">
                                                        {{ $item->surname }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap">
                                            <div class="flex items-center">
                                                <div>
                                                    <div class="text-sm leading-5 text-gray-900">
                                                        {{ $item->dni }}
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
                                                <div class="text-sm leading-5 text-gray-900">
                                                    <div class="flex items-center space-x-1">
{{--                                                        Ver Paciente--}}
{{--                                                        Incidencias--}}
{{--                                                        Edicion--}}
{{--                                                        Cambio de Direccion--}}
{{--                                                        Aprobar Cambio de Direccion--}}
{{--                                                        Cambio de Dosis--}}
{{--                                                        Aprobar Cambio de Dosis--}}
{{--                                                        Recojo de Equipo--}}
{{--                                                        Revertir Recojo de Equipo (En inactivos)--}}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="px-6 py-4 whitespace-no-wrap" colspan="6">
                                            <div class="text-sm leading-5 text-gray-900">
                                                No hay Pacientes para mostrar
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

</div>

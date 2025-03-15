<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('dashboard.Inventory') }}
        </h2>
    </x-slot>
    <div class="py-4">
        <div class="max-w-screen mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 space-y-4">
                    <div class="flex justify-between space-x-2">
                        <div class="{{ $currentFilter == 'Maquinas' ? 'bg-blue-700 text-white' : 'bg-white text-blue-500 border border-blue-500 hover:text-white hover:border-0 ' }} w-1/2 p-2 hover:bg-blue-700 font-bold py-2 px-4 rounded-xl transition-all duration-300"
                             wire:click="changeInventory('Maquinas')">
                            <span>Maquinas</span>
                        </div>
                        <div class="{{ $currentFilter == 'Tanques' ? 'bg-blue-700 text-white' : 'bg-white text-blue-500 border border-blue-500 hover:text-white hover:border-0 ' }} w-1/2 p-2 hover:bg-blue-700 font-bold py-2 px-4 rounded-xl transition-all duration-300"
                             wire:click="changeInventory('Tanques')">
                            <span>Tanques</span>
                        </div>
                        <div class="{{ $currentFilter == 'Reguladores' ? 'bg-blue-700 text-white' : 'bg-white text-blue-500 border border-blue-500 hover:text-white hover:border-0 ' }} w-1/2 p-2 hover:bg-blue-700 font-bold py-2 px-4 rounded-xl transition-all duration-300"
                             wire:click="changeInventory('Reguladores')">
                            <span>Reguladores</span>
                        </div>
                        <div class="{{ $currentFilter == 'Carritos' ? 'bg-blue-700 text-white' : 'bg-white text-blue-500 border border-blue-500 hover:text-white hover:border-0 ' }} w-1/2 p-2 hover:bg-blue-700 font-bold py-2 px-4 rounded-xl transition-all duration-300"
                             wire:click="changeInventory('Carritos')">
                            <span>Carritos</span>
                        </div>
                    </div>
                    <div class="flex justify-between space-x-2">
                        @foreach($subFilters[$currentFilter] as $subFilterOption)
                            <div wire:key="{{$subFilterOption}}" class="{{ $subFilter == $subFilterOption ? 'bg-blue-700 text-white' : 'bg-white text-blue-500 border border-blue-500 hover:text-white hover:border-0 ' }} w-1/2 p-2 hover:bg-blue-700 font-bold py-2 px-4 rounded-xl transition-all duration-300"
                                 wire:click="changeSubFilter('{{ $subFilterOption }}')">
                                <span>{{ ucfirst($subFilterOption) }}</span>
                            </div>
                        @endforeach
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
                                <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order</th>
                                    <th wire:click="sortBy('id')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                        ID @if($orderColumn == 'id') <i class="fas fa-sort-{{$orderDirection == 'asc' ? 'up' : 'down'}}"></i> @endif
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Codigo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Paciente/Ubicacion</th>
                                    @if($currentFilter === 'Maquinas')
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Capacidad</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Marca</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Modelo</th>
                                    @endif
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($data as $item)
                                    <tr wire:key="contract-{{$item->id}}"{{-- wire:click="showContract({{$item->id}}--}})">
                                        @if($loop->first)
{{--                                            @dump($item)--}}
                                        @endif

                                        <td class="px-6 py-4 whitespace-no-wrap">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4 whitespace-no-wrap">{{ $item->id }}</td>
                                        <td class="px-6 py-4 whitespace-no-wrap">{{ $item->codigo }}</td>
                                        <td class="px-6 py-4 whitespace-no-wrap">
                                            @switch($currentFilter)
                                                @case('Maquinas')
                                                    @switch($subFilter)
                                                        @case('activos')
                                                            Almacen
                                                            @break
                                                        @case('alquilados')
                                                            {{ $item->contrato->paciente->fullName }}
                                                            @break
                                                        @case('mantenimiento')
                                                            Mantenimiento
                                                            @break
                                                        @case('baja')
                                                            Retirado
                                                            @break
                                                        @case('registro')
                                                            @php
                                                                $status = $item->activo ? 'Almacen' : ($item->contrato_id ? $item->contrato_id : ($item->mantenimiento_id ? 'Mantenimiento' : 'Retirado'));
                                                            @endphp
                                                            {{ $status }}
                                                            @break
                                                    @endswitch
                                                    @break
                                                @default
                                                    @switch($subFilter)
                                                        @case('activos')
                                                            Almacen
                                                            @break
                                                        @case('alquilados')
                                                            {{ $item->contrato_id }}
                                                            @break
                                                        @case('baja')
                                                            Retirado
                                                            @break
                                                    @endswitch
                                                    @break
                                            @endswitch
                                        </td>
                                        @if($currentFilter === 'Maquinas')
                                            <td class="px-6 py-4 whitespace-no-wrap">{{ $item->productable?->capacidad }}</td>
                                            <td class="px-6 py-4 whitespace-no-wrap">{{ $item->productable?->marca }}</td>
                                            <td class="px-6 py-4 whitespace-no-wrap">{{ $item->productable?->modelo }}</td>
                                        @endif
                                        <td class="px-6 py-4 whitespace-no-wrap">
                                            <button wire:click="showItems({{ $item->id }})" class="text-blue-500 hover:text-blue-700">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button wire:click="openModal('edit', {{ $item->id }})" class="text-green-500 hover:text-green-700">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button wire:click="openModal('delete', {{ $item->id }})" class="text-red-500 hover:text-red-700">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="12" class="px-6 py-4 whitespace-no-wrap">No contracts found.</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>

                        </div>
                    </div>
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

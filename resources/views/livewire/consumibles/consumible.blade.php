<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('dashboard.Consumibles') }}
        </h2>
    </x-slot>
    <div class="py-4">
        <div class="max-w-screen mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 space-y-4">
                    <div class="flex justify-between space-x-2">
                        {{--                        <div class="{{ $currentFilter == 'solicitado' ? 'bg-blue-700 text-white' : 'bg-white text-blue-500 border border-blue-500 hover:text-white hover:border-0 ' }} w-1/2 p-2 hover:bg-blue-700 font-bold py-2 px-4 rounded-xl transition-all duration-300" wire:click="changeContract('solicitado')">--}}
                        {{--                            <span>{{ __('contract.solicitado') }}</span>--}}
                        {{--                        </div>--}}
                        {{--                        <div class="{{ $currentFilter == 'aprobado' ? 'bg-blue-700 text-white' : 'bg-white text-blue-500 border border-blue-500 hover:text-white hover:border-0 ' }} w-1/2 p-2 hover:bg-blue-700 font-bold py-2 px-4 rounded-xl transition-all duration-300" wire:click="changeContract('aprobado')">--}}
                        {{--                            <span>{{ __('contract.aprobado') }}</span>--}}
                        {{--                        </div>--}}
                        {{--                        <div class="{{ $currentFilter == 'rechazado' ? 'bg-blue-700 text-white' : 'bg-white text-blue-500 border border-blue-500 hover:text-white hover:border-0 ' }} w-1/2 p-2 hover:bg-blue-700 font-bold py-2 px-4 rounded-xl transition-all duration-300" wire:click="changeContract('rechazado')">--}}
                        {{--                            <span>{{ __('contract.rechazado') }}</span>--}}
                        {{--                        </div>--}}
                        {{--                        <div class="{{ $currentFilter == 'anulado' ? 'bg-blue-700 text-white' : 'bg-white text-blue-500 border border-blue-500 hover:text-white hover:border-0 ' }} w-1/2 p-2 hover:bg-blue-700 font-bold py-2 px-4 rounded-xl transition-all duration-300" wire:click="changeContract('anulado')">--}}
                        {{--                            <span>{{ __('contract.anulado') }}</span>--}}
                        {{--                        </div>--}}
                        {{--                        <div class="{{ $currentFilter == 'entregado' ? 'bg-blue-700 text-white' : 'bg-white text-blue-500 border border-blue-500 hover:text-white hover:border-0 ' }} w-1/2 p-2 hover:bg-blue-700 font-bold py-2 px-4 rounded-xl transition-all duration-300" wire:click="changeContract('entregado')">--}}
                        {{--                            <span>{{ __('contract.entregado') }}</span>--}}
                        {{--                        </div>--}}
                        {{--                        <div class="{{ $currentFilter == 'recogido' ? 'bg-blue-700 text-white' : 'bg-white text-blue-500 border border-blue-500 hover:text-white hover:border-0 ' }} w-1/2 p-2 hover:bg-blue-700 font-bold py-2 px-4 rounded-xl transition-all duration-300" wire:click="changeContract('recogido')">--}}
                        {{--                            <span>{{ __('contract.recogido') }}</span>--}}
                        {{--                        </div>--}}
                        {{--                        <div class="{{ $currentFilter == 'finalizado' ? 'bg-blue-700 text-white' : 'bg-white text-blue-500 border border-blue-500 hover:text-white hover:border-0 ' }} w-1/2 p-2 hover:bg-blue-700 font-bold py-2 px-4 rounded-xl transition-all duration-300" wire:click="changeContract('finalizado')">--}}
                        {{--                            <span>{{ __('contract.finalizado') }}</span>--}}
                        {{--                        </div>--}}
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
                                    {{--                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order</th>--}}
                                    {{--                                    <th wire:click="sortBy('id')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">--}}
                                    {{--                                        ID @if($orderColumn == 'id') <i class="fas fa-sort-{{$orderDirection == 'asc' ? 'up' : 'down'}}"></i> @endif--}}
                                    {{--                                    </th>--}}
                                    {{--                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Paciente</th>--}}

                                    {{--                                    @switch($currentFilter)--}}
                                    {{--                                        @case('solicitado')--}}
                                    {{--                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha de Solicitud</th>--}}
                                    {{--                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Solicitante</th>--}}
                                    {{--                                            @break--}}
                                    {{--                                        @case('aprobado')--}}
                                    {{--                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha de Solicitud</th>--}}
                                    {{--                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha de Aprobación</th>--}}
                                    {{--                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Solicitante</th>--}}
                                    {{--                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aprobado Por</th>--}}
                                    {{--                                            @break--}}
                                    {{--                                        @case('rechazado')--}}
                                    {{--                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha de Solicitud</th>--}}
                                    {{--                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha de Rechazo</th>--}}
                                    {{--                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Solicitante</th>--}}
                                    {{--                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rechazado Por</th>--}}
                                    {{--                                            @break--}}
                                    {{--                                        @case('anulado')--}}
                                    {{--                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha de Solicitud</th>--}}
                                    {{--                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha de Anulación</th>--}}
                                    {{--                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Solicitante</th>--}}
                                    {{--                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Anulado Por</th>--}}
                                    {{--                                            @break--}}
                                    {{--                                        @case('entregado')--}}
                                    {{--                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha de Solicitud</th>--}}
                                    {{--                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha de Aprobación</th>--}}
                                    {{--                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha de Entrega</th>--}}
                                    {{--                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Solicitante</th>--}}
                                    {{--                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aprobado Por</th>--}}
                                    {{--                                            @break--}}
                                    {{--                                        @case('recogido')--}}
                                    {{--                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha de Solicitud</th>--}}
                                    {{--                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha de Aprobación</th>--}}
                                    {{--                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha de Entrega</th>--}}
                                    {{--                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha de Recogida</th>--}}
                                    {{--                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Solicitante</th>--}}
                                    {{--                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aprobado Por</th>--}}
                                    {{--                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dado de Baja Por</th>--}}
                                    {{--                                            @break--}}
                                    {{--                                        @case('finalizado')--}}
                                    {{--                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha de Solicitud</th>--}}
                                    {{--                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha de Aprobación</th>--}}
                                    {{--                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha de Entrega</th>--}}
                                    {{--                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha de Recogida</th>--}}
                                    {{--                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha de Finalización</th>--}}
                                    {{--                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Solicitante</th>--}}
                                    {{--                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aprobado Por</th>--}}
                                    {{--                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dado de Baja Por</th>--}}
                                    {{--                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Finalizado Por</th>--}}
                                    {{--                                            @break--}}
                                    {{--                                    @endswitch--}}

                                    {{--                                    <th wire:click="sortBy('estado_orden')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">--}}
                                    {{--                                        Estado Orden @if($orderColumn == 'estado_orden') <i class="fas fa-sort-{{$orderDirection == 'asc' ? 'up' : 'down'}}"></i> @endif--}}
                                    {{--                                    </th>--}}
                                    {{--                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>--}}
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($data as $item)
                                    <tr wire:key="contract-{{$item->id}}" wire:click="showContract({{$item->id}})">
                                        {{--                                        <td class="px-6 py-4 whitespace-no-wrap">{{ $loop->iteration }}</td>--}}
                                        {{--                                        <td class="px-6 py-4 whitespace-no-wrap">{{ $contract->id }}</td>--}}
                                        {{--                                        <td class="px-6 py-4 whitespace-no-wrap">{{ $contract->paciente->name }} {{ $contract->paciente->surname }}</td>--}}

                                        {{--                                        @switch($currentFilter)--}}
                                        {{--                                            @case('solicitado')--}}
                                        {{--                                                <td class="px-6 py-4 whitespace-no-wrap">--}}
                                        {{--                                                    {{ $contract->contratoFechas?->fecha_solicitud ? Carbon\Carbon::parse($contract->contratoFechas?->fecha_solicitud)->format('d/m/Y') : 'No asignada' }}--}}
                                        {{--                                                    {{ $contract->contratoFechas?->fecha_solicitud ? Carbon\Carbon::parse($contract->contratoFechas?->fecha_solicitud)->diffForHumans() : '' }}--}}
                                        {{--                                                </td>--}}
                                        {{--                                                <td class="px-6 py-4 whitespace-no-wrap">{{ $contract->usuarios->solicitante->name ?? 'No Asignado' }}</td>--}}
                                        {{--                                                @break--}}
                                        {{--                                            @case('aprobado')--}}
                                        {{--                                                <td class="px-6 py-4 whitespace-no-wrap">--}}
                                        {{--                                                    {{ $contract->contratoFechas?->fecha_solicitud ? Carbon\Carbon::parse($contract->contratoFechas?->fecha_solicitud)->format('d/m/Y') : 'No asignada' }}--}}
                                        {{--                                                    {{ $contract->contratoFechas?->fecha_solicitud ? Carbon\Carbon::parse($contract->contratoFechas?->fecha_solicitud)->diffForHumans() : '' }}--}}
                                        {{--                                                </td>--}}
                                        {{--                                                <td class="px-6 py-4 whitespace-no-wrap">--}}
                                        {{--                                                    {{ $contract->contratoFechas?->fecha_aprobacion ? Carbon\Carbon::parse($contract->contratoFechas?->fecha_aprobacion)->format('d/m/Y') : 'No asignada' }}--}}
                                        {{--                                                    {{ $contract->contratoFechas?->fecha_aprobacion ? Carbon\Carbon::parse($contract->contratoFechas?->fecha_aprobacion)->diffForHumans() : '' }}--}}
                                        {{--                                                </td>--}}
                                        {{--                                                <td class="px-6 py-4 whitespace-no-wrap">{{ $contract->usuarios->solicitante->name ?? 'No Asignado' }}</td>--}}
                                        {{--                                                <td class="px-6 py-4 whitespace-no-wrap">{{ $contract->usuarios->aprobador->name ?? 'No Asignado' }}</td>--}}
                                        {{--                                                @break--}}
                                        {{--                                            @case('rechazado')--}}
                                        {{--                                                <td class="px-6 py-4 whitespace-no-wrap">--}}
                                        {{--                                                    {{ $contract->contratoFechas?->fecha_solicitud ? Carbon\Carbon::parse($contract->contratoFechas?->fecha_solicitud)->format('d/m/Y') : 'No asignada' }}--}}
                                        {{--                                                    {{ $contract->contratoFechas?->fecha_solicitud ? Carbon\Carbon::parse($contract->contratoFechas?->fecha_solicitud)->diffForHumans() : '' }}--}}
                                        {{--                                                </td>--}}
                                        {{--                                                <td class="px-6 py-4 whitespace-no-wrap">--}}
                                        {{--                                                    {{ $contract->contratoFechas?->fecha_rechazo ? Carbon\Carbon::parse($contract->contratoFechas?->fecha_rechazo)->format('d/m/Y') : 'No asignada' }}--}}
                                        {{--                                                    {{ $contract->contratoFechas?->fecha_rechazo ? Carbon\Carbon::parse($contract->contratoFechas?->fecha_rechazo)->diffForHumans() : '' }}--}}
                                        {{--                                                </td>--}}
                                        {{--                                                <td class="px-6 py-4 whitespace-no-wrap">{{ $contract->usuarios->solicitante->name ?? 'No Asignado' }}</td>--}}
                                        {{--                                                <td class="px-6 py-4 whitespace-no-wrap">{{ $contract->usuarios->rechazador->name ?? 'No Asignado' }}</td>--}}
                                        {{--                                                @break--}}
                                        {{--                                            @case('anulado')--}}
                                        {{--                                                <td class="px-6 py-4 whitespace-no-wrap">--}}
                                        {{--                                                    {{ $contract->contratoFechas?->fecha_solicitud ? Carbon\Carbon::parse($contract->contratoFechas?->fecha_solicitud)->format('d/m/Y') : 'No asignada' }}--}}
                                        {{--                                                    {{ $contract->contratoFechas?->fecha_solicitud ? Carbon\Carbon::parse($contract->contratoFechas?->fecha_solicitud)->diffForHumans() : '' }}--}}
                                        {{--                                                </td>--}}
                                        {{--                                                <td class="px-6 py-4 whitespace-no-wrap">--}}
                                        {{--                                                    {{ $contract->contratoFechas?->fecha_anulacion ? Carbon\Carbon::parse($contract->contratoFechas?->fecha_anulacion)->format('d/m/Y') : 'No asignada' }}--}}
                                        {{--                                                    {{ $contract->contratoFechas?->fecha_anulacion ? Carbon\Carbon::parse($contract->contratoFechas?->fecha_anulacion)->diffForHumans() : '' }}--}}
                                        {{--                                                </td>--}}
                                        {{--                                                <td class="px-6 py-4 whitespace-no-wrap">{{ $contract->usuarios->solicitante->name ?? 'No Asignado' }}</td>--}}
                                        {{--                                                <td class="px-6 py-4 whitespace-no-wrap">{{ $contract->usuarios->anulador->name ?? 'No Asignado' }}</td>--}}
                                        {{--                                                @break--}}
                                        {{--                                            @case('entregado')--}}
                                        {{--                                                <td class="px-6 py-4 whitespace-no-wrap">--}}
                                        {{--                                                    {{ $contract->contratoFechas?->fecha_solicitud ? Carbon\Carbon::parse($contract->contratoFechas?->fecha_solicitud)->format('d/m/Y') : 'No asignada' }}--}}
                                        {{--                                                    {{ $contract->contratoFechas?->fecha_solicitud ? Carbon\Carbon::parse($contract->contratoFechas?->fecha_solicitud)->diffForHumans() : '' }}--}}
                                        {{--                                                </td>--}}
                                        {{--                                                <td class="px-6 py-4 whitespace-no-wrap">--}}
                                        {{--                                                    {{ $contract->contratoFechas?->fecha_aprobacion ? Carbon\Carbon::parse($contract->contratoFechas?->fecha_aprobacion)->format('d/m/Y') : 'No asignada' }}--}}
                                        {{--                                                    {{ $contract->contratoFechas?->fecha_aprobacion ? Carbon\Carbon::parse($contract->contratoFechas?->fecha_aprobacion)->diffForHumans() : '' }}--}}
                                        {{--                                                </td>--}}
                                        {{--                                                <td class="px-6 py-4 whitespace-no-wrap">--}}
                                        {{--                                                    {{ $contract->contratoFechas?->fecha_entrega ? Carbon\Carbon::parse($contract->contratoFechas?->fecha_entrega)->format('d/m/Y') : 'No asignada' }}--}}
                                        {{--                                                    {{ $contract->contratoFechas?->fecha_entrega ? Carbon\Carbon::parse($contract->contratoFechas?->fecha_entrega)->diffForHumans() : '' }}--}}
                                        {{--                                                </td>--}}
                                        {{--                                                <td class="px-6 py-4 whitespace-no-wrap">{{ $contract->usuarios->solicitante->name ?? 'No Asignado' }}</td>--}}
                                        {{--                                                <td class="px-6 py-4 whitespace-no-wrap">{{ $contract->usuarios->aprobador->name ?? 'No Asignado' }}</td>--}}
                                        {{--                                                @break--}}
                                        {{--                                            @case('recogido')--}}
                                        {{--                                                <td class="px-6 py-4 whitespace-no-wrap">--}}
                                        {{--                                                    {{ $contract->contratoFechas?->fecha_solicitud ? Carbon\Carbon::parse($contract->contratoFechas?->fecha_solicitud)->format('d/m/Y') : 'No asignada' }}--}}
                                        {{--                                                    {{ $contract->contratoFechas?->fecha_solicitud ? Carbon\Carbon::parse($contract->contratoFechas?->fecha_solicitud)->diffForHumans() : '' }}--}}
                                        {{--                                                </td>--}}
                                        {{--                                                <td class="px-6 py-4 whitespace-no-wrap">--}}
                                        {{--                                                    {{ $contract->contratoFechas?->fecha_aprobacion ? Carbon\Carbon::parse($contract->contratoFechas?->fecha_aprobacion)->format('d/m/Y') : 'No asignada' }}--}}
                                        {{--                                                    {{ $contract->contratoFechas?->fecha_aprobacion ? Carbon\Carbon::parse($contract->contratoFechas?->fecha_aprobacion)->diffForHumans() : '' }}--}}
                                        {{--                                                </td>--}}
                                        {{--                                                <td class="px-6 py-4 whitespace-no-wrap">--}}
                                        {{--                                                    {{ $contract->contratoFechas?->fecha_entrega ? Carbon\Carbon::parse($contract->contratoFechas?->fecha_entrega)->format('d/m/Y') : 'No asignada' }}--}}
                                        {{--                                                    {{ $contract->contratoFechas?->fecha_entrega ? Carbon\Carbon::parse($contract->contratoFechas?->fecha_entrega)->diffForHumans() : '' }}--}}
                                        {{--                                                </td>--}}
                                        {{--                                                <td class="px-6 py-4 whitespace-no-wrap">--}}
                                        {{--                                                    {{ $contract->contratoFechas?->fecha_recogida ? Carbon\Carbon::parse($contract->contratoFechas?->fecha_recogida)->format('d/m/Y') : 'No asignada' }}--}}
                                        {{--                                                    {{ $contract->contratoFechas?->fecha_recogida ? Carbon\Carbon::parse($contract->contratoFechas?->fecha_recogida)->diffForHumans() : '' }}--}}
                                        {{--                                                </td>--}}
                                        {{--                                                <td class="px-6 py-4 whitespace-no-wrap">{{ $contract->usuarios->solicitante->name ?? 'No Asignado' }}</td>--}}
                                        {{--                                                <td class="px-6 py-4 whitespace-no-wrap">{{ $contract->usuarios->aprobador->name ?? 'No Asignado' }}</td>--}}
                                        {{--                                                <td class="px-6 py-4 whitespace-no-wrap">{{ $contract->usuarios->bajador->name ?? 'No Asignado' }}</td>--}}
                                        {{--                                                @break--}}
                                        {{--                                            @case('finalizado')--}}
                                        {{--                                                <td class="px-6 py-4 whitespace-no-wrap">--}}
                                        {{--                                                    {{ $contract->contratoFechas?->fecha_solicitud ? Carbon\Carbon::parse($contract->contratoFechas?->fecha_solicitud)->format('d/m/Y') : 'No asignada' }}--}}
                                        {{--                                                    {{ $contract->contratoFechas?->fecha_solicitud ? Carbon\Carbon::parse($contract->contratoFechas?->fecha_solicitud)->diffForHumans() : '' }}--}}
                                        {{--                                                </td>--}}
                                        {{--                                                <td class="px-6 py-4 whitespace-no-wrap">--}}
                                        {{--                                                    {{ $contract->contratoFechas?->fecha_aprobacion ? Carbon\Carbon::parse($contract->contratoFechas?->fecha_aprobacion)->format('d/m/Y') : 'No asignada' }}--}}
                                        {{--                                                    {{ $contract->contratoFechas?->fecha_aprobacion ? Carbon\Carbon::parse($contract->contratoFechas?->fecha_aprobacion)->diffForHumans() : '' }}--}}
                                        {{--                                                </td>--}}
                                        {{--                                                <td class="px-6 py-4 whitespace-no-wrap">--}}
                                        {{--                                                    {{ $contract->contratoFechas?->fecha_entrega ? Carbon\Carbon::parse($contract->contratoFechas?->fecha_entrega)->format('d/m/Y') : 'No asignada' }}--}}
                                        {{--                                                    {{ $contract->contratoFechas?->fecha_entrega ? Carbon\Carbon::parse($contract->contratoFechas?->fecha_entrega)->diffForHumans() : '' }}--}}
                                        {{--                                                </td>--}}
                                        {{--                                                <td class="px-6 py-4 whitespace-no-wrap">--}}
                                        {{--                                                    {{ $contract->contratoFechas?->fecha_recogida ? Carbon\Carbon::parse($contract->contratoFechas?->fecha_recogida)->format('d/m/Y') : 'No asignada' }}--}}
                                        {{--                                                    {{ $contract->contratoFechas?->fecha_recogida ? Carbon\Carbon::parse($contract->contratoFechas?->fecha_recogida)->diffForHumans() : '' }}--}}
                                        {{--                                                </td>--}}
                                        {{--                                                <td class="px-6 py-4 whitespace-no-wrap">--}}
                                        {{--                                                    {{ $contract->contratoFechas?->fecha_finalizacion ? Carbon\Carbon::parse($contract->contratoFechas?->fecha_finalizacion)->format('d/m/Y') : 'No asignada' }}--}}
                                        {{--                                                    {{ $contract->contratoFechas?->fecha_finalizacion ? Carbon\Carbon::parse($contract->contratoFechas?->fecha_finalizacion)->diffForHumans() : '' }}--}}
                                        {{--                                                </td>--}}
                                        {{--                                                <td class="px-6 py-4 whitespace-no-wrap">{{ $contract->usuarios->solicitante->name ?? 'No Asignado' }}</td>--}}
                                        {{--                                                <td class="px-6 py-4 whitespace-no-wrap">{{ $contract->usuarios->aprobador->name ?? 'No Asignado' }}</td>--}}
                                        {{--                                                <td class="px-6 py-4 whitespace-no-wrap">{{ $contract->usuarios->bajador->name ?? 'No Asignado' }}</td>--}}
                                        {{--                                                <td class="px-6 py-4 whitespace-no-wrap">{{ $contract->usuarios->finalizador->name ?? 'No Asignado' }}</td>--}}
                                        {{--                                                @break--}}
                                        {{--                                        @endswitch--}}
                                        {{--                                        <td class="px-6 py-4 whitespace-no-wrap">{{ \App\Models\Contrato::ESTADO_ORDEN[$contract->estado_orden] }}</td>--}}
                                        {{--                                        <td class="px-6 py-4 whitespace-no-wrap">--}}
                                        {{--                                            <button wire:click="showContract({{ $contract->id }})" class="text-blue-500 hover:text-blue-700">--}}
                                        {{--                                                <i class="fas fa-eye"></i>--}}
                                        {{--                                            </button>--}}
                                        {{--                                            <button wire:click="openModal('edit', {{ $contract->id }})" class="text-green-500 hover:text-green-700">--}}
                                        {{--                                                <i class="fas fa-edit"></i>--}}
                                        {{--                                            </button>--}}
                                        {{--                                            <button wire:click="openModal('delete', {{ $contract->id }})" class="text-red-500 hover:text-red-700">--}}
                                        {{--                                                <i class="fas fa-trash"></i>--}}
                                        {{--                                            </button>--}}
                                        {{--                                        </td>--}}
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

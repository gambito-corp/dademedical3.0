<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('paciente.Patients Panel') }}
        </h2>
    </x-slot>
    <div class="py-4">
        <div class="max-w-screen mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 space-y-4">
                    <div class="flex justify-end space-x-2">
                        <button
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-xl"
                            title="{{ __('paciente.Add Patient') }}"
                            wire:click="openModal('create')">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <div class="flex justify-between space-x-2">
                        <div class="{{ $currentFilter == 'active' ? 'bg-blue-700 text-white' : 'bg-white text-blue-500 border border-blue-500 hover:text-white hover:border-0 ' }} w-1/2 p-2 hover:bg-blue-700 font-bold py-2 px-4 rounded-xl transition-all duration-300" wire:click="changePatient('active')">
                            <span>{{ __('paciente.Active Patients') }}</span>
                        </div>
                        <div class="{{ $currentFilter == 'inactive' ? 'bg-blue-700 text-white' : 'bg-white text-blue-500 border border-blue-500 hover:text-white hover:border-0 ' }} w-1/2 p-2 hover:bg-blue-700 font-bold py-2 px-4 rounded-xl transition-all duration-300" wire:click="changePatient('inactive')">
                            <span>{{ __('paciente.Inactive Patients') }}</span>
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
                                    placeholder="{{ __('Pagination') }}"
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
                                    <th wire:click="sortBy('name')" class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                        {{ __('paciente.Name') }} @if($orderColumn == 'name') <i class="fas fa-sort-{{$orderDirection == 'asc' ? 'up' : 'down'}}"></i> @endif
                                    </th>
                                    <th wire:click="sortBy('surname')" class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                        {{ __('paciente.Surname') }} @if($orderColumn == 'surname') <i class="fas fa-sort-{{$orderDirection == 'asc' ? 'up' : 'down'}}"></i> @endif
                                    </th>
                                    <th wire:click="sortBy('dni')" class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                        {{ __('paciente.DNI') }} @if($orderColumn == 'dni') <i class="fas fa-sort-{{$orderDirection == 'asc' ? 'up' : 'down'}}"></i> @endif
                                    </th>
                                    <th wire:click="sortBy('hospital_nombre')" class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                        {{ __('paciente.Site') }} @if($orderColumn == 'hospital_nombre') <i class="fas fa-sort-{{$orderDirection == 'asc' ? 'up' : 'down'}}"></i> @endif
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
                                                        <button
                                                            class="text-green-500 hover:text-green-700"
                                                            title="{{ __('paciente.Edit Patient') }}"
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
                        {{ $data->links('components.custom-pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($modalCreate)
        <x-dialog-modal wire:model="modalCreate" :maxWidth="'full'">
            <x-slot name="title">
                {{ __('paciente.Add Patient') }}
            </x-slot>
            <x-slot name="content">
                <livewire:patients.create-patient />
            </x-slot>
            <x-slot name="footer"></x-slot>
        </x-dialog-modal>
    @endif

    @if($modalEdit)
        <x-dialog-modal wire:model="modalEdit" :maxWidth="'full'">
            <x-slot name="title">
                {{ __('paciente.Edit') }}
            </x-slot>
            <x-slot name="content">
                <livewire:patients.edit-patient :patientId="$paciente->id"/>
            </x-slot>
{{--            <x-slot name="content">--}}
{{--            </x-slot>--}}
            <x-slot name="footer"></x-slot>
        </x-dialog-modal>
    @endif

    @if($modalShow)
        <x-dialog-modal wire:model="modalShow" :maxWidth="'full'">
            <x-slot name="title">
                {{ __('paciente.Show Patient') }}
            </x-slot>
            <x-slot name="content">
                <livewire:patients.patient-show :patient="$patient"/>
            </x-slot>
            <x-slot name="footer"></x-slot>
        </x-dialog-modal>
    @endif

    @if($modalDelete)
        <x-dialog-modal wire:model="modalDelete" :maxWidth="'sm'">
            <x-slot name="title">
                {{ __('paciente.Delete Patient') }} {{ $patient->name }} {{ $patient->surname }}
            </x-slot>
            <x-slot name="content">
                {{ __('paciente.Are you sure you want to delete this patient?') }} {{ $patient->name }} {{ $patient->surname }}?
            </x-slot>
            <x-slot name="footer">
                <x-button wire:click="closeModal('delete')" class="bg-blue-500 mr-4 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('paciente.Cancel') }}
                </x-button>
                <x-danger-button wire:click="delete()" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('paciente.Delete') }}
                </x-danger-button>
            </x-slot>
        </x-dialog-modal>
    @endif
</div>

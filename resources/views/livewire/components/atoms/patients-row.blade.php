<tr wire:key="{{$keyIndex}}">
    <td class="px-6 py-4 whitespace-no-wrap">
        <div class="flex items-center">
            <div>
                <div class="text-sm leading-5 text-gray-900">
                    {{ $keyIndex }}
                </div>
            </div>
        </div>
    </td>
    <td class="px-6 py-4 whitespace-no-wrap">
        <div class="flex items-center">
            <div>
                <div class="text-sm leading-5 text-gray-900">
                    {{ $patient->name }}
                </div>
            </div>
        </div>
    </td>
    <td class="px-6 py-4 whitespace-no-wrap">
        <div class="flex items-center">
            <div>
                <div class="text-sm leading-5 text-gray-900">
                    {{ $patient->surname }}
                </div>
            </div>
        </div>
    </td>
    <td class="px-6 py-4 whitespace-no-wrap">
        <div class="flex items-center">
            <div>
                <div class="text-sm leading-5 text-gray-900">
                    {{ $patient->dni }}
                </div>
            </div>
        </div>
    </td>
    <td class="px-6 py-4 whitespace-no-wrap">
        <div class="flex items-center">
            <div>
                <div class="text-sm leading-5 text-gray-900">
                    {{ $patient->User?->hospital?->nombre ?? 'N/A' }}
                </div>
            </div>
        </div>
    </td>
    <td class="px-6 py-4 whitespace-no-wrap">
        <div class="flex items-center">
            <div class="text-sm leading-5 text-gray-900">
                <div class="flex items-center space-x-1">
                    <!-- Botón Editar Paciente -->
                    <button title="Editar paciente" class="p-2 rounded bg-blue-500 text-white hover:bg-blue-600 focus:outline-none" wire:click="$emit('openModal', 'edit', {{ $patient['id'] }})">
                        <i class="fas fa-edit"></i>
                    </button>
                    <!-- Botón Mostrar Paciente -->
                    <button title="Mostrar paciente" class="p-2 rounded bg-green-500 text-white hover:bg-green-600 focus:outline-none" wire:click="$emit('openModal', 'show', {{ $patient['id'] }})">
                        <i class="fas fa-eye"></i>
                    </button>
                    <!-- Botón Borrar Paciente -->
                    @if($currentFilter != 'deleted')
                        <button title="Borrar paciente" class="p-2 rounded bg-red-500 text-white hover:bg-red-600 focus:outline-none" wire:click="$emit('openModal', 'delete', {{ $patient['id'] }})">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    @endif
                    <!-- Botón Restablecer Paciente -->
                    @if($currentFilter == 'deleted')
                        <button title="Restablecer paciente" class="p-2 rounded bg-orange-500 text-white hover:bg-orange-600 focus:outline-none" wire:click="$emit('openModal', 'restore', {{ $patient['id'] }})">
                            <i class="fas fa-recycle"></i>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </td>
</tr>

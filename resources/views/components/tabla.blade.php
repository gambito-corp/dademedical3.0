<table class="min-w-full divide-y divide-gray-200">
    <thead>
    <tr>
        @foreach($headers as $header)
            <th wire:click="sortBy('{{ $header['column'] }}')" class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                {{ $header['label'] }}
                @if($orderColumn == $header['column'])
                    <i class="fas fa-sort-{{ $orderDirection == 'asc' ? 'up' : 'down' }}"></i>
                @endif
            </th>
        @endforeach
        <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
            Acciones
        </th>
    </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
    @forelse($data as $key => $item)
        <livewire:components.atoms.patients-row :patient="$item" :keyIndex="'patient-' . $item->id"/>
    @empty
        <tr>
            <td class="px-6 py-4 whitespace-no-wrap" colspan="{{ count($headers) + 1 }}">
                <div class="text-sm leading-5 text-gray-900">
                    No hay elementos para mostrar
                </div>
            </td>
        </tr>
    @endforelse
    </tbody>
</table>

<div>
    <label for="inputSelect"></label>
    <input
        class="border border-gray-300 p-2 w-full"
        name="inputSelect"
        id="inputSelect"
        type="text"
        placeholder="{{ $placeholderText }}"
        wire:model="selected"
        wire:click.live="showDropdownComponete"
        wire:focus="showDropdownComponete"
        wire:keydown="filterSearchSelect"
        x-on:click="$wire.showDropdown = true"
    >
    @if($showDropdown)
        <div class="border border-gray-300 max-h-48 overflow-y-auto">
            @forelse($items as $key => $item)
                <div class="p-2 hover:bg-gray-100" wire:click="selectedSearchInput('{{ $key }}')" {{--wire:key="{{$key}}"--}}>{{ $item }}</div>
            @empty
                <div class="p-2">Buscando Elementos...</div>
            @endforelse
        </div>
    @endif

</div>

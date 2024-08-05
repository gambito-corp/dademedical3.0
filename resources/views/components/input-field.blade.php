<div class="mb-4">
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>

    @if($type == 'select')
        <select name="{{ $name }}" id="{{ $name }}" wire:model.lazy="{{ $name }}" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
            <option value="">Selecciona una opción</option>
            @foreach($options as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
    @elseif($type == 'file')
        <input type="file" name="{{ $name }}" id="{{ $name }}" wire:model.lazy="{{ $name }}" class="mt-1 block w-full border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
    @else
        <input type="text" name="{{ $name }}" id="{{ $name }}" wire:model.lazy="{{ $name }}" @if($name === 'paciente.numero_documento') wire:blur="checkReniec" @endif class="mt-1 block w-full border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
    @endif

    @error($name)
    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

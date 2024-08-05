<div>
    <select wire:change="setLanguage($event.target.value)" class="border border-gray-300 p-2 rounded">
        @foreach ($languages as $lang)
            <option value="{{ $lang }}" {{ app()->getLocale() == $lang ? 'selected' : '' }}>
                {{ strtoupper($lang) }}
            </option>
        @endforeach
    </select>
</div>

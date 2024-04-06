<div>
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
        <div class="space-y-1 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                <path d="M28 8H12a4 4 0 00-4 4v24a4 4 0 004 4h16m4-32l8 8m-8-8v28a4 4 0 004 4h4a4 4 0 004-4V12a4 4 0 00-4-4h-4a4 4 0 01-4-4z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <div class="flex text-sm text-gray-600">
                <label for="{{ $name }}" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                    <span>Cargar un archivo</span>
{{--                    <input type="file" id="usuario.profile_photo_path" name="{{$name}}"/>--}}
                    <input id="{{ $name }}" name="{{ $name }}" type="file" />
                </label>
            </div>
            <p class="text-xs text-gray-500">PNG, JPG, GIF hasta 10MB</p>
        </div>
    </div>
    @if ($error)
        <p class="mt-2 text-sm text-red-600">{{ $error }}</p>
    @endif
</div>

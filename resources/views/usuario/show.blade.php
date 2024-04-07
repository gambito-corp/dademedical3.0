<x-app-layout>
    <x-slot name="header">
        <div class="flex">
            <a href="{{$config['back']}}" class="mr-4 leading-tight relative inline cursor-pointer text-xl font-medium before:bg-violet-600  before:absolute before:-bottom-1 before:block before:h-[2px] before:w-full before:origin-bottom-right before:scale-x-0 before:transition before:duration-300 before:ease-in-out hover:before:origin-bottom-left hover:before:scale-x-100">
                <i class="fas fa-arrow-left mr-2"></i> {{__('Back')}}
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('users.User show') }}
            </h2>
        </div>
    </x-slot>
    <div class="bg-gray-100 font-sans p-8">
        <div class="mt-4 card bg-white p-8 rounded-lg shadow-lg relative text-center">
            @if($config['anterior'])
                <a href="{{$config['anterior']}}">
                    <div class="absolute inset-y-0 left-0 flex items-center justify-center bg-gray-200 hover:bg-gray-300 transition-all w-12">
                        <i class="fas fa-chevron-left text-2xl"></i>
                    </div>
                </a>
            @endif

            @if($config['siguiente'])
                <a href="{{$config['siguiente']}}">
                    <div class="absolute inset-y-0 right-0 flex items-center justify-center bg-gray-200 hover:bg-gray-300 transition-all w-12">
                        <i class="fas fa-chevron-right text-2xl ml-2"></i>
                    </div>
                </a>
            @endif
            <div class="mb-4">
                @foreach ($config['fields'] as $label => $value)
                    <div class="flex justify-left mb-2">
                        <span class="font-bold mr-2 ml-12">{{ $label }}:</span>
                        <span>{{ $value }}</span>
                    </div>
                @endforeach
            </div>

            <div class="flex justify-between mt-4 ml-12">
                @foreach ($config['actions'] as $actionName => $action)
                    <a href="{{ $action['url'] }}"
                       class="bg-white text-black border border-gray-300 px-4 py-2 rounded {{ $action['color'] }} hover:{{ $action['hover'] }} {{ $loop->last ? 'mr-12' : '' }}">
                        <i class="{{ $action['icono'] }}"></i> {{ $actionName }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>


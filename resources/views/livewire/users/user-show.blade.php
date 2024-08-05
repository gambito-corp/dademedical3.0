<div class="mt-4 card bg-white p-8 rounded-lg shadow-lg relative text-center">
    <h1 class="text-4xl font-bold underline mb-4 text-black">{{ __('users.show_user') }} {{$user->name}}</h1>

    <div class="mb-4">
        <div class="flex justify-left mb-2">
            <span class="font-bold mr-2 ml-12">{{ __('users.name') }}:</span>
            <span>{{ $user->name }}</span>
        </div>
        <div class="flex justify-left mb-2">
            <span class="font-bold mr-2 ml-12">{{ __('users.surname') }}:</span>
            <span>{{ $user->surname }}</span>
        </div>
        <div class="flex justify-left mb-2">
            <span class="font-bold mr-2 ml-12">{{ __('users.email') }}:</span>
            <span>{{ $user->email }}</span>
        </div>
        <div class="flex justify-left mb-2">
            <span class="font-bold mr-2 ml-12">{{ __('users.username') }}:</span>
            <span>{{ $user->username }}</span>
        </div>
        <x-danger-button wire:click="close">
            {{ __('users.close') }}
        </x-danger-button>
    </div>
</div>

<div class="mt-4 card bg-white p-8 rounded-lg shadow-lg relative text-center">
    <h1 class="text-4xl font-bold underline mb-4 text-black">Usuario {{$user->name}}</h1>

    <div class="mb-4">
        <div class="flex justify-left mb-2">
            <span class="font-bold mr-2 ml-12">Nombre:</span>
            <span>{{ $user->name }}</span>
        </div>
        <div class="flex justify-left mb-2">
            <span class="font-bold mr-2 ml-12">Apellidos:</span>
            <span>{{ $user->surname }}</span>
        </div>
        <div class="flex justify-left mb-2">
            <span class="font-bold mr-2 ml-12">Email:</span>
            <span>{{ $user->email }}</span>
        </div>
        <div class="flex justify-left mb-2">
            <span class="font-bold mr-2 ml-12">NickName:</span>
            <span>{{ $user->username }}</span>
        </div>
        <x-danger-button wire:click="close">
            {{ __('Cerrar') }}
        </x-danger-button>
    </div>
</div>

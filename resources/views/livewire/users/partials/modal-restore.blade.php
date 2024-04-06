<div class="fixed top-0 bottom-0 left-0 right-0 w-full h-full bg-gray-800 bg-opacity-60 flex items-center justify-center">
    <div class="bg-white rounded-lg w-1/2">
        <div class="flex flex-col items-start p-4">
            <form method="POST" action="{{ route('usuarios.restore', $user) }}">
                @csrf
                @method('PATCH')
                <div class="fixed top-0 bottom-0 left-0 right-0 w-full h-full bg-gray-800 bg-opacity-60 flex items-center justify-center">
                    <div class="bg-white rounded-lg w-1/2">
                        <div class="flex flex-col items-start p-4">
                            <div class="flex items-center w-full">
                                <div class="text-gray-900 font-medium text-lg">Confirmar Restauracion de usuario {{$user->name}}</div>
                                <svg class="ml-auto fill-current text-gray-700 w-6 h-6 cursor-pointer" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18" wire:click="closeModal">
                                    <path d="M18 1.3L16.7 0 9 7.6 1.3 0 0 1.3 7.6 9 0 16.7 1.3 18 9 10.4l7.7 7.6 1.3-1.3L10.4 9z"/>
                                </svg>
                            </div>
                            <hr>
                            <div class="ml-6 mt-5">
                                ¿Seguro que quieres Restaurar este usuario?
                            </div>
                            <div class="ml-auto mr-5 mt-5 mb-3">
                                <input type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" value="Si, Restaurar usuario">
                                <button type="button" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" wire:click="closeModal">No, vuelve atrás</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div>
    <div class="{{ $isOpen ? 'block' : 'hidden' }} {{ !$isOpen ? 'altoAnimado2' : ($isOpen && $first ? 'h-32' : 'altoAnimado1') }} overflow-auto fixed inset-0 z-50 bg-white h-screen shadow-lg">
        <livewire:components.organism.aside />
        <!-- Botón de hamburguesa para cerrar -->
        <button wire:click="toggleSidebar" class="fixed top-4 right-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <!-- Ítem de Cerrar Sesión -->
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="block text-gray-500 py-2.5 px-4 my-2 rounded transition duration-200 hover:bg-gradient-to-r hover:from-cyan-500 hover:to-cyan-500 hover:text-white mt-auto">
                <i class="fas fa-sign-out-alt mr-2"></i>Cerrar sesión
            </button>
        </form>

        <!-- Señalador de ubicación -->
        <div class="bg-gradient-to-r from-cyan-300 to-cyan-500 h-px mt-2"></div>
        <!-- Copyright al final de la navegación lateral -->
        <p class="mb-1 px-5 py-3 text-left text-xs text-cyan-500">Copyright WCSLAT@2023</p>
    </div>
</div>

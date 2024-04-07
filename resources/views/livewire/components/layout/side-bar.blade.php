<div class="p-2 overflow-auto h-screen bg-white w-full flex flex-col md:flex {{ !$isOpen ? 'anchoAnimado2' : ($isOpen && $first ? 'w-60' : 'anchoAnimado1') }} hidden md:flex" id="sideNav">
    <livewire:components.organism.aside />
    <div class="fixed bottom-0">
        <form action="{{ route('logout') }}" method="POST" class="mb-4 ">
            @csrf
            <button type="submit" class="block  @if($isOpen) md:min-w-52 @endif text-gray-500 py-2.5 px-4 my-2 rounded transition duration-200 hover:bg-gradient-to-r hover:from-cyan-500 hover:to-cyan-500 hover:text-white">
                <i class="fas fa-sign-out-alt"></i>
                @if($isOpen) Cerrar sesión @endif
            </button>
        </form>

        @if($isOpen)
            <!-- Señalador de ubicación -->
            <div class="bg-gradient-to-r from-cyan-300 to-cyan-500 h-px"></div>

            <!-- Copyright al final de la navegación lateral -->
            <p class="px-5 py-3 text-left text-xs text-cyan-500">Copyright Perpetuo@2024</p>
        @endif
    </div>
</div>

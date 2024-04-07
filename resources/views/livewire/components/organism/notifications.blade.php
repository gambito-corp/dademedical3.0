<div>
    @if($showNotifications)
        <div class="absolute mt-4 overflow-y-scroll text-blue-800 bg-white border border-gray-200 max-w-md" style="height: 200px; width: 300px; right: 0; top:10px;">
            <div class="flex justify-end">
                <button wire:click="closeNotifications" class="p-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <h1 class="text-lg font-bold">Notificaciones</h1>
            @for($i = 0; $i<10; $i++)
                <div class="mt-1 mx-auto bg-white overflow-hidden border border-gray-200 rounded-xl">
                    <a href="/">
                        <div class="md:flex">
                            <div class="p-2">
                                <p class="uppercase tracking-wide text-sm text-indigo-500 font-semibold">Patient: Jane Doe</p>
                                <p class="block mt-1 text-xs font-medium text-black">Appointment Time: 13:00 - 14:00</p>
                                <p class="mt-2 text-gray-500">Doctor: Dr. John Doe</p>
                            </div>
                        </div>
                    </a>
                </div>
            @endfor
        </div>
    @endif

</div>

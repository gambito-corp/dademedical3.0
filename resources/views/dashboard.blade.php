<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class=" mx-auto sm:px-6 lg:px-8">
            <div class="container mx-auto mt-10">
                <div class="p-6 max-w-sm mx-auto bg-white rounded-xl shadow-md flex items-center space-x-4">
                    <div>
                        @dump(session()->all())

                        <div class="text-2xl font-medium text-red-900">¡Graficas a presentar!</div>
                        <p class="text-gray-500">una Card con nuevas Solicitudes de (hoy/semana/mes)</p>
                        <p class="text-gray-500">una Card con nuevas entregas de (hoy/semana/mes)</p>
                        <p class="text-gray-500">una Card con nuevas recojos de (hoy/semana/mes)</p>
                        <p class="text-gray-500">una Card con nuevas finalizados de (hoy/semana/mes)</p>
                        <p class="text-gray-500">una Card con nuevas potencia total de LPM alquilado de (hoy/semana/mes)</p>
                        <p class="text-gray-500">una Card con nuevas pendientes incidencias de (hoy/semana/mes)</p>
                        <p class="text-gray-500">una Card con nuevas pendientes crecimiento de Contratos activos</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

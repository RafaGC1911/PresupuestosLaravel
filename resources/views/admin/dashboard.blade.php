<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Panel de administración
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Mensaje de bienvenida con el nombre del usuario logueado --}}
            <p class="text-gray-600 mb-6">Bienvenido, {{ auth()->user()->name }}</p>

            {{-- Grid de dos columnas para las tarjetas de acceso rápido --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                {{-- Tarjeta para ir al listado de productos --}}
                <a href="{{ route('admin.productos.index') }}"
                    class="bg-white shadow-sm rounded-lg p-6 hover:shadow-md transition flex items-center gap-4">
                    <div class="bg-blue-100 text-blue-600 rounded-full p-4 text-2xl">📦</div>
                    <div>
                        <h3 class="font-semibold text-gray-800 text-lg">Productos</h3>
                        <p class="text-gray-500 text-sm">Ver, crear y gestionar productos</p>
                    </div>
                </a>

                {{-- Tarjeta para ir al listado de usuarios --}}
                <a href="{{ route('admin.users.index') }}"
                    class="bg-white shadow-sm rounded-lg p-6 hover:shadow-md transition flex items-center gap-4">
                    <div class="bg-purple-100 text-purple-600 rounded-full p-4 text-2xl">👥</div>
                    <div>
                        <h3 class="font-semibold text-gray-800 text-lg">Usuarios</h3>
                        <p class="text-gray-500 text-sm">Ver, crear y gestionar usuarios</p>
                    </div>
                </a>

            </div>
        </div>
    </div>
</x-app-layout>
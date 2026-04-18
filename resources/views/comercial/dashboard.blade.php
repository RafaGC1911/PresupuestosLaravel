<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Panel comercial
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Mensaje de bienvenida con el nombre del usuario logueado --}}
            {{-- auth()->user() devuelve el usuario de la sesión actual --}}
            <p class="text-gray-600 mb-6">Bienvenido, {{ auth()->user()->name }}</p>

            {{-- Grid de dos columnas para las tarjetas de acceso rápido --}}
            {{-- En móvil se muestra en una columna, en pantallas sm o más en dos --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                {{-- Tarjeta para ir al listado de presupuestos --}}
                {{-- Es un enlace que parece una tarjeta, hover:shadow-md añade sombra al pasar el ratón --}}
                <a href="{{ route('comercial.presupuestos.index') }}"
                    class="bg-white shadow-sm rounded-lg p-6 hover:shadow-md transition flex items-center gap-4">
                    {{-- Icono de la tarjeta con fondo de color --}}
                    <div class="bg-blue-100 text-blue-600 rounded-full p-4 text-2xl">📋</div>
                    <div>
                        <h3 class="font-semibold text-gray-800 text-lg">Mis presupuestos</h3>
                        <p class="text-gray-500 text-sm">Ver, crear y gestionar presupuestos</p>
                    </div>
                </a>

                {{-- Tarjeta para ir directamente al formulario de crear presupuesto --}}
                <a href="{{ route('comercial.presupuestos.create') }}"
                    class="bg-white shadow-sm rounded-lg p-6 hover:shadow-md transition flex items-center gap-4">
                    <div class="bg-green-100 text-green-600 rounded-full p-4 text-2xl">➕</div>
                    <div>
                        <h3 class="font-semibold text-gray-800 text-lg">Crear presupuesto</h3>
                        <p class="text-gray-500 text-sm">Añadir un nuevo presupuesto</p>
                    </div>
                </a>

                {{-- Tarjeta para ver el catálogo de productos --}}
                <a href="{{ route('comercial.catalogo.index') }}"
                    class="bg-white shadow-sm rounded-lg p-6 hover:shadow-md transition flex items-center gap-4">
                    <div class="bg-yellow-100 text-yellow-600 rounded-full p-4 text-2xl">🛍️</div>
                    <div>
                        <h3 class="font-semibold text-gray-800 text-lg">Catálogo de productos</h3>
                        <p class="text-gray-500 text-sm">Ver todos los productos disponibles</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Catálogo de productos
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Botón para volver al panel principal --}}
            <div class="mb-6">
                <a href="{{ route('dashboard') }}"
                    class="text-gray-500 hover:underline text-sm">
                    ← Volver al panel principal
                </a>
            </div>

            {{-- Hacer responsive los productos --}}
            {{-- En móvil una columna, en tablet dos, en escritorio tres --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                @forelse($productos as $producto)
                {{-- El @forelse es como un @foreach pero con la ventaja de que si el array está vacío muestra el mensaje del @empty en lugar de no mostrar nada.--}}
                    {{-- Tarjeta de producto --}}
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">

                        {{-- Imagen del producto --}}
                        @if($producto->imagen)
                            {{-- Si tiene imagen la mostramos ocupando todo el ancho de la tarjeta --}}
                            {{-- object-cover hace que la imagen cubra el espacio sin deformarse --}}
                            <img src="{{ asset('storage/' . $producto->imagen) }}"
                                alt="{{ $producto->tipo }}"
                                class="w-full h-48 object-cover">
                        @else
                            {{-- Si no tiene imagen mostramos un placeholder gris --}}
                            <div class="w-full h-48 bg-gray-100 flex items-center justify-center">
                                <span class="text-gray-400 text-sm">Sin imagen</span>
                            </div>
                        @endif

                        {{-- Datos del producto --}}
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-800 text-lg">{{ $producto->tipo }}</h3>
                            <p class="text-blue-600 font-semibold mt-1">
                                {{ number_format($producto->precio_base, 2) }} €
                            </p>
                        </div>

                    </div>

                {{-- forelse muestra esto si no hay productos --}}
                @empty
                    <p class="text-gray-500 col-span-3">No hay productos disponibles.</p>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>
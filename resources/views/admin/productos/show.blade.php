<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalle del producto
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-4">

                    <div>
                        <span class="font-semibold text-gray-600">ID:</span>
                        <span>{{ $producto->id }}</span>
                    </div>

                    <div>
                        <span class="font-semibold text-gray-600">Tipo:</span>
                        <span>{{ $producto->tipo }}</span>
                    </div>

                    <div>
                        <span class="font-semibold text-gray-600">Precio base:</span>
                        <span>{{ $producto->precio_base }} €</span>
                    </div>

                    {{-- Botón para volver al listado --}}
                    <div class="pt-4">
                        <a href="{{ route('admin.productos.index') }}" 
                           class="text-blue-600 hover:underline">
                            ← Volver al listado
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
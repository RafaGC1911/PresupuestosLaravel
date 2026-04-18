<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Productos
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    {{-- Mensaje de éxito --}}
                    @if(session('success'))
                    <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                    @endif

                    {{-- Mensaje de error --}}
                    @if(session('error'))
                    <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                    @endif

                    {{-- Botón para volver al panel principal --}}
                    <div class="mb-4">
                        <a href="{{ route('dashboard') }}"
                            class="text-gray-500 hover:underline text-sm">
                            ← Volver al panel principal
                        </a>
                    </div>

                    {{-- Botón crear producto --}}
                    <div class="mb-4">
                        <a href="{{ route('admin.productos.create') }}"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            + Crear producto
                        </a>
                    </div>

                    <table class="w-full text-left border-collapse table-fixed">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="w-16 py-3 px-6 text-gray-600 font-semibold">ID</th>
                                {{-- Columna para la imagen --}}
                                <th class="w-24 py-3 px-6 text-gray-600 font-semibold">Imagen</th>
                                <th class="w-1/3 py-3 px-6 text-gray-600 font-semibold">Tipo</th>
                                <th class="w-1/3 py-3 px-6 text-gray-600 font-semibold">Precio base</th>
                                <th class="w-1/3 py-3 px-6 text-gray-600 font-semibold">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($productos as $producto)
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="py-3 px-6">{{ $producto->id }}</td>
                                <td class="py-3 px-6">
                                    {{-- Si tiene imagen la mostramos en miniatura --}}
                                    @if($producto->imagen)
                                    <img src="{{ asset('storage/' . $producto->imagen) }}"
                                        alt="Imagen del producto"
                                        {{-- h-12 es la altura de la miniatura, w-auto mantiene proporciones --}}
                                        class="h-12 w-auto rounded">
                                    @else
                                    {{-- Si no tiene imagen mostramos un guión --}}
                                    <span class="text-gray-400 text-sm">Sin imagen</span>
                                    @endif
                                </td>
                                <td class="py-3 px-6">{{ $producto->tipo }}</td>
                                <td class="py-3 px-6">{{ number_format($producto->precio_base, 2) }} €</td>
                                <td class="py-3 px-6">
                                    <div class="flex gap-4">
                                        <a href="{{ route('admin.productos.show', $producto) }}"
                                            class="text-blue-600 hover:underline">Ver</a>
                                        <a href="{{ route('admin.productos.edit', $producto) }}"
                                            class="text-yellow-600 hover:underline">Editar</a>
                                        <form action="{{ route('admin.productos.destroy', $producto) }}" method="POST"
                                            onsubmit="return confirm('¿Seguro que quieres eliminar este producto?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
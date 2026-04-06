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
                    {{-- Botón para volver al panel principal --}}
                    <div class="mb-6">
                        <a href="{{ route('dashboard') }}"
                            class="text-gray-500 hover:underline text-sm">
                            ← Volver al panel principal
                        </a>
                    </div>
                    <div class="mb-4">
                        <a href="{{ route('admin.productos.create') }}"
                            class="bg-blue-600 px-4 py-2 text-white rounded hover:bg-blue-700">
                            + Crear producto
                        </a>
                    </div>
                    <table class="w-full border-collapse table-fixed">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="w-16 py-3 px-6 text-gray-600 font-semibold  text-center">ID</th>
                                <th class="w-1/3 py-3 px-6 text-gray-600 font-semibold text-center">Tipo</th>
                                <th class="w-1/3 py-3 px-6 text-gray-600 font-semibold text-center">Precio base</th>
                                <th class="w-1/3 py-3 px-6 text-gray-600 font-semibold text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($productos as $producto)
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="py-3 px-6 text-center">{{ $producto->id }}</td>
                                <td class="py-3 px-6 text-center">{{ $producto->tipo }}</td>
                                <td class="py-3 px-6 text-center">{{ $producto->precio_base }} €</td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('admin.productos.show', $producto) }}"
                                            class="text-blue-600 hover:underline">Ver</a>
                                        <a href="{{ route('admin.productos.edit', $producto) }}"
                                            class="text-yellow-600 hover:underline">Editar</a>

                                        {{-- El borrado necesita un formulario porque tiene que enviar una petición DELETE --}}
                                        {{-- No se puede hacer con un simple enlace <a> --}}
                                        <form action="{{ route('admin.productos.destroy', $producto) }}" method="POST"
                                            onsubmit="return confirm('¿Seguro que quieres eliminar este producto?')">{{--Esto lanza un alert--}}
                                            @csrf
                                            {{-- Le decimos a Laravel que es una petición DELETE --}}
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
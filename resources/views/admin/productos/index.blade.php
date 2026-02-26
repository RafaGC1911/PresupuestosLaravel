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
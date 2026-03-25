<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mis presupuestos
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    {{-- Mensaje de éxito si existe --}}
                    @if(session('exito'))
                        <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">
                            {{ session('exito') }}
                        </div>
                    @endif

                    {{-- Botón crear presupuesto --}}
                    <div class="mb-4">
                        <a href="{{ route('comercial.presupuestos.create') }}"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            + Crear presupuesto
                        </a>
                    </div>

                    <table class="w-full text-left border-collapse table-fixed">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="w-16 py-3 px-6 text-gray-600 font-semibold">ID</th>
                                <th class="w-1/4 py-3 px-6 text-gray-600 font-semibold">Cliente</th>
                                <th class="w-1/4 py-3 px-6 text-gray-600 font-semibold">Fecha</th>
                                <th class="w-1/4 py-3 px-6 text-gray-600 font-semibold">Total</th>
                                <th class="w-1/4 py-3 px-6 text-gray-600 font-semibold">Estado</th>
                                <th class="w-1/4 py-3 px-6 text-gray-600 font-semibold">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($presupuestos as $presupuesto)
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="py-3 px-6">{{ $presupuesto->id }}</td>
                                {{-- Accedemos al nombre del cliente a través de la relación --}}
                                <td class="py-3 px-6">{{ $presupuesto->cliente->nombre }}</td>
                                <td class="py-3 px-6">{{ $presupuesto->fecha->format('d/m/Y') }}</td>
                                <td class="py-3 px-6">{{ number_format($presupuesto->total, 2) }} €</td>
                                <td class="py-3 px-6">{{ $presupuesto->estado }}</td>
                                <td class="py-3 px-6">
                                    <div class="flex gap-4">
                                        <a href="{{ route('comercial.presupuestos.show', $presupuesto) }}"
                                            class="text-blue-600 hover:underline">Ver</a>
                                        <a href="{{ route('comercial.presupuestos.edit', $presupuesto) }}"
                                            class="text-yellow-600 hover:underline">Editar</a>
                                        <form action="{{ route('comercial.presupuestos.destroy', $presupuesto) }}" method="POST"
                                            onsubmit="return confirm('¿Seguro que quieres eliminar este presupuesto?')">
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
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
                    {{-- Botón para volver al panel principal --}}
                    <div class="mb-6">
                        <a href="{{ route('dashboard') }}"
                            class="text-gray-500 hover:underline text-sm">
                            ← Volver al panel principal
                        </a>
                    </div>
                    {{-- Botón crear presupuesto --}}
                    <div class="mb-4">
                        <a href="{{ route('comercial.presupuestos.create') }}"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            + Crear presupuesto
                        </a>
                    </div>

                    {{-- Formulario de búsqueda --}}
                    {{-- method GET para que los filtros aparezcan en la URL y se puedan compartir --}}
                    <form method="GET" action="{{ route('comercial.presupuestos.index') }}"
                        class="mb-6 flex gap-4">

                        {{-- Buscador por nombre de cliente --}}
                        <input type="text" name="cliente"
                            placeholder="Buscar por cliente..."
                            value="{{ request('cliente') }}"
                            class="border border-gray-300 rounded px-4 py-2 w-1/3">

                        {{-- Filtro por estado --}}
                        <select name="estado" class="border border-gray-300 rounded px-8 py-2">
                            {{-- Opción vacía para mostrar todos --}}
                            <option value="">Todos los estados</option>
                            <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="aceptado" {{ request('estado') == 'aceptado' ? 'selected' : '' }}>Aceptado</option>
                            <option value="rechazado" {{ request('estado') == 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                        </select>

                        {{-- Botón buscar --}}
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Buscar
                        </button>

                        {{-- Botón para limpiar los filtros --}}
                        <a href="{{ route('comercial.presupuestos.index') }}"
                            class="text-gray-500 hover:underline py-2">
                            Limpiar
                        </a>

                    </form>
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
                                <td class="py-3 px-6">
                                    @if($presupuesto->estado == 'pendiente')
                                    <span class="bg-yellow-200 text-yellow-800 px-2 py-1 rounded">
                                        Pendiente
                                    </span>
                                    @elseif($presupuesto->estado == 'aceptado')
                                    <span class="bg-green-200 text-green-800 px-2 py-1 rounded">
                                        Aceptado
                                    </span>
                                    @elseif($presupuesto->estado == 'rechazado')
                                    <span class="bg-red-200 text-red-800 px-2 py-1 rounded">
                                        Rechazado
                                    </span>
                                    @endif
                                </td>
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
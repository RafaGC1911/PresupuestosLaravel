<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalle del presupuesto
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-6">

                    {{-- Datos principales del presupuesto --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <span class="font-semibold text-gray-600">Cliente:</span>
                            <span>{{ $presupuesto->cliente->nombre }}</span>
                        </div>
                        <div>
                            <span class="font-semibold text-gray-600">Fecha:</span>
                            <span>{{ $presupuesto->fecha->format('d/m/Y') }}</span>
                        </div>
                        <div>
                            <span class="font-semibold text-gray-600">Estado:</span>
                            <span>{{ $presupuesto->estado }}</span>
                        </div>
                        <div>
                            <span class="font-semibold text-gray-600">Total:</span>
                            <span>{{ number_format($presupuesto->total, 2) }} €</span>
                        </div>
                    </div>

                    {{-- Líneas del presupuesto --}}
                    <div>
                        <h3 class="font-semibold text-gray-700 text-lg mb-3">Líneas del presupuesto</h3>
                        <table class="w-full text-left border-collapse table-fixed">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="w-1/3 py-3 px-6 text-gray-600 font-semibold">Producto</th>
                                    <th class="w-1/3 py-3 px-6 text-gray-600 font-semibold">Precio unidad</th>
                                    <th class="w-1/3 py-3 px-6 text-gray-600 font-semibold">Cantidad</th>
                                    <th class="w-1/3 py-3 px-6 text-gray-600 font-semibold">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Recorremos todas las líneas del presupuesto --}}
                                @foreach($presupuesto->lineasPresupuestos as $linea)
                                <tr class="border-b border-gray-100">
                                    {{-- Accedemos al tipo del producto a través de la relación --}}
                                    <td class="py-3 px-6">{{ $linea->producto->tipo }}</td>
                                    <td class="py-3 px-6">{{ number_format($linea->precio, 2) }} €</td>
                                    <td class="py-3 px-6">{{ $linea->cantidad }}</td>
                                    {{-- El subtotal se calcula multiplicando precio por cantidad --}}
                                    <td class="py-3 px-6">{{ number_format($linea->precio * $linea->cantidad, 2) }} €</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Botones --}}
                    <div class="flex gap-4 pt-4">
                        <a href="{{ route('comercial.presupuestos.index') }}"
                            class="text-blue-600 hover:underline">
                            ← Volver al listado
                        </a>
                        <a href="{{ route('comercial.presupuestos.edit', $presupuesto) }}"
                            class="text-yellow-600 hover:underline">
                            Editar
                        </a>
                        <a href="{{ route('comercial.presupuestos.pdf', $presupuesto) }}"
                            class="text-purple-600 hover:underline">
                            Descargar PDF
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
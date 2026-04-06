<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Crear producto
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    {{-- action apunta al método store, method POST para enviar datos --}}
                    <form action="{{ route('admin.productos.store') }}" method="POST">

                        {{-- Laravel requiere esto en todos los formularios POST como medida de seguridad --}}
                        @csrf

                        {{-- Campo tipo --}}
                        <div class="mb-4">
                            <label class="block text-gray-600 font-semibold mb-1">Tipo</label>
                            {{-- old('tipo') recupera el valor si la validación falla, para no perder lo escrito --}}
                            <input type="text" name="tipo" value="{{ old('tipo') }}"
                                class="w-full border border-gray-300 rounded px-4 py-2">
                            {{-- Muestra el error de validación si lo hay --}}
                            @error('tipo')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Campo precio base --}}
                        <div class="mb-4">
                            <label class="block text-gray-600 font-semibold mb-1">Precio base</label>
                            <input type="number" step="0.01" name="precio_base" value="{{ old('precio_base') }}"
                                class="w-full border border-gray-300 rounded px-4 py-2">
                            @error('precio_base')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Botones --}}
                        <div class="flex gap-4 mt-6">
                            <button type="submit"
                                class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                                Guardar
                            </button>
                            <a href="{{ route('admin.productos.index') }}"
                                class="text-gray-600 hover:underline py-2">
                                Cancelar
                            </a>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
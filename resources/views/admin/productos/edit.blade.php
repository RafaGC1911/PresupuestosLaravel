<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar producto
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    {{-- enctype="multipart/form-data" obligatorio para subir archivos --}}
                    <form action="{{ route('admin.productos.update', $producto) }}" method="POST"
                        enctype="multipart/form-data">

                        @csrf
                        {{-- Indicamos que es una petición PUT porque HTML solo soporta GET y POST --}}
                        @method('PUT')

                        {{-- Campo tipo --}}
                        <div class="mb-4">
                            <label class="block text-gray-600 font-semibold mb-1">Tipo</label>
                            {{-- old('tipo', $producto->tipo) usa el valor anterior si hubo error, --}}
                            {{-- o el valor actual del producto si no hubo error --}}
                            <input type="text" name="tipo" value="{{ old('tipo', $producto->tipo) }}"
                                class="w-full border border-gray-300 rounded px-4 py-2">
                            @error('tipo')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Campo precio base --}}
                        <div class="mb-4">
                            <label class="block text-gray-600 font-semibold mb-1">Precio base</label>
                            <input type="number" step="0.01" name="precio_base"
                                value="{{ old('precio_base', $producto->precio_base) }}"
                                class="w-full border border-gray-300 rounded px-4 py-2">
                            @error('precio_base')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Campo imagen --}}
                        <div class="mb-4">
                            <label class="block text-gray-600 font-semibold mb-1">Imagen</label>

                            {{-- Si el producto ya tiene imagen la mostramos como previsualización --}}
                            @if($producto->imagen)
                                <div class="mb-2">
                                    <p class="text-gray-500 text-sm mb-1">Imagen actual:</p>
                                    {{-- asset('storage/...') genera la URL correcta a la imagen --}}
                                    {{-- que está guardada en storage/app/public/ --}}
                                    <img src="{{ asset('storage/' . $producto->imagen) }}"
                                        alt="Imagen del producto"
                                        class="h-32 w-auto rounded border border-gray-200">
                                </div>
                            @endif

                            {{-- Input para subir una nueva imagen --}}
                            {{-- Si se deja vacío se mantiene la imagen actual --}}
                            <input type="file" name="imagen" accept="image/*"
                                class="w-full border border-gray-300 rounded px-4 py-2">
                            <p class="text-gray-400 text-sm mt-1">
                                Dejar vacío para mantener la imagen actual.
                            </p>
                            @error('imagen')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Botones --}}
                        <div class="flex gap-4 mt-6">
                            <button type="submit"
                                class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                                Guardar cambios
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
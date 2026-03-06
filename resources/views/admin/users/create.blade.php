<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Crear usuario
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf

                        {{-- Nombre --}}
                        <div class="mb-4">
                            <label class="block text-gray-600 font-semibold mb-1">Nombre</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="w-full border border-gray-300 rounded px-4 py-2">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-4">
                            <label class="block text-gray-600 font-semibold mb-1">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="w-full border border-gray-300 rounded px-4 py-2">
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Contraseña --}}
                        <div class="mb-4">
                            <label class="block text-gray-600 font-semibold mb-1">Contraseña</label>
                            <input type="password" name="password"
                                class="w-full border border-gray-300 rounded px-4 py-2">
                            @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Confirmar contraseña --}}
                        {{-- Este campo tiene que llamarse password_confirmation obligatoriamente --}}
                        {{-- Es lo que espera la regla 'confirmed' de la validación --}}
                        <div class="mb-4">
                            <label class="block text-gray-600 font-semibold mb-1">Confirmar contraseña</label>
                            <input type="password" name="password_confirmation"
                                class="w-full border border-gray-300 rounded px-4 py-2">
                        </div>

                        {{-- Rol --}}
                        {{-- Un select para elegir entre admin y comercial --}}
                        <div class="mb-4">
                            <label class="block text-gray-600 font-semibold mb-1">Rol</label>
                            <select name="rol" class="w-full border border-gray-300 rounded px-4 py-2">
                                {{-- selected si el valor anterior era ese, para no perderlo si hay error --}}
                                <option value="admin" {{ old('rol') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="comercial" {{ old('rol') == 'comercial' ? 'selected' : '' }}>Comercial</option>
                            </select>
                            @error('rol')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Botones --}}
                        <div class="flex gap-4 mt-6">
                            <button type="submit"
                                class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                                Guardar
                            </button>
                            <a href="{{ route('admin.users.index') }}"
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
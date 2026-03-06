<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalle del usuario
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-4">

                    <div>
                        <span class="font-semibold text-gray-600">ID:</span>
                        <span>{{ $user->id }}</span>
                    </div>

                    <div>
                        <span class="font-semibold text-gray-600">Nombre:</span>
                        <span>{{ $user->name }}</span>
                    </div>

                    <div>
                        <span class="font-semibold text-gray-600">Email:</span>
                        <span>{{ $user->email }}</span>
                    </div>

                    <div>
                        <span class="font-semibold text-gray-600">Rol:</span>
                        <span>{{ $user->rol }}</span>
                    </div>

                    <div class="pt-4">
                        <a href="{{ route('admin.users.index') }}"
                            class="text-blue-600 hover:underline">
                            ← Volver al listado
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
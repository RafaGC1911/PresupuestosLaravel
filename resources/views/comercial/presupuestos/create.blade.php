<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      Crear presupuesto
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
          @if ($errors->any())
          <div class="bg-red-200 p-4 mb-4">
            <ul>
              @foreach ($errors->all() as $error)
              <li class="text-red-700">{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif
          <form action="{{ route('comercial.presupuestos.store') }}" method="POST">
            @csrf

            {{-- Cliente --}}
            <div class="mb-4">
              <label class="block text-gray-600 font-semibold mb-1">Cliente</label>
              <select name="cliente_id" class="w-full border border-gray-300 rounded px-4 py-2">
                @foreach($clientes as $cliente)
                <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                  {{ $cliente->nombre }}
                </option>
                @endforeach
              </select>
            </div>

            {{-- Fecha --}}
            <div class="mb-4">
              <label class="block text-gray-600 font-semibold mb-1">Fecha</label>
              <input type="date" name="fecha" value="{{ old('fecha') }}"
                class="w-full border border-gray-300 rounded px-4 py-2">
            </div>

            {{-- Estado --}}
            <div class="mb-4">
              <label class="block text-gray-600 font-semibold mb-1">Estado</label>
              <select name="estado" class="w-full border border-gray-300 rounded px-4 py-2">
                <option value="pendiente">Pendiente</option>
                <option value="aceptado">Aceptado</option>
                <option value="rechazado">Rechazado</option>
              </select>
            </div>

            {{-- Líneas --}}
            <div class="mb-4">
              <h3 class="font-semibold text-gray-700 text-lg mb-3">Líneas del presupuesto</h3>

              <div id="lineas-container">
                <div class="linea flex gap-4 mb-3 items-center">
                  <select name="lineas[0][producto_id]"
                    class="w-1/2 border border-gray-300 rounded px-4 py-2">
                    @foreach($productos as $producto)
                    <option value="{{ $producto->id }}">
                      {{ $producto->tipo }} — {{ number_format($producto->precio_base, 2) }} €
                    </option>
                    @endforeach
                  </select>

                  <input type="number" name="lineas[0][cantidad]"
                    min="1" value="1"
                    class="w-1/4 border border-gray-300 rounded px-4 py-2">

                  <button type="button" onclick="quitarLinea(this)"
                    class="text-red-600 hover:underline">
                    Quitar
                  </button>
                </div>
              </div>

              <button type="button" onclick="agregarLinea()"
                class="mt-2 text-blue-600 hover:underline">
                + Añadir línea
              </button>
            </div>

            {{-- Botones --}}
            <div class="flex gap-4 mt-6">
              <button type="submit"
                class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                Guardar
              </button>

              <a href="{{ route('comercial.presupuestos.index') }}"
                class="text-gray-600 hover:underline py-2">
                Cancelar
              </a>
            </div>

          </form>

        </div>
      </div>
    </div>
  </div>

  {{-- Datos productos --}}
  <div id="datos-productos"
    data-productos='@json($productos)'
    style="display:none"></div>

  <script>
    const productosDiv = document.getElementById('datos-productos');
    const productos = JSON.parse(productosDiv.dataset.productos);

    let contadorLineas = 1;

    window.agregarLinea = function() {

      const contenedor = document.getElementById('lineas-container');

      let opciones = productos.map(p =>
        `<option value="${p.id}">
                    ${p.tipo} — ${parseFloat(p.precio_base).toFixed(2)} €
                </option>`
      ).join('');

      const nuevaLinea = document.createElement('div');
      nuevaLinea.classList.add('linea', 'flex', 'gap-4', 'mb-3', 'items-center');

      nuevaLinea.innerHTML = `
                <select name="lineas[${contadorLineas}][producto_id]"
                    class="w-1/2 border border-gray-300 rounded px-4 py-2">
                    ${opciones}
                </select>

                <input type="number" name="lineas[${contadorLineas}][cantidad]"
                    min="1" value="1"
                    class="w-1/4 border border-gray-300 rounded px-4 py-2">

                <button type="button" onclick="quitarLinea(this)"
                    class="text-red-600 hover:underline">
                    Quitar
                </button>
            `;

      contenedor.appendChild(nuevaLinea);
      contadorLineas++;
    }

    window.quitarLinea = function(boton) {

      const linea = boton.parentElement;
      const lineas = document.querySelectorAll('.linea');

      if (lineas.length === 1) {
        alert('El presupuesto debe tener al menos una línea');
        return;
      }

      linea.remove();
    }
  </script>

</x-app-layout>
<x-app-layout>
  {{-- Cabecera de la página --}}
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      Editar presupuesto
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white shadow-sm sm:rounded-lg p-6">

        {{-- Formulario que enviará los datos al método update --}}
        <form action="{{ route('comercial.presupuestos.update', $presupuesto) }}" method="POST">

          {{-- Token de seguridad obligatorio en Laravel --}}
          @csrf

          {{-- Indicamos que el método real es PUT (porque HTML solo soporta GET y POST) --}}
          @method('PUT')

          {{-- ===================== CLIENTE ===================== --}}
          <div class="mb-4">
            <label class="block font-semibold mb-1">Cliente</label>

            {{-- Select con todos los clientes --}}
            <select name="cliente_id" class="w-full border rounded px-4 py-2">

              @foreach($clientes as $cliente)
              <option value="{{ $cliente->id }}"

                {{-- Marcamos como seleccionado el cliente actual del presupuesto --}}
                {{ $presupuesto->cliente_id == $cliente->id ? 'selected' : '' }}>

                {{ $cliente->nombre }}
              </option>
              @endforeach

            </select>
          </div>

          {{-- ===================== FECHA ===================== --}}
          <div class="mb-4">
            <label class="block font-semibold mb-1">Fecha</label>

            {{-- Mostramos la fecha ya guardada en formato correcto --}}
            <input type="date" name="fecha"
              value="{{ $presupuesto->fecha->format('Y-m-d') }}"
              class="w-full border rounded px-4 py-2">
          </div>

          {{-- ===================== ESTADO ===================== --}}
          <div class="mb-4">
            <label class="block font-semibold mb-1">Estado</label>

            <select name="estado" class="w-full border rounded px-4 py-2">

              {{-- Recorremos posibles estados --}}
              @foreach(['pendiente','aceptado','rechazado'] as $estado)

              <option value="{{ $estado }}"

                {{-- Seleccionamos el estado actual --}}
                {{ $presupuesto->estado == $estado ? 'selected' : '' }}>

                {{ ucfirst($estado) }} {{-- Primera letra en mayúscula --}}
              </option>

              @endforeach

            </select>
          </div>

          {{-- ===================== LÍNEAS DE PRESUPUESTO ===================== --}}
          <div class="mb-4">
            <h3 class="font-semibold text-lg mb-3">Líneas</h3>

            {{-- Contenedor donde estarán todas las líneas --}}
            <div id="lineas-container">

              {{-- Recorremos las líneas que ya tiene el presupuesto --}}
              @foreach($presupuesto->lineasPresupuestos as $index => $linea)

              <div class="linea flex gap-4 mb-3 items-center">

                {{-- SELECT DE PRODUCTO --}}
                <select name="lineas[{{ $index }}][producto_id]"
                  class="w-1/2 border rounded px-4 py-2">

                  @foreach($productos as $producto)

                  <option value="{{ $producto->id }}"

                    {{-- Seleccionamos el producto actual de la línea --}}
                    {{ $linea->producto_id == $producto->id ? 'selected' : '' }}>

                    {{ $producto->tipo }} — {{ number_format($producto->precio_base,2) }} €
                  </option>

                  @endforeach

                </select>

                {{-- CANTIDAD --}}
                <input type="number"
                  name="lineas[{{ $index }}][cantidad]"
                  value="{{ $linea->cantidad }}"
                  min="1"
                  class="w-1/4 border rounded px-4 py-2">

                {{-- BOTÓN PARA ELIMINAR LÍNEA --}}
                <button type="button" onclick="quitarLinea(this)"
                  class="text-red-600">
                  Quitar
                </button>

              </div>

              @endforeach

            </div>

            {{-- BOTÓN PARA AÑADIR NUEVAS LÍNEAS --}}
            <button type="button" onclick="agregarLinea()"
              class="text-blue-600 mt-2">
              + Añadir línea
            </button>
          </div>

          {{-- ===================== BOTONES FINALES ===================== --}}
          <div class="flex gap-4 mt-6">

            {{-- Enviar formulario --}}
            <button type="submit"
              class="bg-blue-600 text-white px-6 py-2 rounded">
              Actualizar
            </button>

            {{-- Cancelar --}}
            <a href="{{ route('comercial.presupuestos.index') }}"
              class="text-gray-600">
              Cancelar
            </a>
          </div>

        </form>

      </div>
    </div>
  </div>

  {{-- ===================== PASAR DATOS A JAVASCRIPT ===================== --}}
  {{-- Guardamos los productos en formato JSON en un atributo HTML --}}
  <div id="datos-productos"
    data-productos='@json($productos)'
    style="display:none"></div>
  <div id="datos-extra"
    data-contador="{{ $presupuesto->lineasPresupuestos->count() }}"
    style="display:none"></div>
  <script>
    // Leemos los productos desde el atributo data
    const productos = JSON.parse(
      document.getElementById('datos-productos').dataset.productos
    );

    // Contador de líneas (empieza con las que ya existen)
    const contadorDiv = document.getElementById('datos-extra');
    let contadorLineas = parseInt(contadorDiv.dataset.contador);

    // ===================== FUNCIÓN AÑADIR LÍNEA =====================
    window.agregarLinea = function() {

      // Generamos opciones del select dinámicamente
      let opciones = productos.map(p =>
        `<option value="${p.id}">
                    ${p.tipo} — ${parseFloat(p.precio_base).toFixed(2)} €
                </option>`
      ).join('');

      // Creamos un div nuevo
      const nuevaLinea = document.createElement('div');
      nuevaLinea.classList.add('linea', 'flex', 'gap-4', 'mb-3', 'items-center');

      // HTML de la nueva línea
      nuevaLinea.innerHTML = `
                <select name="lineas[${contadorLineas}][producto_id]"
                    class="w-1/2 border rounded px-4 py-2">
                    ${opciones}
                </select>

                <input type="number"
                    name="lineas[${contadorLineas}][cantidad]"
                    value="1" min="1"
                    class="w-1/4 border rounded px-4 py-2">

                <button type="button" onclick="quitarLinea(this)"
                    class="text-red-600">
                    Quitar
                </button>
            `;

      // Añadimos al contenedor
      document.getElementById('lineas-container').appendChild(nuevaLinea);

      // Incrementamos contador
      contadorLineas++;
    }

    // ===================== FUNCIÓN ELIMINAR LÍNEA =====================
    window.quitarLinea = function(btn) {

      // Todas las líneas actuales
      const lineas = document.querySelectorAll('.linea');

      // Evitamos que se quede sin líneas
      if (lineas.length === 1) {
        alert('Debe haber al menos una línea');
        return;
      }

      // Eliminamos la línea correspondiente
      btn.parentElement.remove();
    }
  </script>

</x-app-layout>
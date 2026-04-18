<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Presupuesto</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            color: #111827;
        }

        /* CABECERA */
        .header {
            background-color: #1E3A8A;
            color: white;
            padding: 15px;
        }

        .header h1 {
            margin: 0;
        }

        /* DATOS */
        .info {
            margin-top: 20px;
        }

        .info p {
            margin: 5px 0;
        }

        /* TABLA */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th {
            background-color: #1E3A8A;
            color: white;
            padding: 10px;
            text-align: left;
        }

        td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #F3F4F6;
        }

        /* TOTAL */
        .total {
            margin-top: 20px;
            text-align: right;
            font-size: 18px;
            font-weight: bold;
        }

        /* ESTADO */
        .estado {
            margin-top: 10px;
            padding: 5px 10px;
            display: inline-block;
            border-radius: 5px;
        }

        .pendiente {
            background-color: #FEF3C7;
            color: #92400E;
        }

        .aceptado {
            background-color: #D1FAE5;
            color: #065F46;
        }

        .rechazado {
            background-color: #FEE2E2;
            color: #991B1B;
        }

    </style>
</head>
<body>

    {{-- CABECERA --}}
    <div class="header">
        <h1>Presupuesto #{{ $presupuesto->id }}</h1>
    </div>

    {{-- INFO --}}
    <div class="info">
        <p><strong>Cliente:</strong> {{ $presupuesto->cliente->nombre }}</p>
        <p><strong>Fecha:</strong> {{ $presupuesto->fecha->format('d/m/Y') }}</p>

        {{-- Estado con color dinámico --}}
        <span class="estado {{ $presupuesto->estado }}">
            {{ ucfirst($presupuesto->estado) }}
        </span>
    </div>

    {{-- TABLA --}}
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($presupuesto->lineasPresupuestos as $linea)
                <tr>
                    <td>{{ $linea->producto->tipo }}</td>
                    <td>{{ $linea->cantidad }}</td>
                    <td>{{ number_format($linea->precio, 2) }} €</td>
                    <td>{{ number_format($linea->precio * $linea->cantidad, 2) }} €</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- TOTAL --}}
    <p class="total">
        Total: {{ number_format($presupuesto->total, 2) }} €
    </p>

</body>
</html>
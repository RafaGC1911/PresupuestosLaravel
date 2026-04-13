<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Presupuesto</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h1 { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        .total { text-align: right; margin-top: 20px; font-size: 18px; }
    </style>
</head>
<body>

    <h1>Presupuesto #{{ $presupuesto->id }}</h1>

    <p><strong>Cliente:</strong> {{ $presupuesto->cliente->nombre }}</p>
    <p><strong>Fecha:</strong> {{ $presupuesto->fecha->format('d/m/Y') }}</p>

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

    <p class="total">
        <strong>Total: {{ number_format($presupuesto->total, 2) }} €</strong>
    </p>

</body>
</html>
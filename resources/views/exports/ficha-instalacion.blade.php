<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ficha de Instalación</title>
</head>
<body>
<h1>Ficha de Instalación</h1>
<p><strong>Contrato ID:</strong> {{ $contract->id }}</p>
<p><strong>Cliente:</strong> {{ $contract->paciente->nombre }}</p>
<p><strong>Fecha de Instalación:</strong> {{ $contract->fecha_instalacion }}</p>

<!-- Aquí puedes agregar más campos según sea necesario -->
<table>
    <thead>
    <tr>
        <th>Equipo</th>
        <th>Código</th>
        <th>Estado</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>Máquina</td>
        <td>{{ $contract->maquina?->codigo }}</td>
        <td>{{ $contract->maquina?->estado ?? 'N/A' }}</td>
    </tr>
    <tr>
        <td>Tanque</td>
        <td>{{ $contract->tanque?->codigo }}</td>
        <td>{{ $contract->tanque?->estado ?? 'N/A' }}</td>
    </tr>
    <tr>
        <td>Regulador</td>
        <td>{{ $contract->regulador?->codigo }}</td>
        <td>{{ $contract->regulador?->estado ?? 'N/A' }}</td>
    </tr>
    <tr>
        <td>Carrito</td>
        <td>{{ $contract->carrito?->codigo }}</td>
        <td>{{ $contract->carrito?->estado ?? 'N/A' }}</td>
    </tr>
    </tbody>
</table>
</body>
</html>

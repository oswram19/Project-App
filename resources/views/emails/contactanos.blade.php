<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Correo Electrónico de Contacto</h1>
    <p><strong>Nombre:</strong> {{ $data['nombre'] }}</p>
    <p><strong>Correo:</strong> {{ $data['correo'] }}</p>
    <p><strong>Mensaje:</strong></p>
    <p>{{ $data['mensaje'] }}</p>
    @if($archivoPath)
    <hr>
    <p><strong>📎 Archivo adjunto:</strong> Se ha incluido un archivo con este correo.</p>
    @endif
</body>
</html>
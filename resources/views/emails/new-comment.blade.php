<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo comentario</title>
</head>
<body>
    <h1>Nuevo comentario en tu publicación</h1>

    <p>Hola, {{ $comment->post->user->name }}.</p>

    <p>Alguien ha comentado en tu publicación.</p>

    <p><strong>Comentario:</strong></p>
    <p>{{ $comment->content }}</p>

    <p>¡Gracias por formar parte de nuestra comunidad!</p>
</body>
</html>

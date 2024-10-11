
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Usuario</title>
    <link rel="stylesheet" href="./public/styles.css">

</head>
<body>
    <h2>Registrar Usuario</h2>
    <form action="/registrar_usuario" method="post">

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="correo">Correo Electrónico:</label>
        <input type="email" id="correo" name="correo" required>

        <label for="contraseña">Contraseña:</label>
        <input type="password" id="contraseña" name="contraseña" required>

        <label for="rol">Rol:</label>
        <select id="rol" name="rol">
            <option value="admin">Administrador</option>
            <option value="medico">Médico</option>
            <option value="enfermero">Enfermero</option>
            <option value="recepcionista">Recepcionista</option>
        </select>
        <button type="submit">Registrar</button>
    </form>
</body>
</html>

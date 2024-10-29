
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignar Permisos a Roles</title>
    <link rel="stylesheet" href="./public/styles.css">

</head>
<body>
    <h2>Asignar Permisos a Roles</h2>
    <form action="/asignar_permisos" method="post">
        <label for="rol_asignar">Rol:</label>
        <select id="rol_asignar" name="rol_asignar">
            <option value="admin">Administrador</option>
            <option value="medico">Médico</option>
            <option value="enfermero">Enfermero</option>
            <option value="recepcionista">Recepcionista</option>
        </select><br><br>
        <label for="permiso_asignar">Permiso:</label>
        <select id="permiso_asignar" name="permiso_asignar">
            <option value="crear_usuario">Crear Usuario</option>
            <option value="editar_usuario">Editar Usuario</option>
            <option value="borrar_usuario">Borrar Usuario</option>
            <option value="ver_historial">Ver Historial Médico</option>
        </select><br><br>
        <button type="submit">Asignar Permiso</button>
    </form>
</body>
</html>

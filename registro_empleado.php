
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Empleado</title>
</head>
<body>
    <h2>Registrar Empleado</h2>
    <form action="/registrar_empleado" method="post">
        <label for="nombre_empleado">Nombre del Empleado:</label>
        <input type="text" id="nombre_empleado" name="nombre_empleado" required><br><br>
        <label for="puesto_empleado">Puesto:</label>
        <input type="text" id="puesto_empleado" name="puesto_empleado" required><br><br>
        <label for="salario_empleado">Salario:</label>
        <input type="number" id="salario_empleado" name="salario_empleado" required><br><br>
        <button type="submit">Registrar Empleado</button>
    </form>
</body>
</html>

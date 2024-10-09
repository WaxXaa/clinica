
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensaje</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
            background-color: #f0f0f0;
            margin: 0;
        }
        .contenedor {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .exito {
            color: #4CAF50;
            border: 1px solid #4CAF50;
            background-color: #dff0d8;
            padding: 20px;
            border-radius: 5px;
        }
        .error {
            color: #F44336;
            border: 1px solid #F44336;
            background-color: #fdd;
            padding: 20px;
            border-radius: 5px;
        }
        .mensaje {
            margin-bottom: 20px;
        }
        .cuenta_regresiva {
            font-size: 1.2em;
            font-weight: bold;
        }
        .enlace_redireccion {
            margin-top: 20px;
            display: inline-block;
            font-size: 1em;
            color: #007BFF;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="contenedor">
        <div class="<?php echo isset($_SESSION['message_type']) ? $_SESSION['message_type'] : 'info'; ?>">
            <div class="mensaje">
                <?php
                echo isset($_SESSION['message']) ? $_SESSION['message'] : 'Ocurrió un problema inesperado.';
                ?>
            </div>
            <p>Serás redirigido en <span id="cuenta_regresiva" class="cuenta_regresiva">5</span> segundos.</p>
            <a href="../registrar_automovil.php" class="enlace_redireccion">Volver al formulario de registro</a>
        </div>
    </div>
    <script>

        setTimeout(() => {
            window.location.href = '../admin.php';
        }, 5000);
    </script>
    <?php
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
    ?>
</body>
</html>


<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        margin: 0;
        padding: 0;
        color: #333;
    }
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }
    header {
        background: #007bff;
        color: #fff;
        padding: 10px 0;
        text-align: center;
        margin-bottom: 20px;
    }
    header h1 {
        margin: 0;
        font-size: 24px;
    }
    .login-form {
        background: #ffffff;
        padding: 20px;
        max-width: 400px;
        margin: 50px auto;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }
    .login-form h2 {
        margin-bottom: 20px;
        color: #007bff;
    }
    .login-form input[type="text"],
    .login-form input[type="password"],
    .login-form input[type="email"] {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border-radius: 4px;
        border: 1px solid #ccc;
    }
    .login-form button {
        background: #007bff;
        color: #fff;
        padding: 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        width: 100%;
    }
    .login-form button:hover {
        background: #0056b3;
    }
    form {
        background: #fff;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    form input[type="text"],
    form input[type="number"],
    form input[type="email"],
    form input[type="password"],
    form select,
    form textarea {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    form button {
        background: #28a745;
        color: #fff;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    form button:hover {
        background: #218838;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }
    table th, table td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: left;
    }
    table th {
        background-color: #007bff;
        color: white;
    }
    table tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    .message {
        background-color: #d4edda;
        color: #155724;
        padding: 10px;
        border: 1px solid #c3e6cb;
        border-radius: 4px;
        margin-bottom: 20px;
    }
</style>

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
            window.location.href = '../../../index.php';
        }, 5000);
    </script>
    <?php
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
    ?>
</body>
</html>

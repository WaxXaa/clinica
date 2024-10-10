<?php
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/cArr.css">
</head>
<body>
   <form action="../core/App.php" method="post">

   <h1>Sistema de login</h1>
   <input type="hiden" name="login" value="login">
    <label for="correo">Correo:</label>
   <input id="correo" type="text" placeholder="ingrese su correo" name="correo" require maxlength="100">

   <label for="contra">Contraseña:</label>
   <input id="contra" type="password" placeholder="ingrese su contraseña" name="contra" require maxlength="50" minlength="8">
   
   <input type="submit" value="Ingresar">
   
   </form> 
   
</body>
</html>
?php>
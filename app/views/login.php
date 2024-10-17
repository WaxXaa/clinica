<?php
session_start();
require '../../config/db.php'; 

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = isset($_POST['correo']) ? trim($_POST['correo']) : '';
    $contra = isset($_POST['contra']) ? trim($_POST['contra']) : '';

    if (!empty($correo) && !empty($contra)) {
        $stmt = Database::connect()->prepare("SELECT * FROM usuarios WHERE correo_electronico = ? AND contra = ?");
        $stmt->bind_param("ss", $correo, $contra);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $_SESSION['logged_in'] = true;
            $_SESSION['role'] = $user['rol'];
            header('Location: ../../app/views/index.php'); 
            exit();
        } else {
            $error = "Usuario o contraseña incorrectos.";
        }
    } else {
        $error = "Por favor, complete todos los campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-1/3">
        <h2 class="text-xl font-semibold mb-4">Login</h2>
        <?php if (isset($error)) : ?>
            <p class="text-red-500"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="" method="post" class="space-y-4">
            <input type="email" name="correo" placeholder="Correo" required class="w-full p-2 border rounded-md">
            <input type="password" name="contra" placeholder="Contraseña" required class="w-full p-2 border rounded-md">
            <button type="submit" class="bg-blue-500 text-white w-full py-2 rounded-md hover:bg-blue-600">Login</button>
        </form>
    </div>
</body>
</html>

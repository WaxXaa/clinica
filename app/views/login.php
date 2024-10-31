<?php
session_start();
include_once '../core/Database.php';

$error = '';

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $correo = isset($_POST['correo']) ? trim($_POST['correo']) : '';
//     $contra = isset($_POST['contra']) ? trim($_POST['contra']) : '';

//     if (!empty($correo) && !empty($contra)) {
//         $stmt = Database::connect()->prepare("SELECT * FROM usuarios WHERE correo_electronico = ? AND contra = ?");
//         $stmt->bind_param("ss", $correo, $contra);
//         $stmt->execute();
//         $result = $stmt->get_result();

//         if ($result->num_rows > 0) {
//             $user = $result->fetch_assoc();
//             $_SESSION['logged_in'] = true;
//             $_SESSION['role'] = $user['rol'];
//             header('Location /../../index.php'); 
//             exit();
//         } else {
//             $error = "Usuario o contraseña incorrectos.";
//         }
//     } else {
//         $error = "Por favor, complete todos los campos.";
//     }
// }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Iniciar Sesión</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            overflow: hidden;
            background-color: #12130F;
        }
        .gradient-border {
            background: linear-gradient(45deg, #c94b4b, #4b134f, #c94b4b);
            padding: 10px;
            border-radius: 30px;
            background-size: 200% 200%;
            animation: gradientAnimation 5s ease infinite;
        }
        @keyframes gradientAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .container {
            background-color: #1c1c1e;
            border-radius: 30px;
            overflow: hidden;
        }
        .neumorphism {
            border-radius: 30px 0 0 30px;
            box-shadow: 10px 10px 20px #0e0e0f, -10px -10px 20px #26272a;
        }
        .input-field-container {
            position: relative;
            margin-bottom: 1rem;
            padding: 2px;
            border-radius: 15px;
            transition: transform 0.3s ease;
            background: transparent;
        }
        .input-field-container:focus-within {
            background: linear-gradient(45deg, #c94b4b, #4b134f, #c94b4b);
            background-size: 200% 200%;
            animation: gradientAnimation 5s ease infinite;
            transform: scale(1.05);
        }
        .input-field {
            width: 100%;
            padding: 12px;
            background-color: #1c1c1e;
            color: white;
            border: none;
            outline: none;
            border-radius: 15px;
        }
        .carousel-button {
            width: 30px;
            height: 4px;
            background-color: gray;
            border-radius: 2px;
            transition: all 0.3s ease;
        }
        .carousel-button.active {
            width: 35px;
            background-color: white;
        }
        .login-button {
            width: 50%;
            margin: 0 auto;
            display: block;
        }
        .carousel-logo-container {
            position: absolute;
            top: 30px;
            left: 30px;
        }
        #logoImage {
            width: 60px;
            height: 60px;
            object-fit: contain;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">
    <!-- Contenedor Principal con borde degradado animado -->
    <div class="gradient-border">
        <div class="container flex w-[90vw] h-[90vh] mx-auto">
            
            <!-- Sección Izquierda: Imagen y Mensaje -->
            <div class="w-1/2 relative h-full flex items-center justify-center p-6 neumorphism">
                <img id="carouselImage" alt="A scenic view" class="w-full h-full object-cover neumorphism" src="https://picsum.photos/800/600?random=1"/>
                <div class="carousel-logo-container">
                    <img id="logoImage" src="https://images.pexels.com/photos/3831181/pexels-photo-3831181.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Logo AMC"/>
                </div>
                <div class="absolute bottom-20 left-1/2 transform -translate-x-1/2 text-white text-center">
                    <p class="text-lg font-semibold">Capturing Moments,</p>
                    <p class="text-lg font-semibold">Creating Memories</p>
                    <div class="flex justify-center mt-8 space-x-2">
                        <span class="carousel-button active"></span>
                        <span class="carousel-button"></span>
                        <span class="carousel-button"></span>
                    </div>
                </div>
            </div>

            <!-- Sección Derecha: Formulario de Inicio de Sesión -->
            <div class="w-1/2 p-12 bg-gray-800 rounded-r-lg flex flex-col justify-center">
                <h2 class="text-3xl font-semibold text-white mb-8 text-center">Iniciar Sesión</h2>
                
                <!-- Formulario de Inicio de Sesión con Usuario y Contraseña -->
                <form method="POST" action="../core/App.php" id="loginForm" class="w-2/3 mx-auto">
                    <input type="hidden" name="login" value="login">
                    <div class="input-field-container">
                        <input name="user" id="usuario" class="input-field" placeholder="Usuario" type="text" required/>
                    </div>
                    <div class="relative input-field-container">
                        <input name="contra" id="password" class="input-field" placeholder="Contraseña" type="password" required/>
                        <i id="togglePassword" class="fas fa-eye text-gray-400 cursor-pointer absolute right-3 top-1/2 transform -translate-y-1/2" onclick="togglePasswordVisibility()"></i>
                    </div>

                    <button class="login-button bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded-lg" type="submit">Iniciar Sesión</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        let images = [
            "https://picsum.photos/800/600?random=1",
            "https://picsum.photos/800/600?random=2",
            "https://picsum.photos/800/600?random=3"
        ];
        let carouselImage = document.getElementById("carouselImage");
        let carouselButtons = document.querySelectorAll(".carousel-button");
        let currentImageIndex = 0;

        function changeImage() {
            carouselImage.src = images[currentImageIndex];
            carouselButtons.forEach((button, index) => {
                button.classList.toggle("active", index === currentImageIndex);
            });
            currentImageIndex = (currentImageIndex + 1) % images.length;
        }

        setInterval(changeImage, 5000);

        function togglePasswordVisibility() {
            const passwordInput = document.getElementById("password");
            const toggleButton = document.getElementById("togglePassword");
            const isPassword = passwordInput.type === "password";
            passwordInput.type = isPassword ? "text" : "password";
            toggleButton.classList.toggle("fa-eye-slash", isPassword);
            toggleButton.classList.toggle("fa-eye", !isPassword);
        }

        // Navegación entre campos con Enter y envío en el último campo
        document.getElementById("usuario").addEventListener("keydown", function(event) {
            if (event.key === "Enter") {
                event.preventDefault();
                document.getElementById("password").focus();
            }
        });

        document.getElementById("password").addEventListener("keydown", function(event) {
            if (event.key === "Enter") {
                event.preventDefault();
                document.getElementById("loginForm").submit();
            }
        });
    </script>
</body>
</html>

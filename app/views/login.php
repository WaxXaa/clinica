<?php
session_start();

$error = '';

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
            background-color: #F8FFFE;
        }
        .gradient-border {
            background: linear-gradient(45deg, #00aa99, #f3eada, #d9ede2);
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
            background-color: ;
            border-radius: 30px;
            overflow: hidden;
        }
        .neumorphism {
            border-radius: 30px 0 0 30px;
            /* box-shadow: 5px 5px 10px #0e0e0f; */
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
            background: linear-gradient(45deg, #00769b, #009e94, #7cdca0);
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
        /* .carousel-logo-container {
            position: absolute;
            top: 30px;
            left: 30px;
        } */
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
            <div class="w-1/2 h-full flex items-center justify-center  neumorphism">
                <img id="carouselImage" alt="A scenic view" class="w-full h-full object-cover neumorphism" src="https://picsum.photos/800/600?random=1"/>
            </div>

            <!-- Sección Derecha: Formulario de Inicio de Sesión -->
            <div class="w-1/2  bg-[#EAFCF3] rounded-r-lg flex flex-col justify-center">
                <h2 class="text-3xl font-semibold text-[#1c1c1e] mb-8 text-center">Iniciar Sesión</h2>

                <!-- Formulario de Inicio de Sesión con Usuario y Contraseña -->
                <form method="POST" action="../api/src/Core/App.php" id="loginForm" class="w-2/3 mx-auto">
                    <input type="hidden" name="login" value="login">
                    <div class="input-field-container">
                        <input name="user" id="usuario" class="input-field" placeholder="Usuario" type="text" required/>
                    </div>
                    <div class="relative input-field-container">
                        <input name="contra" id="password" class="input-field" placeholder="Contraseña" type="password" required/>
                        <i id="togglePassword" class="fas fa-eye text-gray-400 cursor-pointer absolute right-3 top-1/2 transform -translate-y-1/2" onclick="togglePasswordVisibility()"></i>
                    </div>

                    <button class="login-button bg-[#1c1c1e] hover:bg-[#00aa9d] text-white font-bold py-2 px-4 rounded-lg" type="submit">Iniciar Sesión</button>
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

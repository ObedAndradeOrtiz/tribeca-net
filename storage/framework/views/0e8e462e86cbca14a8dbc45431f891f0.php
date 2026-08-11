<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>TRIBECA SOHO | Login</title>
    <link href="<?php echo e(asset('logos/LOGOSINFONDO.png')); ?>" rel="icon">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Playfair+Display:wght@600&display=swap"
        rel="stylesheet">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?php echo e(asset('auth/vendor/bootstrap/css/bootstrap.min.css')); ?>">

    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            background: url('<?php echo e(asset('edificio.jpeg')); ?>') no-repeat center center/cover;
        }

        /* Overlay oscuro */
        .overlay {
            position: absolute;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.55);
        }

        .login-container {
            position: relative;
            z-index: 2;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Caja glass */
        .login-box {
            width: 380px;
            padding: 40px;
            border-radius: 15px;
            backdrop-filter: blur(12px);
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4);
            color: #fff;
            animation: fadeIn 1s ease;
        }

        /* Título */
        .title {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            text-align: center;
            margin-bottom: 5px;
            letter-spacing: 2px;
        }

        .subtitle {
            text-align: center;
            font-size: 13px;
            color: #ddd;
            margin-bottom: 25px;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.15);
            border: none;
            color: #fff;
            margin-bottom: 15px;
        }

        .form-control::placeholder {
            color: #ccc;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.2);
            box-shadow: none;
            color: #fff;
        }

        .btn-login {
            width: 100%;
            background: linear-gradient(45deg, #4facfe, #00f2fe);
            border: none;
            padding: 10px;
            border-radius: 8px;
            color: #fff;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-login:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media(max-width: 500px) {
            .login-box {
                width: 90%;
                padding: 30px;
            }
        }
    </style>
</head>

<body>

    <div class="overlay"></div>

    <div class="login-container">
        <div class="login-box">

            <div class="title">TRIBECA SOHO</div>
            <div class="subtitle">Acceso al sistema</div>

            <form method="POST" action="<?php echo e(route('login')); ?>">
                <?php echo csrf_field(); ?>

                <input id="email" type="email" name="email" class="form-control"
                    placeholder="Correo electrónico" required>

                <input type="password" name="password" class="form-control" placeholder="Contraseña" required>

                <button type="submit" class="btn-login">
                    Ingresar
                </button>
            </form>

        </div>
    </div>

</body>

</html>
<?php /**PATH D:\1.DIGIPROJECTS\9.TRIBECA\1.CODE\public_html\resources\views/auth/login.blade.php ENDPATH**/ ?>
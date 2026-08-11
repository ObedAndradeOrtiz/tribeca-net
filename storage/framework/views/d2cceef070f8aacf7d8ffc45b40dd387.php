<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>TRIBECA SOHO | Login</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Playfair+Display:wght@600&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?php echo e(asset('auth/vendor/bootstrap/css/bootstrap.min.css')); ?>">

    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            overflow: hidden;
        }

        .container-login {
            display: flex;
            height: 100vh;
        }

        /* LEFT SIDE */
        .left-side {
            width: 60%;
            background: url('<?php echo e(asset('edificio.jpeg')); ?>') no-repeat center center/cover;
            position: relative;
            color: white;
        }

        .left-overlay {
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(120deg, rgba(0,0,0,0.7), rgba(0,0,0,0.4));
        }

        .left-content {
            position: relative;
            z-index: 2;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px;
        }

        .brand-title {
            font-family: 'Playfair Display', serif;
            font-size: 48px;
            letter-spacing: 3px;
        }

        .brand-subtitle {
            font-size: 18px;
            margin-top: 10px;
            color: #ddd;
        }

        .brand-footer {
            margin-top: 20px;
            font-size: 14px;
            color: #bbb;
        }

        /* RIGHT SIDE */
        .right-side {
            width: 40%;
            background: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            width: 100%;
            max-width: 350px;
            animation: fadeIn 1s ease;
        }

        .login-title {
            font-weight: 600;
            font-size: 26px;
            margin-bottom: 5px;
        }

        .login-subtitle {
            font-size: 14px;
            color: #888;
            margin-bottom: 25px;
        }

        .form-control {
            height: 45px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .btn-login {
            width: 100%;
            background: linear-gradient(45deg, #4facfe, #00f2fe);
            border: none;
            height: 45px;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-login:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* MOBILE */
        @media(max-width: 900px) {
            .left-side {
                display: none;
            }

            .right-side {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <div class="container-login">

        <!-- IZQUIERDA -->
        <div class="left-side">
            <div class="left-overlay"></div>

            <div class="left-content">
                <div class="brand-title">TRIBECA SOHO</div>
                <div class="brand-subtitle">
                    Gestión inteligente de edificios
                </div>
                <div class="brand-footer">
                    Sistema desarrollado por <strong>DigitBol</strong>
                </div>
            </div>
        </div>

        <!-- DERECHA -->
        <div class="right-side">

            <div class="login-box">

                <div class="login-title">Bienvenido</div>
                <div class="login-subtitle">Accede a tu cuenta</div>

                <form method="POST" action="<?php echo e(route('login')); ?>">
                    <?php echo csrf_field(); ?>

                    <input type="email" name="email" class="form-control"
                        placeholder="Correo electrónico" required>

                    <input type="password" name="password" class="form-control"
                        placeholder="Contraseña" required>

                    <button type="submit" class="btn-login">
                        Ingresar
                    </button>
                </form>

            </div>

        </div>

    </div>

</body>

</html><?php /**PATH D:\2.TRIBECA\1.WEB\git\resources\views/auth/login.blade.php ENDPATH**/ ?>
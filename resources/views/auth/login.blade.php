<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>TRIBECA SOHO | Login</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Playfair+Display:wght@600&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('auth/vendor/bootstrap/css/bootstrap.min.css') }}">

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

        .left-side {
            width: 60%;
            background: url('{{ asset('edificio.jpeg') }}') no-repeat center center/cover;
            position: relative;
            color: white;
        }

        .left-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(
                120deg,
                rgba(0, 0, 0, 0.72),
                rgba(0, 0, 0, 0.38)
            );
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
            animation: fadeIn 0.8s ease;
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
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-login:hover:not(:disabled) {
            transform: translateY(-1px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.18);
        }

        .btn-login:disabled {
            cursor: not-allowed;
            opacity: 0.75;
            transform: none;
        }

        .login-spinner {
            width: 18px;
            height: 18px;
            border: 2px solid rgba(255, 255, 255, 0.45);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
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

        @media(max-width: 900px) {
            .left-side {
                display: none;
            }

            .right-side {
                width: 100%;
                padding: 25px;
            }

            .login-box {
                max-width: 390px;
            }
        }
    </style>
</head>

<body>

    <div class="container-login">

        <div class="left-side">
            <div class="left-overlay"></div>

            <div class="left-content">
                <div class="brand-title">
                    TRIBECA SOHO
                </div>

                <div class="brand-subtitle">
                    Gestión inteligente de edificios
                </div>

                <div class="brand-footer">
                    Sistema desarrollado por <strong>DigitBol</strong>
                </div>
            </div>
        </div>

        <div class="right-side">

            <div class="login-box">

                <div class="login-title">
                    Bienvenido
                </div>

                <div class="login-subtitle">
                    Ingresa tus credenciales para acceder al sistema
                </div>

                <form
                    id="loginForm"
                    method="POST"
                    action="{{ route('login') }}"
                >
                    @csrf

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        placeholder="Correo electrónico"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                        autofocus
                    >

                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        placeholder="Contraseña"
                        required
                        autocomplete="current-password"
                    >

                    <button
                        type="submit"
                        id="btnLogin"
                        class="btn-login"
                    >
                        <span id="loginText">
                            Ingresar
                        </span>
                    </button>

                </form>

            </div>

        </div>

    </div>

    <script>
        document
            .getElementById('loginForm')
            .addEventListener('submit', function () {

                const boton = document.getElementById('btnLogin');

                boton.disabled = true;

                boton.innerHTML = `
                    <span class="login-spinner"></span>
                    <span>Ingresando...</span>
                `;
            });
    </script>

</body>

</html>
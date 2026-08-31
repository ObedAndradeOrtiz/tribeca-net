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

        .resident-divider {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 18px 0;
            color: #9aa4b2;
            font-size: 12px;
            font-weight: 600;
        }

        .resident-divider::before,
        .resident-divider::after {
            content: "";
            height: 1px;
            background: #e4e9f1;
            flex: 1;
        }

        .btn-google {
            width: 100%;
            height: 45px;
            border-radius: 8px;
            border: 1px solid #dce3ee;
            background: #ffffff;
            color: #202b3c;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 12px;
        }

        .btn-google:hover {
            background: #f7f9fc;
        }

        .resident-code-form {
            display: flex;
            gap: 8px;
        }

        .resident-code-form .form-control {
            margin-bottom: 0;
            text-transform: uppercase;
        }

        .btn-code {
            width: 48px;
            height: 45px;
            border: none;
            border-radius: 8px;
            background: #172033;
            color: #ffffff;
            flex: 0 0 auto;
        }

        .resident-help {
            margin-top: 8px;
            color: #8a95a6;
            font-size: 12px;
            line-height: 1.4;
        }

        .login-error {
            background: #fff0f3;
            border: 1px solid #ffc9d4;
            color: #b42345;
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 14px;
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

                @if ($errors->any())
                    <div class="login-error">
                        {{ $errors->first() }}
                    </div>
                @endif

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

                <div class="resident-divider">Residentes</div>

                <button type="button" id="btnGoogleResident" class="btn-google">
                    <span>G</span>
                    Ingresar con Google
                </button>

                <form id="firebaseResidentForm" method="POST" action="{{ route('resident.firebase.login') }}">
                    @csrf
                    <input type="hidden" name="firebase_token" id="firebaseToken">
                </form>

                <form method="POST" action="{{ route('resident.code.login') }}" class="resident-code-form">
                    @csrf
                    <input
                        type="text"
                        name="resident_code"
                        class="form-control"
                        placeholder="Codigo de acceso"
                        autocomplete="one-time-code"
                    >
                    <button type="submit" class="btn-code" title="Ingresar con codigo">
                        &rarr;
                    </button>
                </form>

                <div class="resident-help">
                    Si eres propietario o residente, ingresa con Google o solicita un codigo al administrador.
                </div>

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

    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.5/firebase-app.js";
        import {
            getAuth,
            getRedirectResult,
            GoogleAuthProvider,
            signInWithPopup,
            signInWithRedirect,
        } from "https://www.gstatic.com/firebasejs/10.12.5/firebase-auth.js";

        const firebaseConfig = {
            apiKey: @json(config('services.firebase.api_key')),
            authDomain: @json(config('services.firebase.auth_domain')),
            projectId: @json(config('services.firebase.project_id')),
            storageBucket: @json(config('services.firebase.storage_bucket')),
            messagingSenderId: @json(config('services.firebase.messaging_sender_id')),
            appId: @json(config('services.firebase.app_id')),
            measurementId: @json(config('services.firebase.measurement_id')),
        };

        const app = initializeApp(firebaseConfig);
        const auth = getAuth(app);
        const provider = new GoogleAuthProvider();
        const button = document.getElementById('btnGoogleResident');
        const form = document.getElementById('firebaseResidentForm');
        const tokenInput = document.getElementById('firebaseToken');

        auth.languageCode = 'es';
        provider.setCustomParameters({
            prompt: 'select_account',
        });

        const submitResidentToken = async (user) => {
            const token = await user.getIdToken();

            tokenInput.value = token;
            form.submit();
        };

        const restoreButton = () => {
            button.disabled = false;
            button.innerHTML = '<span>G</span> Ingresar con Google';
        };

        const isMobileBrowser = () => {
            return window.matchMedia('(max-width: 768px)').matches
                || /Android|iPhone|iPad|iPod|Mobile/i.test(navigator.userAgent);
        };

        getRedirectResult(auth)
            .then((result) => {
                if (result?.user) {
                    button.disabled = true;
                    button.innerHTML = '<span class="login-spinner"></span><span>Validando...</span>';

                    submitResidentToken(result.user);
                }
            })
            .catch((error) => {
                restoreButton();
                alert('No se pudo completar el ingreso con Google. Detalle: ' + (error.code || 'error desconocido'));
            });

        button.addEventListener('click', async function () {
            button.disabled = true;
            button.innerHTML = '<span class="login-spinner"></span><span>Conectando...</span>';

            try {
                if (isMobileBrowser()) {
                    await signInWithRedirect(auth, provider);

                    return;
                }

                const result = await signInWithPopup(auth, provider);

                await submitResidentToken(result.user);
            } catch (error) {
                restoreButton();
                alert('No se pudo iniciar sesion con Google. Detalle: ' + (error.code || 'error desconocido'));
            }
        });
    </script>

</body>

</html>

<!doctype html>
<html lang="es">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>HOTEL ROJAS | SISTEMA</title>
<link href="<?php echo e(asset('logos/LOGOSINFONDO.png')); ?>" rel="icon">
<meta charset="utf-8" />
<link rel="stylesheet" href="<?php echo e(asset('assets/plugins/bootstrap/css/bootstrap.min.css')); ?>" />
<link rel="stylesheet" href="<?php echo e(asset('assets/plugins/summernote/dist/summernote.css')); ?>" />
<link rel="stylesheet" href="<?php echo e(asset('assets/css/style.min.css')); ?>" />
<link rel="stylesheet" href="assets/css/style.min.css" />
</head>

<body class="font-muli theme-cyan gradient">
    <div class="auth option2">
        <div class="auth_left">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <a href="index.html" class="d-block auth-logo">
                            <img src="logos/LOGOSINFONDO.png" alt="" height="30" class="auth-logo-dark">
                            <img src="" alt="" height="30" class="auth-logo-light">
                        </a>
                        <div class="mt-3 card-title">Inicia sesión en HOTEL ROJAS</div>
                    </div>
                    <form method="POST" action="<?php echo e(route('login')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="p-3">
                            <h4 class="mb-1 text-center text-muted font-size-18">Bienvenido !</h4>
                            <p class="text-center text-muted">Inicia sesión en HOTEL ROJAS.</p>
                            <form class="mt-4 form-horizontal" action="index.html">
                                <div class="mb-3">
                                    <label for="username">Email:</label>
                                    <input type="email" class="form-control" id="email" type="email"
                                        name="email" :value="old('email')" required autofocus
                                        autocomplete="username">
                                </div>
                                <div class="mb-3">
                                    <label for="userpassword">Contraseña:</label>
                                    <input type="password" class="form-control" type="password" name="password" required
                                        autocomplete="current-password">
                                </div>
                                <div class="mt-4 mb-3 row">
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="customControlInline">
                                            <label class="form-check-label" for="customControlInline">Recordar
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6 text-end">
                                        <button class="btn btn-primary w-md waves-effect waves-light"
                                            type="submit">Iniciar sesión</button>
                                    </div>
                                </div>
                                <div class="mb-0 form-group row">
                                </div>
                            </form>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/bundles/lib.vendor.bundle.js"></script>
    <script src="../assets/js/core.js"></script>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\miora-project-1\resources\views/auth/login.blade.php ENDPATH**/ ?>
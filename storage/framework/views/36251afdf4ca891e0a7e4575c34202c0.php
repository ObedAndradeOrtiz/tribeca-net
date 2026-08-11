<!doctype html>
<html lang="es">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>HOTEL ROJAS | SISTEMA</title>
<head>
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
                        <div class="mt-3 card-title">REGISTRO DE HOTEL ROJAS</div>
                    </div>
                    <form method="POST" action="<?php echo e(route('register')); ?>">
                        <?php echo csrf_field(); ?>
                        <?php if (isset($component)) { $__componentOriginalb24df6adf99a77ed35057e476f61e153 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb24df6adf99a77ed35057e476f61e153 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.validation-errors','data' => ['class' => 'mb-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('validation-errors'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mb-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb24df6adf99a77ed35057e476f61e153)): ?>
<?php $attributes = $__attributesOriginalb24df6adf99a77ed35057e476f61e153; ?>
<?php unset($__attributesOriginalb24df6adf99a77ed35057e476f61e153); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb24df6adf99a77ed35057e476f61e153)): ?>
<?php $component = $__componentOriginalb24df6adf99a77ed35057e476f61e153; ?>
<?php unset($__componentOriginalb24df6adf99a77ed35057e476f61e153); ?>
<?php endif; ?>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingText" placeholder="jhondoe"
                                name="name" :value="old('Nombre')" required autofocus autocomplete="name">
                            <label for="floatingText">Nombre completo</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com"
                                name="email" :value="old('Correo')" required autocomplete="username">
                            <label for="floatingInput">Correo</label>
                        </div>

                        <div class="form-floating mb-4">
                            <input type="password" class="form-control" id="floatingPassword"
                                placeholder="Repetir contraseña" name="password" required autocomplete="new-password">
                            <label for="floatingPassword">Contraseña</label>
                        </div>
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control" id="floatingPassword" placeholder="Contraseña"
                                name="password_confirmation" required autocomplete="new-password">
                            <label for="floatingPassword">Repetir Contraseña</label>
                        </div>
                        <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Registrarme</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/bundles/lib.vendor.bundle.js"></script>
    <script src="../assets/js/core.js"></script>
</body>

</html>
<?php /**PATH /home/hotelroj/public_html/resources/views/auth/register.blade.php ENDPATH**/ ?>
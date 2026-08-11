<!doctype html>
<html lang="es">
<title>HOTEL ROJAS | INGRESAR</title>
<link href="<?php echo e(asset('logos/LOGOSINFONDO.png')); ?>" rel="icon">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('auth/vendor/bootstrap/css/bootstrap.min.css')); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('auth/fonts/font-awesome-4.7.0/css/font-awesome.min.css')); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('auth/vendor/animate/animate.css')); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('auth/vendor/css-hamburgers/hamburgers.min.css')); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('auth/vendor/animsition/css/animsition.min.css')); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('auth/vendor/select2/select2.min.css')); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('auth/vendor/daterangepicker/daterangepicker.css')); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('auth/css/util.css')); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('auth/css/main.css')); ?>">
</head>
<body>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
                <form method="POST" action="<?php echo e(route('login')); ?>" class="login100-form validate-form p-l-55 p-r-55 p-t-178">
                    <?php echo csrf_field(); ?>
					<span class="login100-form-title">
						Inicio de sesión
					</span>
					<div class="wrap-input100 validate-input m-b-16" data-validate="Por favor ingresa tu correo">
						<input class="input100" id="email" type="email" name="email"  placeholder="Correo electrónico">
						<span class="focus-input100"></span>
					</div>
					<div class="mb-4 wrap-input100 validate-input" data-validate = "Por favor ingresa tu contraseña">
						<input class="input100" type="password" type="password" name="password" placeholder="Contraseña">
						<span class="focus-input100"></span>
					</div>
					<div class="mb-4 container-login100-form-btn">
						<button  type="submit" class="login100-form-btn">
							Ingresar
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script src="<?php echo e(asset('auth/vendor/jquery/jquery-3.2.1.min.js')); ?>"></script>
	<script src="<?php echo e(asset('auth/vendor/animsition/js/animsition.min.js')); ?>"></script>
	<script src="<?php echo e(asset('auth/vendor/bootstrap/js/popper.js')); ?>"></script>
	<script src="<?php echo e(asset('auth/vendor/bootstrap/js/bootstrap.min.js')); ?>"></script>
	<script src="<?php echo e(asset('auth/vendor/select2/select2.min.js')); ?>"></script>
	<script src="<?php echo e(asset('auth/vendor/daterangepicker/moment.min.js')); ?>"></script>
	<script src="<?php echo e(asset('auth/vendor/daterangepicker/daterangepicker.js')); ?>"></script>
	<script src="<?php echo e(asset('auth/vendor/countdowntime/countdowntime.js')); ?>"></script>
	<script src="<?php echo e(asset('auth/js/main.js')); ?>"></script>
</body>
</html>
<?php /**PATH D:\0.APROJECTS\4.HOTEL-ROJAS\1.CODE\public_html\resources\views/auth/login.blade.php ENDPATH**/ ?>
<?php

/*
|--------------------------------------------------------------------------
| Crear enlace public/storage en cPanel
|--------------------------------------------------------------------------
|
| Sube este archivo dentro de la carpeta public del proyecto y abre:
| https://tudominio.com/crear-storage-link.php
|
| Luego de usarlo, por seguridad puedes borrarlo del servidor.
|
*/

$publicPath = __DIR__;
$projectPath = dirname($publicPath);
$target = $projectPath . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'public';
$link = $publicPath . DIRECTORY_SEPARATOR . 'storage';

function h($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function line($label, $value)
{
    echo '<p><strong>' . h($label) . ':</strong> ' . h($value) . '</p>';
}

$status = 'Pendiente';
$message = '';

if (! is_dir($target)) {
    @mkdir($target, 0755, true);
}

if (! is_dir($target)) {
    $status = 'Error';
    $message = 'No existe storage/app/public y no se pudo crear.';
} elseif (is_link($link)) {
    $status = 'OK';
    $message = 'El enlace public/storage ya existe.';
} elseif (file_exists($link)) {
    $status = 'Atencion';
    $message = 'Ya existe un archivo o carpeta llamado public/storage. Debe eliminarse o renombrarse antes de crear el enlace.';
} elseif (! function_exists('symlink')) {
    $status = 'Error';
    $message = 'La funcion symlink esta deshabilitada en este hosting.';
} else {
    $created = @symlink($target, $link);

    if ($created) {
        $status = 'OK';
        $message = 'Enlace public/storage creado correctamente.';
    } else {
        $status = 'Error';
        $message = 'No se pudo crear el enlace. Es posible que cPanel no permita symlink desde PHP.';
    }
}

?><!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Crear storage link</title>
    <style>
        body {
            margin: 0;
            padding: 24px;
            background: #f8fafc;
            color: #111827;
            font-family: Arial, sans-serif;
        }

        .box {
            max-width: 820px;
            margin: 0 auto;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 22px;
        }

        h1 {
            margin: 0 0 12px;
            font-size: 24px;
        }

        .status {
            display: inline-block;
            margin-bottom: 14px;
            padding: 8px 12px;
            border-radius: 999px;
            background: #eff6ff;
            color: #1d4ed8;
            font-weight: 700;
        }

        code {
            display: block;
            overflow-wrap: anywhere;
            padding: 10px;
            border-radius: 8px;
            background: #f1f5f9;
        }
    </style>
</head>
<body>
    <div class="box">
        <h1>Crear storage link</h1>
        <div class="status"><?php echo h($status); ?></div>

        <p><?php echo h($message); ?></p>

        <?php line('Proyecto', $projectPath); ?>
        <?php line('Destino real', $target); ?>
        <?php line('Enlace publico', $link); ?>

        <p>Prueba esperada:</p>
        <code><?php echo h('/storage/nombre-de-carpeta/nombre-archivo.jpg'); ?></code>

        <p>Despues de confirmar que funciona, elimina este archivo del servidor para evitar accesos innecesarios.</p>
    </div>
</body>
</html>

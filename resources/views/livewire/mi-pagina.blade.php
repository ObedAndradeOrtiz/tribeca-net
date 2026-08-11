<div>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $nombrepaginageneral }}</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    @if ($estiloFormaWeb == 'cuadrado')
        <style>
            /* Estilos para los botones */
            button {
                background-color: gray;
                color: white;
                border: none;
                padding: 5px 5px;
                margin-top: 5%;
                border-radius: 2px;
                cursor: pointer;
                margin: 15px;
            }

            .card {
                border-radius: 5px;
            }
        </style>
    @endif
    @if ($estiloFormaWeb == 'redondo')
        <style>
            /* Estilos para los botones */
            button {
                background-color: gray;
                color: white;
                border: none;
                padding: 5px 5px;
                margin-top: 5%;
                border-radius: 25px;
                cursor: pointer;
                margin: 15px;
            }

            .card {
                border-radius: 25px;
            }
        </style>
    @endif
    <style>
        @media screen and (max-width: 720px) {
            .card {
                width: 100%;
            }

            .boton-inferior {
                margin-top: 0px;
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                background-color: rgba(255, 2, 2, 0);
                /* Fondo tipo "glass" con opacidad */
                backdrop-filter: blur(10px);
                /* Efecto de desenfoque */
                text-align: center;
                padding: 5px;
            }

            p {
                font-size: 5px;
            }

            .boton-carrito button {
                width: 50px;
                /* Ajusta el ancho y el alto para hacer el botón circular */
                height: 50px;
                border-radius: 50%;
                background-color: #4285F4;
                color: white;
                font-size: 16px;
                cursor: pointer;
            }

        }

        p {
            font-size: 10px;
        }
    </style>
    <style>
        .phone-content::-webkit-scrollbar {
            width: 0px;
        }

        .phone-content::-webkit-scrollbar-track {
            background: #00000000;
        }

        .phone-content::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 0px;
        }

        .phone-content::-webkit-scrollbar-thumb:hover {
            background: #9f9e9e;
        }

        body {
            max-width: 720px;
            margin: 0 auto;
            padding: 0 0px;
        }

        .fondo::before {
            position: absolute;
            z-index: -1;
            filter: blur(25px);
        }

        @font-face {
            font-family: 'VT323';
            src: url('../../fonts/VT323/VT323-Regular.ttf');
        }

        @font-face {
            font-family: 'Lilita_One';
            src: url('../../fonts/Lilita_One/LilitaOne-Regular.ttf');
        }

        @font-face {
            font-family: 'Bebas_Neue';
            src: url('../../fonts/Bebas_Neue/BebasNeue-Regular.ttf');
        }

        @font-face {
            font-family: 'Borel';
            src: url('../../fonts/Borel/Borel-Regular.ttf');
        }

        @font-face {
            font-family: 'Caveat';
            src: url('../../fonts/Caveat/Caveat-VariableFont_wght.ttf');
        }

        @font-face {
            font-family: 'Cherry_Bomb_One';
            src: url('../../fonts/Cherry_Bomb_One/CherryBombOne-Regular.ttf');
        }

        @font-face {
            font-family: 'Dancing_Script';
            src: url('../../fonts/Dancing_Script/DancingScript-VariableFont_wght.ttf');
        }

        @font-face {
            font-family: 'Edu_SA_Beginner';
            src: url('../../fonts/Edu_SA_Beginner/EduSABeginner-VariableFont_wght.ttf');
        }

        @font-face {
            font-family: 'Handjet';
            src: url('../../fonts/Handjet/Handjet-VariableFont_ELGRELSHwght.ttf');
        }

        @font-face {
            font-family: 'Lobster';
            src: url('../../fonts/Lobster/Lobster-Regular.ttf');
        }

        @font-face {
            font-family: 'Montserrat';
            src: url('../../fonts/Montserrat/Montserrat-Italic-VariableFont_wghtttf');
        }

        @font-face {
            font-family: 'Oswald';
            src: url('../../fonts/Oswald/Oswald-VariableFont_wght.ttf');
        }

        @font-face {
            font-family: 'Pacifico';
            src: url('../../fonts/Pacifico/Pacifico-Regular.ttf');
        }

        @font-face {
            font-family: 'Preahvihear';
            src: url('../../fonts/Preahvihear/Preahvihear-Regular.ttf');
        }

        @font-face {
            font-family: 'Rajdhani';
            src: url('../../fonts/Rajdhani/Rajdhani-Regular.ttf');
        }

        @font-face {
            font-family: 'Shadows_Into_Light';
            src: url('../../fonts/Shadows_Into_Light/ShadowsIntoLight-Regular.ttf');
        }

        @font-face {
            font-family: 'Teko';
            src: url('../../fonts/Teko/Teko-Regular.ttf');
        }

        @font-face {
            font-family: 'Tektur';
            src: url('../../fonts/Tektur/Tektur-VariableFont_wght.ttf');
        }

        @font-face {
            font-family: 'Yanone';
            src: url('../../fonts/Yanone_Kaffeesatz/YanoneKaffeesatz-VariableFont_wght.ttf');
        }

        /* Estilos para los botones */
        /* button {
            background-color: gray;
            color: white;
            border: none;
            padding: 5px 10px;
            margin: 10px;
            border-radius: 5px;
            cursor: pointer;

        } */

        /* Efecto 1 - Movimiento horizontal */
        .boton-efecto1 {
            animation: movimiento-horizontal 2s infinite alternate;
        }

        @keyframes movimiento-horizontal {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(50px);
            }
        }

        /* Efecto 2 - Cambio de color */
        .boton-efecto2 {
            animation: cambio-color 1s infinite alternate;
        }

        @keyframes cambio-color {
            from {
                background-color: red;
            }

            to {
                background-color: blue;
            }
        }

        /* Efecto 3 - Escalado */
        .boton-efecto3 {
            animation: escalado 0.5s infinite alternate;
        }

        @keyframes escalado {
            from {
                transform: scale(1);
            }

            to {
                transform: scale(1.2);
            }
        }

        /* Efecto 4 - Rotación */
        .boton-efecto4 {
            animation: rotacion 2s infinite linear;
        }

        @keyframes rotacion {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        /* Efecto 5 - Parpadeo */
        .boton-efecto5 {
            animation: parpadeo 1s infinite;
        }

        @keyframes parpadeo {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        /* Efecto 6 - Desvanecimiento */
        .boton-efecto6 {
            animation: desvanecimiento 1s infinite alternate;
        }

        @keyframes desvanecimiento {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
            }
        }

        /* Efecto 7 - Rebote */
        .boton-efecto7 {
            animation: rebote 0.5s infinite alternate;
        }

        @keyframes rebote {
            from {
                transform: translateY(0);
            }

            to {
                transform: translateY(-10px);
            }
        }

        /* Efecto 8 - Zoom */
        .boton-efecto8 {
            animation: zoom 0.5s infinite alternate;
        }

        @keyframes zoom {
            from {
                transform: scale(1);
            }

            to {
                transform: scale(1.2);
            }
        }

        /* Efecto 9 - Giro y cambio de color */
        .boton-efecto9 {
            animation: giro-y-color 2s infinite linear;
        }

        @keyframes giro-y-color {
            0% {
                transform: rotate(0deg);
                background-color: gray;
            }

            50% {
                transform: rotate(180deg);
                background-color: darkgray;
            }

            100% {
                transform: rotate(360deg);
                background-color: gray;
            }
        }


        .phone-preview {
            max-width: 720px;
            background-repeat: no-repeat;


        }

        /* .phone-frame {
            position: relative;
            width: 100%;
            padding-bottom: 200%;
            background-color: #333;
            border-radius: 0px;
            overflow: hidden;
        } */





        .phone-content {
            border-radius: 0px;
            position: absolute;
            top: 0px;
            bottom: 0px;
            left: 0px;
            right: 0px;
            overflow: auto;
            padding: 0px;

        }

        .phone-content h2 {}

        .phone-content p {
            margin-bottom: 8px;
        }

        .phone-content img {
            max-width: 100%;
            height: auto;
            margin-top: 10px;
        }

        .titulo.izquierda {
            text-align: left;
        }

        .titulo.derecha {
            text-align: right;
        }

        .titulo.centro {
            text-align: center;
        }

        .subtitulo.izquierda {
            text-align: left;
        }

        .subtitulo.derecha {
            text-align: right;
        }

        .subtitulo.centro {
            text-align: center;
        }

        .perfil.izquierda {
            text-align: left;
        }

        .perfil.derecha {
            text-align: right;
        }

        .perfil.centro {
            text-align: center;
        }

        .card {
            overflow-y: auto;
            width: 100%;

            box-sizing: border-box;
            background-color: white;

        }

        .card::-webkit-scrollbar {
            width: 10px;
        }

        .card::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .card::-webkit-scrollbar-thumb {
            background: #888;

        }

        .card::-webkit-scrollbar-thumb:hover {
            background: #9f9e9e;
        }

        .button-card {
            display: flex;
            justify-content: center;
            margin-bottom: 10px;
        }

        .button-item {
            border-radius: 25px solid;
            margin: 0 5px;
            flex-grow: 1;
        }

        .btn {
            border-radius: 25px solid;
        }

        .list {
            list-style-type: none;
            padding: 0;
        }

        .item {
            display: flex;
            align-items: center;
        }

        .button {
            float: right;
            background-color: #52b1e5;
        }

        input {
            border-color: #333;
        }

        .slider-container {
            width: 100%;
            height: 100px;
            background-color: #f2f2f2;
            margin-left: 10px;
            align-items: center;
            justify-content: center;
        }

        .slider-bar {
            width: 95%;
            height: 10px;
            background-color: #52b1e53a;
            position: relative;
            margin-left: 15px;
        }

        #slider-button {
            width: 20px;
            height: 20px;
            background-color: #52b1e5;
            position: absolute;
            top: -5px;
            left: 0;
            cursor: grab;
            user-select: none;
            border-radius: 50%
        }

        .divider {
            border: none;
            margin-left: 10px;
            height: 2px;
            background-color: #e0e0e0;
        }

        .verificacion {
            display: flex;
        }

        .sphere {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;

            height: 50px;

            border-radius: 50%;
            background-color: blue;

            margin: 5px;
        }

        .sphere i {
            color: white;

            font-size: 24px;

        }

        .hexagon-check {
            clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
        }

        .hexagon-check i {
            color: white;
            font-size: 24px;

        }

        .circle {
            display: inline-block;
            border-radius: 50%;
            background-color: #ccc;
            color: #fff;
            text-align: center;
            line-height: 50px;
        }

        .container {
            display: flex;
            align-items: center;
            width: 100%;
            /* Puedes ajustar el ancho del div según tus necesidades */

            /* Solo para visualización, puedes quitarlo */
            padding: 10px;
            align-items: center;
            overflow: hidden;
        }

        /* Efecto de Sombra */
        .effect-shadow {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        /* Efecto de Gradiente de Texto */
        .effect-gradient {
            background: linear-gradient(to right, #ff0000, #00ff00);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Efecto de Subrayado */
        .effect-underline {
            text-decoration: underline;
        }

        /* Efecto de Tachado */
        .effect-strikethrough {
            text-decoration: line-through;
        }

        /* Efecto de Mayúsculas */
        .effect-uppercase {
            text-transform: uppercase;
        }

        /* Efecto de Minúsculas */
        .effect-lowercase {
            text-transform: lowercase;
        }

        /* Efecto de Capitalización */
        .effect-capitalize {
            text-transform: capitalize;
        }

        /* Efecto de Rotación */
        .effect-rotate {
            animation: rotate 3s linear infinite;
        }

        @keyframes rotate {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Efecto de Escala */
        .effect-scale {
            animation: scale 3s ease-in-out infinite;
        }

        @keyframes scale {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.2);
            }
        }

        /* Efecto de Aparecer */
        .effect-fadein {
            animation: fadein 3s ease-in-out forwards;
            opacity: 0;
        }

        @keyframes fadein {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        /* Efecto de Desvanecer */
        .effect-fadeout {
            animation: fadeout 3s ease-in-out forwards;
            opacity: 1;
        }

        @keyframes fadeout {
            0% {
                opacity: 1;
            }

            100% {
                opacity: 0;
            }
        }

        /* Efecto de Rebote */
        .effect-bounce {
            animation: bounce 1s ease infinite;
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        /* Efecto de Giro */
        .effect-spin {
            animation: spin 3s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Efecto de Saturación */
        .effect-saturation {
            filter: saturate(200%);
        }

        /* Efecto de Desenfoque */
        .effect-blur {
            filter: blur(2px);
        }

        /* Efecto de Escala de Grises */
        .effect-grayscale {
            filter: grayscale(100%);
        }

        /* Efecto de Invertir Colores */
        .effect-invert {
            filter: invert(100%);
        }

        /* Efecto de Brillo */
        .effect-brightness {
            filter: brightness(200%);
        }

        /* Efecto de Contraste */
        .effect-contrast {
            filter: contrast(200%);
        }

        /* Efecto de Opacidad */
        .effect-opacity {
            opacity: 0.5;
        }

        /* Efecto de Sombra de Neón */
        .effect-neon {
            text-shadow: 0 0 10px #00ff00, 0 0 20px #00ff00, 0 0 30px #00ff00;
        }

        /* Efecto de Contorno */
        .effect-outline {
            text-shadow: 1px 1px 1px #000, -1px -1px 1px #000, 1px -1px 1px #000, -1px 1px 1px #000;
        }

        .button-list {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }

        .button-list-v2 {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 10px;
        }

        .imagen-circular {

            border-radius: 50%;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .boton-inferior {
            margin-top: 50px;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;

            background-color: rgba(0, 0, 0, 0);
            /* Fondo tipo "glass" con opacidad */
            backdrop-filter: blur(55px);
            /* Efecto de desenfoque */
            text-align: center;
            padding: 10px;

        }

        .boton-superior {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background-color: rgba(253, 253, 253, 0);
            /* Fondo tipo "glass" con opacidad */
            backdrop-filter: blur(0px);
            /* Efecto de desenfoque */
            text-align: end;
            padding: 1px;

        }

        .boton-carrito {
            /* margin-top: 50px; */
            position: fixed;
            /* bottom: 0; */
            left: 0;
            right: 0;
            top: 0;
            text-align: end;
            padding: 10px;

        }

        .boton-carrito button {
            width: 100px;
            /* Ajusta el ancho y el alto para hacer el botón circular */
            height: 100px;
            border-radius: 50%;
            background-color: #4285F4;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .boton-inferior button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;

            background-color: #4285F4;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .button-inmov {
            display: inline-block;
            padding: 10px 20px;
            background-color: #00ff37;
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            font-size: 18px;
            border: none;
            border-radius: 12px;

        }

        .posicion-icono {
            margin-top: 2%;
        }

        @media screen and (max-width: 720px) {
            .posicion-icono {
                margin-top: 12%;
                margin-bottom: 5%;
            }
        }

        .custom-button {
            display: flex;
            width: 40%;

            padding-top: 5px;
            padding-bottom: 5px;
            margin-bottom: 10px;
            text-align: center;
        }

        @media screen and (max-width: 720px) {
            .custom-button {
                width: 88%;
                text-align: center;

            }
        }
    </style>

    @if ($miWebPublica)
        @if ($imagePath)

            <body class="fondo"
                style=" font-family: {{ $tipoLetra }}, serif; background-image: url('../storage/{{ $imagePath }}'); background-position: 0, center; background-size: cover, auto;transition: 0.5s; background-repeat: no-repeat;">
            @else

                <body class="fondo"
                    style="font-family: {{ $tipoLetra }}, serif; background: linear-gradient({{ $anguloFondo . ',' . $colorFondo }};  background-repeat: no-repeat;">
        @endif
        <main style="">
            <div class="container phone-preview">
                <div class="phone-frame">

                    @if ($imagePath)
                        <div class="phone-content"
                            style="background-image: url('../storage/{{ $imagePath }}'); background-position: 0, center; background-size: cover, auto;transition: 0.5s; background-repeat: no-repeat;">
                        @else
                            <div class="phone-content"
                                style="background: linear-gradient({{ $anguloFondo . ',' . $colorFondo }}">
                    @endif
                    @if ($imagePresentacionOficial)
                        <div class="container" style=" justify-content:  {{ $alineacionPerfil }};">
                            <div class="imagen-circular {{ $efectoPresentacion }}"
                                style="margin-top:5%; width: {{ $sizePresentacion . 'px' }}; height: {{ $sizePresentacion . 'px' }};border: {{ $sizeBorde }} solid {{ $colorBorde }}; background-image: url('../storage/{{ $imagePresentacionOficial }}')">
                            </div>
                        </div>
                    @else
                        <div class="container" style=" justify-content:  {{ $alineacionPerfil }};">

                            <div style=" width: {{ $sizePresentacion . 'px' }};
                              height: {{ $sizePresentacion . 'px' }};  border: {{ $sizeBorde }} solid {{ $colorBorde }};"
                                class="circle perfil {{ $efectoPresentacion }} ">
                                <span></span>
                            </div>
                        </div>
                    @endif
                    @if ($efectoTitulo == 'effect-neon')
                        <div
                            style="margin-top: 15px; text-shadow: 0 0 10px {{ $fondoNeon }}, 0 0 20px {{ $fondoNeon }}, 0 0 30px {{ $fondoNeon }};">
                            <h2 class="titulo {{ $alineacionTitulo }}"
                                style="font-size: {{ $sizeTitle }}; color:{{ $colorTitle }}">
                                {{ $titulo }}</h2>
                        </div>
                    @else
                        <div style="margin-top: 15px;" class="{{ $efectoTitulo }}">
                            <h2 class="titulo {{ $alineacionTitulo }}"
                                style="font-size: {{ $sizeTitle }}; color:{{ $colorTitle }}">
                                {{ $titulo }}</h2>
                        </div>
                    @endif
                    <div style="margin-top: 15px;" class="{{ $efectoSubtitulo }}">
                        <h2 class="subtitulo {{ $alineacionSubtitulo }}"
                            style="font-size: {{ $sizeSubtitle }}; color:{{ $colorSubtitle }}">
                            {{ $bibliografia }}</h2>
                    </div>
                    @if ($posicionIcono == 'arriba')
                        <div class="posicion-icono"
                            style=" display: flex; justify-content: center; align-items: center;">
                            @if ($estadoWss)
                                @if ($tipoIcono == 'clasico')
                                    @if ($estadoIconoNeon == true)
                                        <a wire:click="clickRedes('whatsapp')" href="{{ $enlaceWss }}"
                                            target="_blank">
                                            <div
                                                style="margin-left:5%; font-size: 45px; color:{{ $tipoIconoColor }}; text-shadow: 0 0 10px {{ $colorIconoNeon }}, 0 0 20px {{ $colorIconoNeon }}, 0 0 30px {{ $colorIconoNeon }};">
                                                <i class="bi bi-whatsapp"></i>
                                            </div>
                                        </a>
                                    @else
                                        <a wire:click="clickRedes('whatsapp')" href="{{ $enlaceWss }}"
                                            target="_blank">
                                            <div style="margin-left:5%; font-size: 45px; color:{{ $tipoIconoColor }};">
                                                <i class="bi bi-whatsapp"></i>
                                            </div>
                                        </a>
                                    @endif
                                @else
                                    <a wire:click="clickRedes('whatsapp')" href="{{ $enlaceWss }}"
                                        target="_blank"><img style="height: 55px;" src="{{ asset($rutaWss) }}"
                                            alt=""></a>
                                @endif
                            @endif
                            @if ($estadoInsta)
                                @if ($tipoIcono == 'clasico')
                                    @if ($estadoIconoNeon == true)
                                        <a style="margin-left:5%;" href="{{ $enlaceInsta }}"
                                            wire:click="clickRedes('instagram')">
                                            <div
                                                style="margin-left:5%; font-size: 45px; color:{{ $tipoIconoColor }}; text-shadow: 0 0 10px {{ $colorIconoNeon }}, 0 0 20px {{ $colorIconoNeon }}, 0 0 30px {{ $colorIconoNeon }};">
                                                <i class="bi bi-instagram"></i>
                                            </div>
                                        </a>
                                    @else
                                        <a style="margin-left:5%;" href="{{ $enlaceInsta }}"
                                            wire:click="clickRedes('instagram')">
                                            <div style="margin-left:5%; font-size: 45px; color:{{ $tipoIconoColor }}">
                                                <i class="bi bi-instagram"></i>
                                            </div>
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ $enlaceInsta }}"><img style="height: 55px;"
                                            src="{{ asset($rutaInsta) }}" alt=""></a>
                                @endif
                            @endif
                            @if ($estadoTiktok)
                                @if ($tipoIcono == 'clasico')
                                    @if ($estadoIconoNeon == true)
                                        <a style="margin-left:5%;" href="{{ $enlaceTiktok }}"
                                            wire:click="clickRedes('tiktok')">
                                            <div
                                                style="margin-left:5%; font-size: 45px; color:{{ $tipoIconoColor }}; text-shadow: 0 0 10px {{ $colorIconoNeon }}, 0 0 20px {{ $colorIconoNeon }}, 0 0 30px {{ $colorIconoNeon }};">
                                                <i class="bi bi-tiktok"></i>
                                            </div>
                                        </a>
                                    @else
                                        <a style="margin-left:5%;" href="{{ $enlaceTiktok }}"
                                            wire:click="clickRedes('tiktok')">
                                            <div style="margin-left:5%; font-size: 45px; color:{{ $tipoIconoColor }}">
                                                <i class="bi bi-tiktok"></i>
                                            </div>
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ $enlaceTiktok }}"><img style="height: 55px;"
                                            src="{{ asset($rutaTiktok) }}" alt=""></a>
                                @endif
                            @endif
                            @if ($estadoFacebook)
                                @if ($tipoIcono == 'clasico')
                                    @if ($estadoIconoNeon == true)
                                        <a style="margin-left:5%;" href="{{ $enlaceFacebook }}"
                                            wire:click="clickRedes('facebook')">
                                            <div
                                                style="margin-left:5%; font-size: 45px; color:{{ $tipoIconoColor }}; text-shadow: 0 0 10px {{ $colorIconoNeon }}, 0 0 20px {{ $colorIconoNeon }}, 0 0 30px {{ $colorIconoNeon }};">
                                                <i class="bi bi-facebook"></i>
                                            </div>
                                        </a>
                                    @else
                                        <a style="margin-left:5%;" href="{{ $enlaceFacebook }}"
                                            wire:click="clickRedes('facebook')">
                                            <div style="margin-left:5%; font-size: 45px; color:{{ $tipoIconoColor }}">
                                                <i class="bi bi-facebook"></i>
                                            </div>
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ $enlaceFacebook }}"> <img style="height: 55px;"
                                            src="{{ asset($rutaFacebook) }}" alt=""></a>
                                @endif
                            @endif
                        </div>
                    @endif
                    @if ($misEnlaces)
                        <div class="container" style="flex-direction: column;">
                            @foreach ($misEnlaces as $item)
                                @if ($item->estiloEnlace == 'borde' && $item->estadoEnlace)
                                    <button wire:click="clickEnlace({{ $item->id }})"
                                        style="background-color: rgba(0, 0, 0, 0); border: 2px solid {{ $item->ColorFondo }}; "
                                        class="custom-button {{ $item->efectoEnlace }}"><img
                                            style="height: 24px; margin-top: -1px;"
                                            src="{{ asset($item->iconoenlace) }}" alt=""><a
                                            style="color:{{ $item->colorLetraBoton }}" class="ml-4"
                                            href="{{ $item->enlace }}">{{ $item->tituloenlace }}</a></button>
                                @endif
                                @if ($item->estiloEnlace == 'color' && $item->estadoEnlace)
                                    <button wire:click="clickEnlace({{ $item->id }})"
                                        style="display: inline-flex;background-color: {{ $item->ColorFondo }};"
                                        class="custom-button {{ $item->efectoEnlace }}">
                                        <img src="{{ asset($item->iconoenlace) }}" alt=""
                                            style="height: 24px; margin-top: -1px;"><a
                                            style="color:{{ $item->colorLetraBoton }}" class="ml-4"
                                            href="{{ $item->enlace }}">{{ $item->tituloenlace }}</a></button>
                                @endif
                            @endforeach
                        </div>
                    @endif
                    <div style="display: flex; font-size: 16px; overflow:auto; justify-content: center;">
                        @foreach ($categorias as $item)
                            @if ($item->nombreCategoria == $categoriaBoton)
                                <button wire:click="$set('categoriaBoton','{{ $item->nombreCategoria }}')"
                                    style="background:{{ $colorBordeCategoria }}; border: 2px solid {{ $colorBordeCategoria }};"><span
                                        style="color:{{ $colorLetraCategoria }}">{{ $item->nombreCategoria }}</span>
                                </button>
                            @else
                                <button wire:click="$set('categoriaBoton','{{ $item->nombreCategoria }}')"
                                    style="background: rgba(0, 0, 0, 0); border: 2px solid {{ $colorBordeCategoria }};"><span
                                        style="color:{{ $colorLetraCategoria }}">{{ $item->nombreCategoria }}</span>
                                </button>
                            @endif
                        @endforeach
                    </div>
                    @if ($misProductos)
                        <div class="container"
                            style="display: flex; flex-direction: row; flex-wrap: wrap; justify-content: center; overflow:auto;">
                            @foreach ($misProductos as $item)
                                @if ($item->categoriaProducto == $categoriaBoton)
                                    <div class="card" style="background-color: #000000c7; margin:10px;">
                                        <div
                                            style="display: flex; align-items: center; justify-content:center; margin:3%;">
                                            <label for=""
                                                style="text-align: center; color:whitesmoke;">{{ $item->nombre }}</label>
                                        </div>
                                        <div style="display: flex; align-items: center; justify-content:center;">

                                            <img src="../storage/{{ $item->imageProducto }}" alt="">
                                        </div>


                                        <div class="card-body">
                                            <label for="" style="color:whitesmoke">Descripción:
                                                {{ $item->descripcion }}</label>
                                            <br>

                                            <label for="" style="color:whitesmoke;">Precio:
                                                {{ $item->precio }}</label>
                                            <div style="display: flex; justify-content:center">
                                                @if ($estadoCarrito == true)
                                                    <button wire:click="seleccionarProducto({{ $item->id }})"
                                                        style="background-color: rgb(0, 189, 0); width: 60%;">

                                                        <div
                                                            style="display: flex; align-items: center; justify-content: center;">

                                                            Agregar <svg class="icon-20" width="20"
                                                                viewBox="0 0 24 24" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M14.1213 11.2331H16.8891C17.3088 11.2331 17.6386 10.8861 17.6386 10.4677C17.6386 10.0391 17.3088 9.70236 16.8891 9.70236H14.1213C13.7016 9.70236 13.3719 10.0391 13.3719 10.4677C13.3719 10.8861 13.7016 11.2331 14.1213 11.2331ZM20.1766 5.92749C20.7861 5.92749 21.1858 6.1418 21.5855 6.61123C21.9852 7.08067 22.0551 7.7542 21.9652 8.36549L21.0159 15.06C20.8361 16.3469 19.7569 17.2949 18.4879 17.2949H7.58639C6.25742 17.2949 5.15828 16.255 5.04837 14.908L4.12908 3.7834L2.62026 3.51807C2.22057 3.44664 1.94079 3.04864 2.01073 2.64043C2.08068 2.22305 2.47038 1.94649 2.88006 2.00874L5.2632 2.3751C5.60293 2.43735 5.85274 2.72207 5.88272 3.06905L6.07257 5.35499C6.10254 5.68257 6.36234 5.92749 6.68209 5.92749H20.1766ZM7.42631 18.9079C6.58697 18.9079 5.9075 19.6018 5.9075 20.459C5.9075 21.3061 6.58697 22 7.42631 22C8.25567 22 8.93514 21.3061 8.93514 20.459C8.93514 19.6018 8.25567 18.9079 7.42631 18.9079ZM18.6676 18.9079C17.8282 18.9079 17.1487 19.6018 17.1487 20.459C17.1487 21.3061 17.8282 22 18.6676 22C19.4969 22 20.1764 21.3061 20.1764 20.459C20.1764 19.6018 19.4969 18.9079 18.6676 18.9079Z"
                                                                    fill="currentColor"></path>
                                                            </svg>
                                                        </div>
                                                    </button>
                                                @endif
                                            </div>
                                            <div style="display: flex; justify-content:center">
                                                @if ($item->enlaceProducto && $estadoCarrito == true)
                                                    <button style="background-color: rgb(0, 189, 0);  width: 60%;">
                                                        <a href="{{ $item->enlaceProducto }}">
                                                            <div
                                                                style="display: flex; align-items: center; justify-content: center;">

                                                                Ir al enlace <svg class="icon-24" width="24"
                                                                    viewBox="0 0 24 24" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M15.8325 8.17463L10.109 13.9592L3.59944 9.88767C2.66675 9.30414 2.86077 7.88744 3.91572 7.57893L19.3712 3.05277C20.3373 2.76963 21.2326 3.67283 20.9456 4.642L16.3731 20.0868C16.0598 21.1432 14.6512 21.332 14.0732 20.3953L10.106 13.9602"
                                                                        stroke="currentColor" stroke-width="1.5"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                </svg>
                                                            </div>
                                                        </a>
                                                    </button>
                                                @endif
                                            </div>


                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                    @if ($posicionIcono == 'abajo')
                        <div class="posicion-icono"
                            style=" display: flex; justify-content: center; align-items: center;">
                            @if ($estadoWss)
                                @if ($tipoIcono == 'clasico')
                                    @if ($estadoIconoNeon == true)
                                        <a wire:click="clickRedes('whatsapp')" href="{{ $enlaceWss }}"
                                            target="_blank">
                                            <div
                                                style="margin-left:5%; font-size: 45px; color:{{ $tipoIconoColor }}; text-shadow: 0 0 10px {{ $colorIconoNeon }}, 0 0 20px {{ $colorIconoNeon }}, 0 0 30px {{ $colorIconoNeon }};">
                                                <i class="bi bi-whatsapp"></i>
                                            </div>
                                        </a>
                                    @else
                                        <a wire:click="clickRedes('whatsapp')" href="{{ $enlaceWss }}"
                                            target="_blank">
                                            <div
                                                style="margin-left:5%; font-size: 45px; color:{{ $tipoIconoColor }};">
                                                <i class="bi bi-whatsapp"></i>
                                            </div>
                                        </a>
                                    @endif
                                @else
                                    <a wire:click="clickRedes('whatsapp')" href="{{ $enlaceWss }}"
                                        target="_blank"><img style="height: 55px;" src="{{ asset($rutaWss) }}"
                                            alt=""></a>
                                @endif
                            @endif
                            @if ($estadoInsta)
                                @if ($tipoIcono == 'clasico')
                                    @if ($estadoIconoNeon == true)
                                        <a style="margin-left:5%;" href="{{ $enlaceInsta }}"
                                            wire:click="clickRedes('instagram')">
                                            <div
                                                style="margin-left:5%; font-size: 45px; color:{{ $tipoIconoColor }}; text-shadow: 0 0 10px {{ $colorIconoNeon }}, 0 0 20px {{ $colorIconoNeon }}, 0 0 30px {{ $colorIconoNeon }};">
                                                <i class="bi bi-instagram"></i>
                                            </div>
                                        </a>
                                    @else
                                        <a style="margin-left:5%;" href="{{ $enlaceInsta }}"
                                            wire:click="clickRedes('instagram')">
                                            <div
                                                style="margin-left:5%; font-size: 45px; color:{{ $tipoIconoColor }}">
                                                <i class="bi bi-instagram"></i>
                                            </div>
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ $enlaceInsta }}"><img style="height: 55px;"
                                            src="{{ asset($rutaInsta) }}" alt=""></a>
                                @endif
                            @endif
                            @if ($estadoTiktok)
                                @if ($tipoIcono == 'clasico')
                                    @if ($estadoIconoNeon == true)
                                        <a style="margin-left:5%;" href="{{ $enlaceTiktok }}"
                                            wire:click="clickRedes('tiktok')">
                                            <div
                                                style="margin-left:5%; font-size: 45px; color:{{ $tipoIconoColor }}; text-shadow: 0 0 10px {{ $colorIconoNeon }}, 0 0 20px {{ $colorIconoNeon }}, 0 0 30px {{ $colorIconoNeon }};">
                                                <i class="bi bi-tiktok"></i>
                                            </div>
                                        </a>
                                    @else
                                        <a style="margin-left:5%;" href="{{ $enlaceTiktok }}"
                                            wire:click="clickRedes('tiktok')">
                                            <div
                                                style="margin-left:5%; font-size: 45px; color:{{ $tipoIconoColor }}">
                                                <i class="bi bi-tiktok"></i>
                                            </div>
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ $enlaceTiktok }}"><img style="height: 55px;"
                                            src="{{ asset($rutaTiktok) }}" alt=""></a>
                                @endif
                            @endif
                            @if ($estadoFacebook)
                                @if ($tipoIcono == 'clasico')
                                    @if ($estadoIconoNeon == true)
                                        <a style="margin-left:5%;" href="{{ $enlaceFacebook }}"
                                            wire:click="clickRedes('facebook')">
                                            <div
                                                style="margin-left:5%; font-size: 45px; color:{{ $tipoIconoColor }}; text-shadow: 0 0 10px {{ $colorIconoNeon }}, 0 0 20px {{ $colorIconoNeon }}, 0 0 30px {{ $colorIconoNeon }};">
                                                <i class="bi bi-facebook"></i>
                                            </div>
                                        </a>
                                    @else
                                        <a style="margin-left:5%;" href="{{ $enlaceFacebook }}"
                                            wire:click="clickRedes('facebook')">
                                            <div
                                                style="margin-left:5%; font-size: 45px; color:{{ $tipoIconoColor }}">
                                                <i class="bi bi-facebook"></i>
                                            </div>
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ $enlaceFacebook }}"> <img style="height: 55px;"
                                            src="{{ asset($rutaFacebook) }}" alt=""></a>
                                @endif
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </main>
        <div class="boton-superior">
            @if (
                $misProductos &&
                    count($misProductos) >= 1 &&
                    $productosSeleccionados &&
                    count($productosSeleccionados) >= 1 &&
                    $estadoCarrito == true)
                <button style="background:{{ $colorBordeCategoria }}; padding:10px;"
                    wire:click="$set('openAreaProductos',true)" class="">

                    <div style=" display: flex; align-items: center; justify-content: center;">

                        <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M14.1213 11.2331H16.8891C17.3088 11.2331 17.6386 10.8861 17.6386 10.4677C17.6386 10.0391 17.3088 9.70236 16.8891 9.70236H14.1213C13.7016 9.70236 13.3719 10.0391 13.3719 10.4677C13.3719 10.8861 13.7016 11.2331 14.1213 11.2331ZM20.1766 5.92749C20.7861 5.92749 21.1858 6.1418 21.5855 6.61123C21.9852 7.08067 22.0551 7.7542 21.9652 8.36549L21.0159 15.06C20.8361 16.3469 19.7569 17.2949 18.4879 17.2949H7.58639C6.25742 17.2949 5.15828 16.255 5.04837 14.908L4.12908 3.7834L2.62026 3.51807C2.22057 3.44664 1.94079 3.04864 2.01073 2.64043C2.08068 2.22305 2.47038 1.94649 2.88006 2.00874L5.2632 2.3751C5.60293 2.43735 5.85274 2.72207 5.88272 3.06905L6.07257 5.35499C6.10254 5.68257 6.36234 5.92749 6.68209 5.92749H20.1766ZM7.42631 18.9079C6.58697 18.9079 5.9075 19.6018 5.9075 20.459C5.9075 21.3061 6.58697 22 7.42631 22C8.25567 22 8.93514 21.3061 8.93514 20.459C8.93514 19.6018 8.25567 18.9079 7.42631 18.9079ZM18.6676 18.9079C17.8282 18.9079 17.1487 19.6018 17.1487 20.459C17.1487 21.3061 17.8282 22 18.6676 22C19.4969 22 20.1764 21.3061 20.1764 20.459C20.1764 19.6018 19.4969 18.9079 18.6676 18.9079Z"
                                fill="currentColor"></path>
                        </svg>({{ count($productosSeleccionados) }})
                    </div>
                </button>
            @endif
        </div>
        <div class="boton-inferior" style="margin-top:25%;">


            <p style="font-family: 'Montserrat', serif; color:rgb(0, 35, 110);" class="">Creado con <a
                    href="https://bolivianbusinesscenter.com.bo">
                    Bolivian Business Center</a>
            <div style="display:flex; justify-content:center;">
                <img src="{{ asset('assets/images/bbc.png') }}" style="height: 16px;" alt="">
            </div>
            </p>
        </div>

        </body>
    @endif

    </html>
    <x-modal-compras wire:model.defer="openArea">
        <div class="flex flex-row justify-end px-1 py-1 text-right bg-dark">
            <label type="submit" class="mr-2 btn btn-light" wire:click="cancelar"
                style="color:white; margin:3%;">Cancelar</label>
        </div>
        @if ($producto)
            <div class="px-6 py-4">
                <div class="">
                    <img src="../storage/{{ $producto->imageProducto }}" alt="">

                </div>
                <br>
                <div class="mb-2 form-group">
                    <h1 style="color:white; font-size:24px;">{{ $producto->nombre }}</h1>
                    <p style="color:white;">{{ $producto->descripcion }}</p>
                </div>
                <div class="mb-2 form-group">
                    <p style="color:white;">Precio: {{ $producto->precio }}</p>
                </div>
            </div>
            <div class="flex flex-row justify-center px-1 py-1 text-right" style="background-color: #0000007c;">
                <button wire:click="agregarProducto({{ $producto->id }})" type="submit" class="boton-efecto3"
                    style="background-color: rgb(0, 189, 0);">
                    <div style="display: flex; align-items: center; justify-content: center;">
                        Agregar <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M14.1213 11.2331H16.8891C17.3088 11.2331 17.6386 10.8861 17.6386 10.4677C17.6386 10.0391 17.3088 9.70236 16.8891 9.70236H14.1213C13.7016 9.70236 13.3719 10.0391 13.3719 10.4677C13.3719 10.8861 13.7016 11.2331 14.1213 11.2331ZM20.1766 5.92749C20.7861 5.92749 21.1858 6.1418 21.5855 6.61123C21.9852 7.08067 22.0551 7.7542 21.9652 8.36549L21.0159 15.06C20.8361 16.3469 19.7569 17.2949 18.4879 17.2949H7.58639C6.25742 17.2949 5.15828 16.255 5.04837 14.908L4.12908 3.7834L2.62026 3.51807C2.22057 3.44664 1.94079 3.04864 2.01073 2.64043C2.08068 2.22305 2.47038 1.94649 2.88006 2.00874L5.2632 2.3751C5.60293 2.43735 5.85274 2.72207 5.88272 3.06905L6.07257 5.35499C6.10254 5.68257 6.36234 5.92749 6.68209 5.92749H20.1766ZM7.42631 18.9079C6.58697 18.9079 5.9075 19.6018 5.9075 20.459C5.9075 21.3061 6.58697 22 7.42631 22C8.25567 22 8.93514 21.3061 8.93514 20.459C8.93514 19.6018 8.25567 18.9079 7.42631 18.9079ZM18.6676 18.9079C17.8282 18.9079 17.1487 19.6018 17.1487 20.459C17.1487 21.3061 17.8282 22 18.6676 22C19.4969 22 20.1764 21.3061 20.1764 20.459C20.1764 19.6018 19.4969 18.9079 18.6676 18.9079Z"
                                fill="currentColor"></path>
                        </svg>
                    </div>
                </button>
            </div>
        @endif

    </x-modal-compras>

    <x-modal-compras wire:model.defer="openAreaProductos" style="background-color: #0000007c;">
        <div class="flex flex-row justify-end px-1 py-1 text-right bg-gray-100" style="background-color: #0000007c;">
            <label type="submit" class="mr-2 btn btn-light" wire:click="cancelar"
                style="color: white; margin:3%;">Cancelar</label>
        </div>
        @if (count($productosSeleccionados) > 0)

            @foreach ($productosSeleccionados as $item)
                <div class="flex flex-row justify-end px-1 py-1 text-right">
                    <button type="submit" style="background-color: rgb(216, 44, 31);" class="mr-2"
                        wire:click="eliminarProducto({{ $item['producto']['id'] }})">Eliminar</button>
                </div>
                <div class="px-6 py-4">
                    <div class="">
                        <img src="../storage/{{ $item['producto']['imageProducto'] }}" alt="">

                    </div>
                    <br>

                    <div class="mb-2 form-group">
                        <p style="color:white;">{{ $item['producto']['nombre'] }}</p>
                        <p style="color:white;">{{ $item['producto']['descripcion'] }}</p>
                    </div>
                    <div class="mb-2 form-group">
                        <p style="color:white;">Precio: {{ $item['producto']['precio'] }}</p>
                        <p style="color:white;">Cantidad: {{ $item['cantidad'] }}</p>
                    </div>
                </div>
            @endforeach
            <div style="background-color: #0000007c;"
                class="flex flex-row justify-center px-1 py-1 text-right bg-gray-100">
                <button wire:click="enviarcompra" type="submit" class="btn btn-success boton-efecto3"
                    style="background-color: rgb(0, 189, 0);">
                    <div style="display: flex; align-items: center; justify-content: center;">Comprar <svg
                            class="icon-32" width="32" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M14.1213 11.2331H16.8891C17.3088 11.2331 17.6386 10.8861 17.6386 10.4677C17.6386 10.0391 17.3088 9.70236 16.8891 9.70236H14.1213C13.7016 9.70236 13.3719 10.0391 13.3719 10.4677C13.3719 10.8861 13.7016 11.2331 14.1213 11.2331ZM20.1766 5.92749C20.7861 5.92749 21.1858 6.1418 21.5855 6.61123C21.9852 7.08067 22.0551 7.7542 21.9652 8.36549L21.0159 15.06C20.8361 16.3469 19.7569 17.2949 18.4879 17.2949H7.58639C6.25742 17.2949 5.15828 16.255 5.04837 14.908L4.12908 3.7834L2.62026 3.51807C2.22057 3.44664 1.94079 3.04864 2.01073 2.64043C2.08068 2.22305 2.47038 1.94649 2.88006 2.00874L5.2632 2.3751C5.60293 2.43735 5.85274 2.72207 5.88272 3.06905L6.07257 5.35499C6.10254 5.68257 6.36234 5.92749 6.68209 5.92749H20.1766ZM7.42631 18.9079C6.58697 18.9079 5.9075 19.6018 5.9075 20.459C5.9075 21.3061 6.58697 22 7.42631 22C8.25567 22 8.93514 21.3061 8.93514 20.459C8.93514 19.6018 8.25567 18.9079 7.42631 18.9079ZM18.6676 18.9079C17.8282 18.9079 17.1487 19.6018 17.1487 20.459C17.1487 21.3061 17.8282 22 18.6676 22C19.4969 22 20.1764 21.3061 20.1764 20.459C20.1764 19.6018 19.4969 18.9079 18.6676 18.9079Z"
                                fill="currentColor"></path>
                        </svg>
                    </div>
                </button>
            </div>
        @else
            <div style="margin:5%;">
                No hay productos seleccionados!
            </div>

        @endif

    </x-modal-compras>
</div>

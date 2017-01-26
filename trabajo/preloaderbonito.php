onready:
showPreloader();

<script type="text/javascript">
	function isCanvasSupported() {
        var elem = document.createElement('canvas');
        return !!(elem.getContext && elem.getContext('2d'));
    }

    function showPreloader() {
        if (isCanvasSupported()) {
            document.getElementById('preloader').style.display = 'block';

            // load a random tip
            var tips = [
                'Para un alta presición, usted puede mover los elementos en su diseño con las flechas del teclado.','Agarre y Suelte las imagenes desde su computador para añadirlas rápidamente al diseño.','Presione \'Shift+S\' en su teclado para guardar su diseño.','Use "Texto Artístico" para crear textos con curvas y textos con efectos 3D.','Use "Añadir Imagenes de Archivo"  para acceder a millones de imagenes de archivo gratuitas y premium.','Busque en nuestra biblioteca de planillas para encontrar ese diseño que usted quiere personalizar.','Use Archivo > Duplicar para crear una copia del diseño que usted está editando.','Use "Añadir Imagen Prediseñada" para acceder a millones de ilustraciones y caricaturas de acceso gratuito.','Edite su diseño con los demás; invite a colaboradores a través de la opción de Compartir.'            ];
            document.getElementById('preloader-tip').innerHTML = tips[Math.floor(Math.random() * tips.length)];
        }
    }

</script>
html 
<div id="preloader">
    <div class="loader-c1">
        <div class="box-loading -white"></div>
    </div>

    <p class="tip">
        <strong>Tip:</strong> <span id="preloader-tip"></span>
    </p>

    <div class="logo">
        <img src="http://www.postermywall.com/assets/images/logo-postermaker.png" alt=""/>
    </div>
</div>

css
#notsupported {
                position: relative;
                text-align: center;
                top: 40%;
            }

            #preloader {
                background: #3FBCE7;
                color: #fff;
                display: none;
                height: 100%;
                text-align: center;
                width: 100%;
            }

            #preloader .logo {
                bottom: 0;
                position: fixed;
                text-align: center;
                width: 100%;
            }

            #preloader img {
                height: 80px;
                width: 244px;
            }

            #preloader .tip {
                font-family: Helvetica, Arial, sans-serif;
                margin-top: 85px;
                padding: 0 16px;
                position: absolute;
                top: 40%;
                text-align: center;
                width: 100%;
            }

            #preloader strong {
                font-weight: bold;
            }

            #preloader .loader-c1 {
                position: absolute;
                top: 40%;
                width: 100%;
            }

            @keyframes bouncing-box {
                17% {
                    border-bottom-right-radius: 3px;
                }
                25% {
                    transform: translateY(9px) rotate(22.5deg);
                }
                50% {
                    transform: translateY(18px) scale(1, 0.9) rotate(45deg);
                    border-bottom-right-radius: 39px;
                }
                75% {
                    transform: translateY(9px) rotate(67.5deg);
                }
                100% {
                    transform: translateY(0) rotate(90deg);
                }
            }

            @-webkit-keyframes bouncing-box {
                17% {
                    border-bottom-right-radius: 3px;
                }
                25% {
                    -webkit-transform: translateY(9px) rotate(22.5deg);
                }
                50% {
                    -webkit-transform: translateY(18px) scale(1, 0.9) rotate(45deg);
                    border-bottom-right-radius: 39px;
                }
                75% {
                    -webkit-transform: translateY(9px) rotate(67.5deg);
                }
                100% {
                    -webkit-transform: translateY(0) rotate(90deg);
                }
            }

            @keyframes shadow {
                0%,
                100% {
                    transform: scale(1, 1);
                }
                50% {
                    transform: scale(1.2, 1);
                }
            }

            @-webkit-keyframes shadow {
                0%,
                100% {
                    -webkit-transform: scale(1, 1);
                }
                50% {
                    -webkit-transform: scale(1.2, 1);
                }
            }

            .box-loading {
                width: 49px;
                height: 75px;
                margin: auto;
                position: relative;
                left: 0;
                right: 0;
                top: 0;
                bottom: 0;
            }

            .box-loading:before {
                content: '';
                width: 49px;
                height: 5px;
                background: rgb(0, 0, 0);
                opacity: 0.1;
                position: absolute;
                top: 58px;
                left: 0;
                border-radius: 50%;
                animation: shadow 0.58s linear infinite;
                -webkit-animation: shadow 0.58s linear infinite;
            }

            .box-loading:after {
                content: '';
                width: 49px;
                height: 49px;
                background: rgb(63, 189, 231);
                position: absolute;
                top: 0;
                left: 0;
                border-radius: 3px;
                animation: bouncing-box 0.58s linear infinite;
                -webkit-animation: bouncing-box 0.58s linear infinite;
            }

            .box-loading.-white:after {
                background: #fff;
            } 

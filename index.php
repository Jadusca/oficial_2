<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Repositorio del Instituto Tecnológico de Mérida</title>
    <link rel="shortcut icon" href="Imagenes/Logo_ITM/Logo_ITM.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="estilosmovil.css">
    <script src="https://kit.fontawesome.com/1b0d4e5620.js" crossorigin="anonymous"></script>
    <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
    <script type="text/javascript" src="jquery.tinycarousel.js"></script>
    <script src="funciones.js"></script>
    <script src="responsiveslides.min.js"></script>
    <script src="wow.min.js"></script>
    <script src="fancybox/jquery.fancybox.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="fancybox/jquery.fancybox.css">
    <link rel="stylesheet" href="animate.css/animate.css" />
    <link rel="stylesheet" href="fancybox.css" />
    <script src="fancybox.js"></script>
</head>

<body>
    <?php
    include "registrar_visita.php";
    include 'headerBusqueda.php';
    include 'conexion.php';
    ?>
    <div id="subir" class="flecha">
        <i class="fa-solid fa-angle-up"></i>
    </div>
    <section class="contenidoslider ancho">
        <ul class="rslides">
            <li><img src="Imagenes/Slider/slide1.jpg" alt="">
                <div class="caption">
                    <h1>Centro de Información <br> "Antonio Mediz Bolio"</h1>
                </div>
            </li>
            <li><img src="Imagenes/Slider/slide2.jpg" alt="">
                <div class="caption">
                    <h1>Centro de Información <br> "Antonio Mediz Bolio"</h1>
                </div>
            </li>
            <li><img src="Imagenes/Slider/slide3.jpg" alt="">
                <div class="caption">
                    <h1>Centro de Información <br> "Antonio Mediz Bolio"</h1>
                </div>
            </li>
            <li><img src="Imagenes/Slider/slide4.jpg" alt="">
                <div class="caption">
                    <h1>Centro de Información <br> "Antonio Mediz Bolio"</h1>
                </div>
            </li>
            <li><img src="Imagenes/Slider/slide5.jpg" alt="">
                <div class="caption">
                    <h1>Centro de Información <br> "Antonio Mediz Bolio"</h1>
                </div>
            </li>
        </ul>
        <p>Bienvenido al Repositorio Institucional de Acceso Abierto del Instituto Tecnológico de Mérida,
            que almacena y organiza la documentación y producción de índole científica y académica con el
            propósito de preservarla en formato digital y facilitar su acceso y visibilidad global.</p>
    </section>
    <section class="seccioncontenido ancho">
        <h1 class="titulos">CONTENIDO</h1>
        <hr class="hrs">
        <br><br>
        <div class="contrecuadros">
            <div class="recuadro">
                <i class="fa-solid fa-laptop-file"></i>
                <h2>Licenciaturas</h2>
                <p>En esta sección se encuentra la producción académica generada por estudiantes de nivel licenciatura del Instituto Tecnológico de Mérida. Incluye trabajos recepcionales, tesis, memorias y proyectos finales desarrollados como parte del proceso de titulación. Su objetivo es preservar, difundir y dar visibilidad al conocimiento generado durante la formación profesional.</p>
                <a class="hvr-sweep-to-right" href="licenciaturas.php">Acceder</a>
            </div>
            <div class="recuadro">
                <i class="fa-solid fa-book"></i>
                <h2>Posgrados</h2>
                <p>Esta área alberga documentos académicos pertenecientes a programas de posgrado (maestrías y doctorados). Contiene tesis, investigaciones aplicadas y otros trabajos científicos realizados por estudiantes de estudios avanzados. Estos documentos reflejan el alto nivel de especialización y aportes significativos a distintas áreas del conocimiento.</p>
                <a class="hvr-sweep-to-right" href="posgrados.php">Acceder</a>
            </div>
            <div class="recuadro">
                <i class="fa-solid fa-book-open-reader"></i>
                <h2>Sabáticos</h2>
                <p>Aquí se recopilan los informes y productos derivados de los periodos sabáticos otorgados a profesores e investigadores del Instituto. Estos documentos reflejan investigaciones, desarrollos académicos y proyectos realizados durante su tiempo de sabático, contribuyendo al fortalecimiento de la docencia, la investigación y la vinculación institucional.</p>
                <a class="hvr-sweep-to-right" href="sabaticos.php">Acceder</a>
            </div>
        </div>
    </section>

    <section class="galeria">
        <h1>GALERÍA</h1>
        <hr>
        <section class="galeria_grid">
            <a class="foto1" data-fancybox="gallery" data-src="Imagenes/Galería/gallery 1.jpg"
                data-caption="FOTO 1 GALERIA">
                <figure>
                    <img src="imagenes/Galería/gallery 1.jpg" alt="" />
                </figure>
            </a>
            <a class="foto2" data-fancybox="gallery" data-src="Imagenes/Galería/gallery 2.jpg"
                data-caption="FOTO 2 GALERIA">
                <figure>
                    <img src="imagenes/Galería/gallery 2.jpg" alt="" />
                </figure>
            </a>
            <a class="foto3" data-fancybox="gallery" data-src="Imagenes/Galería/gallery 3.jpg"
                data-caption="FOTO 3 GALERIA">
                <figure>
                    <img src="imagenes/Galería/gallery 3.jpg" alt="" />
                </figure>
            </a>
            <a class="foto4" data-fancybox="gallery" data-src="Imagenes/Galería/gallery 4.jpg"
                data-caption="FOTO 4 GALERIA">
                <figure>
                    <img src="imagenes/Galería/gallery 4.jpg" alt="" />
                </figure>
            </a>
            <a class="foto5" data-fancybox="gallery" data-src="Imagenes/Galería/gallery 5.jpg"
                data-caption="FOTO 5 GALERIA">
                <figure>
                    <img src="imagenes/Galería/gallery 5.jpg" alt="" />
                </figure>
            </a>
            <a class="foto6" data-fancybox="gallery" data-src="Imagenes/Galería/gallery 6.jpg"
                data-caption="FOTO 6 GALERIA">
                <figure>
                    <img src="imagenes/Galería/gallery 6.jpg" alt="" />
                </figure>
            </a>
        </section>
    </section>

    <br><br>

    <?php
    include 'footer-index.php';
    ?>

    <script>
        Fancybox.bind('[data-fancybox="gallery"]', {});
    </script>

</body>

</html>
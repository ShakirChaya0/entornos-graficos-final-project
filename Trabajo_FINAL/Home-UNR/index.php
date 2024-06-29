<?php
session_start();
$_SESSION["tipoUsuario"] = "UNR";
?>

<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../Imagenes-Videos/bolsas-de-compra.png" type="image/png">
  <title>Rosario Shopping Center</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="../Barra_Navegacion/Bar-style.css">
  <link rel="stylesheet" href="../Pie_De_Pagina/footer.css">
</head>
<body>
  <?php 
    include("../Barra_Navegacion/Nav-bar.php");
  ?>
  <section id="Home" class="section-1">
    <video autoplay loop muted class="video" src="../Imagenes-Videos/Video-principal.mp4"></video>
    <div class="video-opacity">
      <div class="video-title">
        <h1 class="title">Rosario Shopping Center</h1>
        <p class="shopping-description p-delete">Bienvenidos a Rosario Shopping Center.</p>
        <p class="shopping-description">Moda, cine, gastronomía y mucho más! Descubrí el corazón de Rosario.</p>
        <div class="contenedor-flecha">
          <a href="#locales" class="enlace-flecha">
            <p class="flecha">
              <svg data-bbox="20 59.5 160 81.001" viewBox="0 0 200 200" height="100" width="100" xmlns="http://www.w3.org/2000/svg" data-type="shape">
                <g>
                  <!-- Añadimos el círculo -->
                  <circle cx="100" cy="100" r="75" stroke="white" stroke-width="5" fill="none" />
                  <g transform="rotate(180 70 70) scale(0.4)">
                    <path d="M177.687 128.054L105.35 61.402a7.205 7.205 0 0 0-5.35-1.886 7.198 7.198 0 0 0-5.349 1.886l-72.338 66.652a7.165 7.165 0 0 0-.407 10.138 7.172 7.172 0 0 0 5.283 2.309c1.743 0 3.49-.629 4.872-1.902L100 75.999l67.939 62.598a7.197 7.197 0 0 0 10.155-.406 7.163 7.163 0 0 0-.407-10.137z" fill="white"></path>
                  </g>
                </g>
              </svg>
            </p>
          </a>
        </div>
      </div>
    </div>
  </section>
  
  <div id="locales"></div>
  <section class="section-2">
    <div class="b1">
      <h2 class="subtitle">Locales</h2>
      <h3 class="locales">NUESTROS LOCALES</h3>
    </div>
    <div id="carouselExample" class="carousel carousel-dark slide d-sm-block contenedor-locales">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <div class="cards-wrapper">
            <div class="card">
              <div class="image-wrapper">
                <img src="../Imagenes-Videos/Nike.jpg" alt="Imagen de Nike">
              </div>
              <div class="card-body">
                <h5 class="card-title">Nike</h5>
                <p class="card-text">Encuentra la mejor ropa y calzado deportivo en la planta baja, al lado de la entrada principal.</p>
              </div>
            </div>
            <div class="card">
              <div class="image-wrapper">
                <img src="../Imagenes-Videos/zara.jpg" alt="Imagen de Zara">
              </div>
              <div class="card-body">
                <h5 class="card-title">Zara</h5>
                <p class="card-text">Descubre las últimas tendencias de moda en el primer piso, justo frente a la escalera mecánica.</p>
              </div>
            </div>
            <div class="card">
              <div class="image-wrapper">
                <img src="../Imagenes-Videos/Ripcurl.jpg" alt="Imagen Ripcurl">
              </div>
              <div class="card-body">
                <h5 class="card-title">Ripcurl</h5>
                <p class="card-text">Todo lo que necesitas para surf y playa en la planta baja, cerca de la zona de entretenimiento.</p>
              </div>
            </div>
          </div>
        </div>
        <div class="carousel-item">
          <div class="cards-wrapper">
            <div class="card">
              <div class="image-wrapper">
                <img src="../Imagenes-Videos/McDonalds.jpg" alt="Sucursal Mc Donald's">
              </div>
              <div class="card-body">
                <h5 class="card-title">Mc Donald's</h5>
                <p class="card-text">Disfruta de tus hamburguesas favoritas en el nivel superior, junto a la entrada del estacionamiento.</p>
              </div>
            </div>
            <div class="card">
              <div class="image-wrapper">
                <img src="../Imagenes-Videos/Starbucks.jpg" alt="Sucursal Starbucks">
              </div>
              <div class="card-body">
                <h5 class="card-title">Starbucks</h5>
                <p class="card-text">Disfruta de un café premium en el primer piso, justo al lado de la tienda de libros.</p>
              </div>
            </div>
            <div class="card">
              <div class="image-wrapper">
                <img src="../Imagenes-Videos/Mostaza.jpg" alt="Sucursal Mostaza">
              </div>
              <div class="card-body">
                <h5 class="card-title">Mostaza</h5>
                <p class="card-text">Saborea nuestras hamburguesas y papas fritas en el primer piso, cerca de la plaza central.</p>
              </div>
            </div>
          </div>
        </div>
        <div class="carousel-item">
          <div class="cards-wrapper">
            <div class="card">
              <div class="image-wrapper">
                <img src="../Imagenes-Videos/Showcase.jpg" alt="Cine Showcase">
              </div>
              <div class="card-body">
                <h5 class="card-title">Showcase</h5>
                <p class="card-text">Disfruta de los últimos estrenos de cine en el tercer piso, junto a la zona de restaurantes.</p>
              </div>
            </div>
            <div class="card">
              <div class="image-wrapper">
                <img src="../Imagenes-Videos/Juleriaque.jpg" alt="Sucursal Juleriaque">
              </div>
              <div class="card-body">
                <h5 class="card-title">Juleriaque</h5>
                <p class="card-text">Encuentra perfumes y cosméticos exclusivos en el primer piso, junto a la fuente central.</p>
              </div>
            </div>
            <div class="card">
              <div class="image-wrapper">
                <img src="../Imagenes-Videos/Natura.jpg" alt="Sucursal Natura">
              </div>
              <div class="card-body">
                <h5 class="card-title">Natura</h5>
                <p class="card-text">Productos naturales y sustentables para el cuidado personal en el segundo piso, al lado de la librería.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </section>
  
  <section class="section-3" id="About us">
    <div class="b1">
      <h2 class="subtitle">EL SHOPPING</h2>
      <img class="image-wrapper shopping-image" src="../Imagenes-Videos/Imagen-Shopping.jpg" alt="">
      <p class="informacion">
        Rosario Shopping Center se erige en la vibrante ciudad de Rosario. Nuestro centro comercial, situado cerca del hermoso Parque Scalabrini Ortiz, combina lo mejor de la historia y la modernidad de la ciudad, ofreciendo una experiencia de compras y entretenimiento única.
        Con más de 70 marcas de primera línea, Rosario Shopping Center es tu destino ideal para indumentaria femenina y masculina, accesorios, marroquinería, decoración y mucho más. Nos enorgullece ofrecer una gran variedad de opciones que satisfacen todos los gustos y necesidades, garantizando una experiencia de compra inigualable tanto para los residentes locales como para los visitantes.
        Ven y descubre todo lo que Rosario Shopping Center tiene para ofrecerte. ¡Te esperamos para vivir una experiencia única en compras y entretenimiento!
      </p>
    </div>
  </section>
  
<?php 
  include("../Pie_De_Pagina/footer.php");
?>

</body>

</html>
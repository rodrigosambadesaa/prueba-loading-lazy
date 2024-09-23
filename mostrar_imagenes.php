<?php
// Obtener parámetros y validar
$num_imagenes = isset($_GET['num_imagenes']) ? intval($_GET['num_imagenes']) : 0;
$lazy = isset($_GET['lazy']) ? boolval($_GET['lazy']) : false;

if ($num_imagenes <= 0) {
    echo "Número de imágenes no válido.";
    exit();
}

// Generar URLs de imágenes grandes (usaremos un servicio placeholder)
function generarURLImagen($anchura, $altura) {
    // Usaremos picsum.photos para generar imágenes grandes
    return "https://picsum.photos/$anchura/$altura.jpg";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Imágenes <?php echo $lazy ? 'con' : 'sin'; ?> loading="lazy"</title>
    <style>
        body {
            background-color: #e0f0ff;
            color: #003366;
            margin: 0;
            padding: 0;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            grid-gap: 10px;
            padding: 10px;
        }
        .grid img {
            width: 100%;
            height: auto;
        }
        header {
            background-color: #007acc;
            color: white;
            padding: 10px;
            text-align: center;
        }
        a {
            color: white;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <h1>Mostrando <?php echo $num_imagenes; ?> imágenes <?php echo $lazy ? 'con' : 'sin'; ?> loading="lazy"</h1>
        <p><a href="index.php">Volver al formulario</a></p>
    </header>
    <div class="grid">
        <?php
        for ($i = 0; $i < $num_imagenes; $i++) {
            $anchura = rand(1920, 3840); // Ancho entre 1920 y 3840 píxeles
            $altura = rand(1080, 2160);  // Alto entre 1080 y 2160 píxeles
            $url_imagen = generarURLImagen($anchura, $altura);
            echo '<img src="' . $url_imagen . '" ' . ($lazy ? 'loading="lazy"' : '') . ' alt="Imagen ' . ($i + 1) . '">';
        }
        ?>
    </div>
</body>
</html>

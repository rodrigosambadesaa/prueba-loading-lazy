<?php
// Validación en PHP
$error = '';
$num_imagenes = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['num_imagenes'])) {
        $num_imagenes = $_POST['num_imagenes'];
        // Limpiar entrada y validar que es un entero positivo y no mayor que 10000
        if (filter_var($num_imagenes, FILTER_VALIDATE_INT, array("options" => array("min_range" => 1, "max_range" => 10000)))) {
            // Verificar si la opción lazy está seleccionada
            if (isset($_POST['lazy'])) {
                header("Location: mostrar_imagenes.php?lazy=1&num_imagenes=$num_imagenes");
            } else {
                // Limitar a 600 si no se selecciona lazy
                if ($num_imagenes > 600) {
                    $num_imagenes = 600;
                    $error = "Se ha limitado el número de imágenes a 600 por razones de rendimiento del servidor.";
                }
                header("Location: mostrar_imagenes.php?lazy=0&num_imagenes=$num_imagenes");
            }
            exit();
        } else {
            $error = "Por favor, introduce un número entero positivo no mayor que 10000.";
        }
    } else {
        $error = "Por favor, introduce el número de imágenes.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Formulario de Imágenes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e0f0ff;
            color: #003366;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        form {
            margin-top: 50px;
        }

        input[type="number"] {
            padding: 5px;
            margin-right: 10px;
        }

        .error {
            color: red;
        }

        button {
            padding: 5px 10px;
            background-color: #007acc;
            color: white;
            border: none;
        }
    </style>
    <script>
        // Validación en JavaScript
        function validarFormulario() {
            var numImagenes = document.forms["formImagenes"]["num_imagenes"].value;
            if (numImagenes == "" || isNaN(numImagenes) || numImagenes <= 0 || !Number.isInteger(parseFloat(numImagenes))) {
                alert("Por favor, introduce un número entero positivo.");
                return false;
            }
            return true;
        }
    </script>
</head>

<body>
    <h1>Selecciona el número de imágenes</h1>
    <form name="formImagenes" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
        onsubmit="return validarFormulario();">
        <input type="number" name="num_imagenes" value="<?php echo htmlspecialchars($num_imagenes); ?>" min="1"
            max="10000" required>
        <label>
            <input type="checkbox" name="lazy" checked> Usar loading="lazy"
        </label>
        <button type="submit">Mostrar Imágenes</button>
    </form>
    <?php if ($error != '') {
        echo "<p class='error'>$error</p>";
    } ?>
</body>

</html>
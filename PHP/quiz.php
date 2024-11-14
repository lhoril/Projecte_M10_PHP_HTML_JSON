<?php
session_start();

// Verificar si se ha recibido un archivo seleccionado
if (isset($_POST['selected_file'])) {
    $_SESSION['uploaded_file_name'] = $_POST['selected_file'];
} elseif (!isset($_SESSION['uploaded_file_name'])) {
    header("Location: seleccionar_archivo.php");
    exit;
}

// Ruta completa del archivo JSON
$jsonFilePath = '../uploads/' . $_SESSION['uploaded_file_name'];

// Leer el archivo JSON
$jsonContent = file_get_contents($jsonFilePath);
$data = json_decode($jsonContent, true);

// Validar que el formato del JSON sea correcto
if (json_last_error() !== JSON_ERROR_NONE || !isset($data['preguntas_respuestas']) || !isset($data['Quantitat_Preguntes'][0]['Quantitat'])) {
    header("Location: ../HTML/error_json.html");
    exit;
}

// Inicializar variables para el cuestionario
$preguntas = $data['preguntas_respuestas'];
$totalPreguntas = (int) $data['Quantitat_Preguntes'][0]['Quantitat'];
$preguntaActual = isset($_SESSION['pregunta_actual']) ? $_SESSION['pregunta_actual'] : -1;
$respuestasCorrectas = isset($_SESSION['respuestas_correctas']) ? $_SESSION['respuestas_correctas'] : 0;
$temps = (int) $preguntas[$preguntaActual+1]['Temps'];

$respuestaSeleccionada = isset($_POST['respuesta']) ? $_POST['respuesta'] : null;
// Manejo de respuesta del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $respuestaSeleccionada != null) {
    $esCorrecta = false;

    // Verificar si la respuesta seleccionada es correcta
    if (is_array($respuestaSeleccionada)) { // Para preguntas de tipo checkbox
        $correctas = 0;
        foreach ($preguntas[$preguntaActual]['respuestas'] as $respuesta) {
            if (in_array($respuesta['respuesta'], $respuestaSeleccionada) && $respuesta['correcta'] === true) {
                $correctas++;
            }
        }
        $esCorrecta = ($correctas === count(array_filter($preguntas[$preguntaActual]['respuestas'], function($resp) {
            return $resp['correcta'];
        })));
    } else { // Para preguntas de tipo radio
        foreach ($preguntas[$preguntaActual]['respuestas'] as $respuesta) {
            if ($respuesta['respuesta'] === $respuestaSeleccionada && $respuesta['correcta'] === true) {
                $esCorrecta = true;
                break;
            }
        }
    }

    // Actualizar el conteo de respuestas correctas
    if ($esCorrecta) {
        $respuestasCorrectas++;
        $_SESSION['respuestas_correctas'] = $respuestasCorrectas;
        header("Location: ../HTML/correcta.html");
        exit;
    } else {
        header("Location: ../HTML/incorrecta.html");
        exit;
    }
}

// Incrementar el índice de la pregunta actual
$preguntaActual++;
$_SESSION['pregunta_actual'] = $preguntaActual;

// Comprobar si hay más preguntas
if ($preguntaActual >= $totalPreguntas) {
    header("Location: final.php");
    exit;
}

// Mostrar la pregunta actual
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuestionario</title>
    <link rel="stylesheet" href="../Estils/CSS.css">
</head>
<body>
    <div class="container">
        <div class="centerpreguntesBox">
            <form method="POST" action="quiz.php" id="quizForm">
                <h2>Pregunta <?php echo $preguntaActual + 1; ?> de <?php echo $totalPreguntas; ?></h2>
                <label for="pregunta"><?php echo $preguntas[$preguntaActual]['pregunta']; ?></label><br><br>

                <?php foreach ($preguntas[$preguntaActual]['respuestas'] as $index => $respuesta): ?>
                    <?php if ($preguntas[$preguntaActual]['Tipus'] === 'radio'): ?>
                        <input type="radio" id="respuesta<?php echo $index; ?>" name="respuesta" value="<?php echo htmlspecialchars($respuesta['respuesta']); ?>">
                        <label for="respuesta<?php echo $index; ?>"><?php echo htmlspecialchars($respuesta['respuesta']); ?></label><br>
                    <?php elseif ($preguntas[$preguntaActual]['Tipus'] === 'checkbox'): ?>
                        <input type="checkbox" id="respuesta<?php echo $index; ?>" name="respuesta[]" value="<?php echo htmlspecialchars($respuesta['respuesta']); ?>">
                        <label for="respuesta<?php echo $index; ?>"><?php echo htmlspecialchars($respuesta['respuesta']); ?></label><br>
                    <?php endif; ?>
                <?php endforeach; ?><br>

                <input type="submit" value="Enviar respuesta">
            </form>
        </div>
        <div class="extremoDerecho">
            <div class="circle">
                <div class="time" id="Temps"><?php echo $temps; ?></div> <!-- Tiempo inicial de ejemplo -->
            </div>
        </div>
    </div>
    <script>
        // Inicializamos el tiempo en 0 segundos
        let tiempo = 0;
        let tiempoTotal = <?php echo $temps; ?>;
        let tiempoRestante = <?php echo $temps; ?>;

        // Función para incrementar el tiempo y mostrarlo en consola
        function temporizador() {
        if(tiempoRestante > 0){
            tiempo++;
            tiempoRestante = tiempoTotal - tiempo;
            document.getElementById("Temps").innerHTML = tiempoRestante;
        }
        else document.getElementById("quizForm").submit();
        }

        // Usamos setInterval para que la función se ejecute cada segundo (1000 ms)
        setInterval(temporizador, 1000);
    </script>
</body>
</html>
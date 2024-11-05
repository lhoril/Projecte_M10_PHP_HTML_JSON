<?php
session_start();

// Verificar que se ha completado el cuestionario
if (!isset($_SESSION['respuestas_correctas']) || !isset($_SESSION['name']) || !isset($_SESSION['pregunta_actual'])) {
    // Si falta información, redirigir a index.php
    header("Location: index.php");
    exit;
}

// Obtener los datos de la sesión
$respuestasCorrectas = $_SESSION['respuestas_correctas'];
$totalPreguntas = $_SESSION['pregunta_actual'];
$nombreUsuario = $_SESSION['name'];

// Limpiar la sesión
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado Final</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }
        .result-container {
            text-align: center;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        h1 {
            font-size: 2rem;
            color: #333;
        }
        p {
            font-size: 1.25rem;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="result-container">
        <h1>¡Gracias por completar el cuestionario, <?php echo htmlspecialchars($nombreUsuario); ?>!</h1>
        <p>Tu puntuación final es: <?php echo $respuestasCorrectas; ?> de <?php echo $totalPreguntas; ?></p>
        <a href="index.php">Volver al inicio</a>
    </div>
</body>
</html>
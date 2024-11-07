<?php
session_start();

// Verificar si se ha completado el cuestionario
if (!isset($_SESSION['respuestas_correctas'])) {
    header("Location: quiz.php");
    exit;
}

// Total de preguntas y respuestas correctas
$totalPreguntas = $_SESSION['pregunta_actual']; // Asegúrate de haber guardado este valor en la sesión
$respuestasCorrectas = $_SESSION['respuestas_correctas'];

// Guardar resultados en un archivo CSV
$file_Name = $_SESSION['uploaded_file_name'];
$nombreArchivo = '../CSV/resultados_'.$file_Name.'.csv';
$nombre_user = $_SESSION['name'];

// Guardar el path del arxiu a la array $_SESSION
$_SESSION['path_file'] = $nombreArchivo;

// Datos a guardar (puedes modificar esto según lo que quieras guardar)
$data = [
    'Nombre_Usuario' => $nombre_user, // Cambia esto a un nombre real o a algo dinámico
    'Total_Preguntas' => $totalPreguntas,
    'Respuestas_Correctas' => $respuestasCorrectas,
    'Fecha' => date('Y-m-d H:i:s') // Guardar la fecha y hora
];

// Abrir el archivo en modo append
$file = fopen($nombreArchivo, 'a');

// Si es la primera vez, escribir la cabecera
if (filesize($nombreArchivo) === 0) {
    fputcsv($file, array_keys($data)); // Cabecera
}

// Escribir los datos
fputcsv($file, $data);
fclose($file);

// Mostrar resultados finales al usuario
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
        <h1>¡Gracias por completar el cuestionario, <?php echo htmlspecialchars($nombre_user); ?>!</h1>
        <p>Tu puntuación final es: <?php echo $respuestasCorrectas; ?> de <?php echo $totalPreguntas; ?></p>
        <a href="../index2.php">Volver al inicio</a>
        <a href="result.php">Tabla de resultados</a>
    </div>
</body>
</html>
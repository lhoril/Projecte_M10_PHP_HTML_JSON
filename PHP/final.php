<?php
session_start();

// Verificar que la sesión esté configurada y que el usuario haya completado el cuestionario
if (!isset($_SESSION['name']) || !isset($_SESSION['score']) || !isset($_SESSION['question_index'])) {
    // Si alguna de las variables de sesión falta, redirigir al inicio
    header("Location: index.php");
    exit;
}

$name = $_SESSION['name'];
$score = $_SESSION['score'];
$totalQuestions = $_SESSION['question_index'];

// Limpiar sesión para un nuevo inicio después de mostrar el puntaje
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado Final</title>
</head>
<body>
    <h1>¡Gracias por completar el quiz, <?= htmlspecialchars($name) ?>!</h1>
    <p>Tu puntaje final es: <?= $score ?> de <?= $totalQuestions ?></p>
    <a href="index.php">Volver al inicio</a>
</body>
</html>
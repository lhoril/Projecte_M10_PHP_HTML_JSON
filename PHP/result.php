<?php
session_start();
$message = $_SESSION['message'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado</title>
</head>
<body>
    <h2><?= $message ?></h2>
    <a href="quiz.php">Siguiente Pregunta</a>
</body>
</html>
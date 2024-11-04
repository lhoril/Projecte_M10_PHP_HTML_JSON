<!-- index.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio del Quiz</title>
</head>
<body>
    <h1>Bienvenido al Quiz</h1>
    <form action="quiz.php" method="POST">
        <label for="name">Ingresa tu nombre:</label>
        <input type="text" name="name" id="name" required>
        <button type="submit">Iniciar Quiz</button>
    </form>
</body>
</html>
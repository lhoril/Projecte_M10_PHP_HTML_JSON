<?php
session_start();

// Ruta de la carpeta donde se suben los archivos JSON
$uploadsDir = '../uploads';

// Obtener todos los archivos JSON en el directorio
$files = array_filter(scandir($uploadsDir), function($file) use ($uploadsDir) {
    return is_file("$uploadsDir/$file") && pathinfo($file, PATHINFO_EXTENSION) === 'json';
});

// Si no hay archivos JSON, mostrar un mensaje de error
if (empty($files)) {
    echo "<p>No hay archivos JSON disponibles en la carpeta de uploads.</p>";
    echo "<a href='index.php'>Volver a la página principal</a>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Archivo</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
        }
        .file-selection-container {
            text-align: center;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 24px;
            color: #333;
        }
        select, button {
            padding: 10px;
            margin: 10px 0;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="file-selection-container">
        <h1>Selecciona un archivo JSON para el cuestionario</h1>
        <form method="POST" action="quiz.php">
            <label for="file">Archivos disponibles:</label><br>
            <select name="selected_file" id="file" required>
                <?php foreach ($files as $file): ?>
                    <option value="<?php echo htmlspecialchars($file); ?>"><?php echo htmlspecialchars($file); ?></option>
                <?php endforeach; ?>
            </select><br>
            <button type="submit">Comenzar cuestionario</button>
        </form>
    </div>
</body>
</html>
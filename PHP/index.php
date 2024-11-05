<?php
session_start();

// Procesar el formulario si se ha enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Guardar el nombre en la sesión
    if (isset($_POST['name'])) {
        $_SESSION['name'] = $_POST['name'];
    }

    // Procesar el archivo subido si existe
    if (isset($_FILES['file_upload']) && $_FILES['file_upload']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/'; // Directorio donde se guardarán los archivos subidos
        $uploadFile = $uploadDir . basename($_FILES['file_upload']['name']);

        // Verificar si el directorio existe; si no, crearlo
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Mover el archivo subido
        if (move_uploaded_file($_FILES['file_upload']['tmp_name'], $uploadFile)) {
            echo "El archivo ha sido subido exitosamente.";
        } else {
            echo "Error al subir el archivo.";
        }
    }

    // Redirigir a quiz.php para iniciar el cuestionario
    header("Location: seleccionar_archivo.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio del Cuestionario</title>
    <link rel="stylesheet" href="../Estils/CSS.css">   
</head>
<body>
    <form action="index.php" method="POST" enctype="multipart/form-data">
        <h2>Bienvenido al QUIZ</h2>
        
        <label for="name">Introduce tu nombre:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="file_upload">Sube un archivo opcional:</label>
        <input type="file" id="file_upload" name="file_upload" accept="*"><br><br>

        <input type="submit" value="Comenzar">
    </form>
</body>
</html>

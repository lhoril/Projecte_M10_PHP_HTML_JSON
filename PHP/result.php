<?php
session_start();
// result.php
header('Content-Type: text/html; charset=utf-8');


$filePath = ''.$_SESSION['path_file'].''; // Ruta al archivo CSV

// Verifica si el archivo CSV existe
if (!file_exists($filePath) || !is_readable($filePath)) {
    die('El archivo no existe o no se puede leer.'. $filePath .'');
}

$csvData = [];
if (($handle = fopen($filePath, 'r')) !== false) {
    // Leer la primera línea como cabecera
    $headers = fgetcsv($handle);
    
    // Leer las filas restantes
    while (($row = fgetcsv($handle)) !== false) {
        $csvData[] = array_combine($headers, $row);
    }
    fclose($handle);
}

// Mostrar resultados
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Estils/Result.CSS">
    <title>Resultados del Cuestionario</title>
</head>
<body>
    <h1>Resultados del Cuestionario</h1>
    <table>
        <thead>
            <tr>
                <th>Nombre de Usuario</th>
                <th>Total de Preguntas</th>
                <th>Respuestas Correctas</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($csvData as $result): ?>
                <tr>
                    <td><?php echo htmlspecialchars($result['Nombre_Usuario']); ?></td>
                    <td><?php echo htmlspecialchars($result['Total_Preguntas']); ?></td>
                    <td><?php echo htmlspecialchars($result['Respuestas_Correctas']); ?></td>
                    <td><?php echo htmlspecialchars($result['Fecha']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="../index2.php">Volver al inicio</a>
</body>
</html>
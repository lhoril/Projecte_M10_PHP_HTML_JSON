<?php
session_start();

// Configuración de preguntas y respuestas
$questions = [
    [
        "question" => "¿Cuál es la capital de Francia?",
        "choices" => ["Madrid", "París", "Londres", "Berlín"],
        "answer" => 1
    ],
    [
        "question" => "¿Cuál es el planeta más cercano al sol?",
        "choices" => ["Venus", "Tierra", "Mercurio", "Marte"],
        "answer" => 2
    ],
    [
        "question" => "¿Quién escribió 'Hamlet'?",
        "choices" => ["Shakespeare", "Cervantes", "Poe", "Neruda"],
        "answer" => 0
    ],
    [
        "question" => "¿Cuál es el idioma más hablado del mundo?",
        "choices" => ["Inglés", "Español", "Chino", "Hindi"],
        "answer" => 2
    ],
    [
        "question" => "¿Cuál es la capital de Japón?",
        "choices" => ["Beijing", "Seúl", "Tokio", "Kioto"],
        "answer" => 2
    ],
];

// Inicializar variables de sesión si es la primera pregunta
if (!isset($_SESSION['question_index'])) {
    $_SESSION['question_index'] = 0;
    $_SESSION['score'] = 0;
}

// Almacenar el nombre del usuario desde el formulario de inicio
if (isset($_POST['name'])) {
    $_SESSION['name'] = $_POST['name'];
}

// Verificar respuesta del usuario y avanzar a la siguiente pregunta
if (isset($_POST['choice'])) {
    $currentQuestionIndex = $_SESSION['question_index'];
    $selectedChoice = $_POST['choice'];

    // Verificar si la respuesta es correcta
    if ($selectedChoice == $questions[$currentQuestionIndex]['answer']) {
        $_SESSION['score']++;
        header("Location: ../HTML/correcta.html"); // Redirige a la pantalla de respuesta correcta
    } else {
        header("Location: ../HTML/incorrecta.html"); // Redirige a la pantalla de respuesta incorrecta
    }

    // Avanzar a la siguiente pregunta
    $_SESSION['question_index']++;
    exit;
}

// Obtener el índice actual de la pregunta
$currentIndex = $_SESSION['question_index'];

// Si el índice de la pregunta es mayor o igual al número total de preguntas, redirigir al final
if ($currentIndex >= count($questions)) {
    header("Location: final.php");
    exit;
}

// Obtener la pregunta actual
$currentQuestion = $questions[$currentIndex];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pregunta <?= $currentIndex + 1 ?></title>
    <link rel="stylesheet" href="/Estils/CSS.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }
        label {
            font-size: 22px; 
            color: #555;
            margin: 10px 0;
        }
        input[type="radio"] {
            margin-right: 10px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <form action="quiz.php" method="POST">
        <h2>Pregunta <?= $currentIndex + 1 ?></h2>
        <label for="pregunta"><?= $currentQuestion['question'] ?></label><br><br>

        <?php foreach ($currentQuestion['choices'] as $index => $choice): ?>
            <input type="radio" id="resposta<?= $index + 1 ?>" name="choice" value="<?= $index ?>" required>
            <label for="resposta<?= $index + 1 ?>"><?= $choice ?></label><br>
        <?php endforeach; ?>
        <br>
        <input type="submit" value="Enviar">
    </form>
</body>
</html>

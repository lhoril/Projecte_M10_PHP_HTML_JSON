<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página con música</title>
</head>
<body>
    <h1>Bienvenido a mi página con música</h1>
    
    <?php
    // Ruta de la música, puede cambiarse según tus necesidades
    $rutaMusica = "../audio/KahootMusic.mp3";
    echo "<audio id='miAudio' src='$rutaMusica' preload='auto'></audio>";
    ?>

    <script>
        // Cuando la página termine de cargar
        window.addEventListener('load', function() {
            const audio = document.getElementById('miAudio');
            audio.play().catch(error => {
                console.log("Reproducción automática bloqueada:", error);
            });
        });
    </script>
</body>
</html>
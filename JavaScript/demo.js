// Inicializamos el tiempo en 0 segundos
let tiempo = 0;
let tiempoTotal = 60;
let tiempoRestante = 0;

// Función para incrementar el tiempo y mostrarlo en consola
function temporizador() {
  tiempo++;
  tiempoRestante = tiempoTotal - tiempo;
}

// Usamos setInterval para que la función se ejecute cada segundo (1000 ms)
if(tiempoTotal > 0) setInterval(temporizador, 1000);

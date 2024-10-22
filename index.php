<?php
session_start();

// Verificar si se desea reiniciar el juego
if (isset($_POST['reiniciar'])) {
    // Destruir las variables de sesión
    session_destroy(); // Elimina toda la sesión
    session_start(); // Reiniciar la sesión
}

// Lista de palabras para el juego
$palabras = [
    'elefante', 'jirafa', 'hipopotamo', 'rinoceronte', 'cocodrilo', 'camello',
    'chimpance', 'steven', 'excelente', 'clausulazo', 'serendipia', 'alvise',
    'wordcast', 'economia'
];

// Inicializar la sesión y la palabra si no existe
if (!isset($_SESSION['palabra'])) {
    $_SESSION['palabra'] = $palabras[array_rand($palabras)];
    $_SESSION['vidas'] = 6; // Número máximo de vidas
    $_SESSION['letras_acertadas'] = str_repeat('?', strlen($_SESSION['palabra'])); // Inicializa con signos de interrogación
    $_SESSION['letras_usadas'] = [];
}

// Procesar la letra enviada
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['letra'])) {
    $letra = strtolower($_POST['letra']);

    // Verificar si la letra ya se ha usado
    if (in_array($letra, $_SESSION['letras_usadas'])) {
        echo "Ya has usado la letra '$letra'. Intenta con otra.<br>";
    } else {
        // Añadir la letra a las usadas
        $_SESSION['letras_usadas'][] = $letra;

        // Verificar si la letra está en la palabra secreta
        if (strpos($_SESSION['palabra'], $letra) !== false) {
            // Actualiza las letras acertadas
            $letras_acertadas_array = str_split($_SESSION['letras_acertadas']); // Convierte a array
            for ($i = 0; $i < strlen($_SESSION['palabra']); $i++) {
                if ($_SESSION['palabra'][$i] == $letra) {
                    $letras_acertadas_array[$i] = $letra; // Actualiza la letra
                }
            }
            $_SESSION['letras_acertadas'] = implode('', $letras_acertadas_array); // Convierte de nuevo a string
        } else {
            $_SESSION['vidas']--; // Disminuir vidas si la letra no está
        }
    }
}

// Comprobar si se ha ganado o perdido
if ($_SESSION['letras_acertadas'] == $_SESSION['palabra']) {
    header('Location: ganar.php'); // Redirigir a la página de ganar
    exit();
} elseif ($_SESSION['vidas'] <= 0) {
    header('Location: perder.php'); // Redirigir a la página de perder
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ahorcado</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            text-align: center;
        }
        h1 {
            color: #333;
        }
        form {
            margin: 20px;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
        }
    </style>
</head>
<body>
<h1>Juego del Ahorcado</h1>
<p>Palabra secreta: <?php echo $_SESSION['letras_acertadas']; ?></p>
<p>Vidas restantes: <?php echo $_SESSION['vidas']; ?></p>
<form method="post">
    <label for="letra">Introduce una letra:</label>
    <input type="text" name="letra" id="letra" maxlength="1" required>
    <button type="submit">Adivinar</button>
</form>
<form method="post">
    <button type="submit" name="reiniciar">Jugar de nuevo</button>
</form>
<p>Letras usadas: <?php echo implode(', ', $_SESSION['letras_usadas']); ?></p>
</body>
</html>


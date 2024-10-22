<?php
session_start();
// Comprobar si hay una sesión activa
if (!isset($_SESSION['palabra'])) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>¡Ganaste!</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #d4edda;
            text-align: center;
        }
        h1 {
            color: #155724;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
<h1>¡Enhorabuena!</h1>
<p>Has ganado :) La palabra era: <?php echo $_SESSION['palabra']; ?></p>
<form method="post" action="index.php">
    <button type="submit" name="reiniciar">Jugar de nuevo</button>
</form>
</body>
</html>

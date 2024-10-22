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
    <title>Perdiste</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8d7da;
            text-align: center;
        }
        h1 {
            color: #721c24;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #dc3545;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
<h1>Lo siento</h1>
<p>Has perdido :( La palabra era: <?php echo $_SESSION['palabra']; ?></p>
<form method="post" action="index.php">
    <button type="submit" name="reiniciar">Jugar de nuevo</button>
</form>
</body>
</html>

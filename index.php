<?php
    session_start();

    if(isset($_SESSION["logged_in"]) || isset($_SESSION["user_type"])){
        unset($_SESSION["logged_in"]);
        unset($_SESSION["user_type"]);
    }
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Iniciar Sesión</title>
        <link rel="stylesheet" href="styles.css">
        <script src="frameworks/jQuery.js"></script>
        <script type = "module" src="main.js"></script>
    </head>
    
    <body>
        <form action="" method="POST" id = "form">
            <div class="inputGroup">
                <input type="text" name="username" id="username" placeholder="Nombre de usuario">
                <input type="password" name="password" id="password" placeholder="Contraseña">
            </div>

            <div class="inputGroup">
                <input type="radio" name="user_type" id="radio_admin" value="admin">
                <label for="radio_admin">Administrador</label>
            </div>

            <div class="inputGroup">
                <input type="radio" name="user_type" id="radio_seller" value="seller" checked>
                <label for="radio_seller">Vendedor</label>
            </div>

            <div class="inputGroup">
                <input type="submit" id = "login" value="Iniciar sesión">
            </div>
        </form>
    </body>
</html>
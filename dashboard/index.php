<?php 
    require "../back/constants.php";
    require "../back/connection/config.php";

    session_start();

    if(!isset($_SESSION["logged_in"])){
        header("Location: $curr_server/test_frontend/index.php");
        die();
    }
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../app_icons/style.css">
        <link rel="stylesheet" href="styles.css">
        <script src="../frameworks/jQuery.js"></script>
        <script type = "module" src="main.js"></script>
        <title>Dashboard</title>
    </head>
    
    <body>
        <h1 class = "title">Bienvenido a la dashboard!</h1>

        <p class = "role">Su rol es: <?php echo $_SESSION["user_type"]; ?></p>

        <?php if($_SESSION["user_type"] == "admin") : ?>
            <section class="dashboard_panel">
                <h2 class = "title">Panel de administración</h2>

                <table>
                    <?php 
                        $query = $connection->prepare(
                            "SELECT ctype as Tipo, username as Nombre_de_usuario, fullname as " . 
                            "Nombre_completo, email as Correo, address as Direccion, phone as " .
                            "Telefono FROM users WHERE ctype = 'seller'"
                        );

                        $query->execute();

                        $res = $query->fetchAll(PDO::FETCH_ASSOC);

                        echo "<table id = 'mod_users' border='1' class = 'table_users'>";

                            if(!empty($res)){
                                foreach($res as $i => $obj){
                                    if($i == 0){
                                        echo "<tr>";
                                            foreach($obj as $col => $v){
                                                echo "<th>$col</th>";
                                            }

                                            echo "<th></th>";
                                            echo "<th></th>";
                                        echo "</tr>";
                                    }

                                    echo "<tr>";
                                        foreach($obj as $indx => $value){
                                            $editable = $indx != "Nombre_de_usuario" ?
                                                "contenteditable" : "";
                                            echo 
                                            "<td>" . 
                                                "<span $editable>$value</span>" .
                                            "</td>";
                                        }

                                        echo "<td><span class = 'icons icon-blue icon-box-add update_u'></span></td>";
                                        echo "<td><span class = 'icons icon-red icon-bin2 delete_u'></span></td>";
                                    echo "</tr>";
                                }
                            }

                        echo "</table>";
                    ?>
                </table>

                <div class="add_user_section">
                    <h2 class="title">Añade un usuario...</h2>

                    <table id = "add_users" border='1' class = 'table_users'>
                        <tr>
                            <th>Tipo</th>
                            <th>Nombre de usuario</th>
                            <th>Nombre completo</th>
                            <th>Correo</th>
                            <th>Dirección</th>
                            <th>Telefono</th>
                            <th>Contraseña</th>
                        </tr>
                        
                        <tr>
                            <td><span contenteditable>seller</span></td>
                            <td><span contenteditable>X</span></td>
                            <td><span contenteditable>X</span></td>
                            <td><span contenteditable>X</span></td>
                            <td><span contenteditable>X</span></td>
                            <td><span contenteditable>+XX XXX XXX XX XX</span></td>
                            <td><span contenteditable>X</span></td>
                        </tr>
                    </table>
                </div>

                <input type="button" id = "add_user" value="Añadir">

                <p class = "info">
                    Nota: para editar contenido debe dar click directamente en algún campo
                    y empezar a escribir...
                    
                    <br>
                    <b>Algunos campos no pueden modificarse porque no deberían ser modificados.</b>
                </p>
            </section>
        <?php endif;?>
    </body>
</html>
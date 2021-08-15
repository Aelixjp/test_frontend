<?php

    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Origin: localhost');
    header('Content-Type: application/json; charset = UTF-8');

    require "constants.php";
    require "filters.php";
    require "connection/config.php";

    session_start();

    if(isset($_SESSION["logged_in"]) || isset($_SESSION["user_type"])){
        unset($_SESSION["logged_in"]);
        unset($_SESSION["user_type"]);
    }

    $message;
    $fv = new FilterValidator();

    if(!isset($_SESSION["logged_in"])){
        if(isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["user_type"])){
            if(
                !empty(trim($_POST["username"])) &&
                !empty(trim($_POST["password"])) &&
                !empty(trim($_POST["user_type"]))
            ){
                
                $username  = $fv->strictFilterString($_POST["username"]);
                $passwd    = $fv->filterString($_POST["password"]);
                $user_type = $fv->strictFilterString($_POST["user_type"]);
                
                if(
                    $username == $_POST["username"] && 
                    $passwd == $_POST["password"]   &&
                    $user_type == $_POST["user_type"]
                ){
                    $query = $connection->prepare(
                        "SELECT username, ctype FROM users WHERE username = :username AND passwd = :passwd " .
                        "AND ctype = :ctype"
                    );
                 
                    $query->execute([
                        ":username" => $username,
                        ":passwd" => hash("sha512", $passwd),
                        ":ctype" => $user_type
                    ]);
            
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);
            
                    if(!empty($res)){
                        $message = [
                            "status" => "success",
                            "msg" => "Autenticado con exito!"
                        ];

                        $_SESSION["logged_in"] = true;
                        $_SESSION["user_type"] = $user_type;
                    }else{
                        $message = [
                            "status" => "fail",
                            "msg" => "Fallo de autenticación!"
                        ];

                        unset($_SESSION["logged_in"]);
                        session_destroy();
                    }
                }else{
                    $message = [
                        "status" => "fail",
                        "msg" => "Hay caracteres no validos en los campos!"
                    ];
                }

            }else{
                $message = [
                    "status" => "fail",
                    "msg" => "Porfavor introduzca información!"
                ];
            }
        }else{
            $message = [
                "status" => "fail",
                "msg" => "Hay campos sin rellenar..."
            ];
        }
    }else{
        $message = [
            "status" => "success",
            "msg" => "Autenticado con exito!"
        ];
    }

    echo json_encode($message);

?>
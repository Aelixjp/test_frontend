<?php 

    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Origin: localhost');
    header('Content-Type: application/json; charset = UTF-8');

    require "../connection/config.php";
    require "../filters.php";

    $message;
    $fv = new FilterValidator();

    if(
        isset($_POST["type"]) && isset($_POST["username"]) && isset($_POST["fullname"]) && 
        isset($_POST["email"]) && isset($_POST["address"]) && isset($_POST["phone"]) &&
        isset($_POST["op"])
    ){
        if(
            !empty(trim($_POST["type"])) && !empty(trim($_POST["username"])) &&
            !empty(trim($_POST["fullname"])) && !empty(trim($_POST["email"])) && 
            !empty(trim($_POST["address"])) && !empty(trim($_POST["phone"])) &&
            !empty($_POST["op"])
        ){

            $type = $fv->strictFilterString($_POST["type"]);
            $username = $fv->strictFilterString($_POST["username"]);
            $fullname = $fv->strictFilterString($_POST["fullname"]);
            $email = $fv->filterEmail($_POST["email"]);
            $address = $fv->filterString($_POST["address"]);
            $phone = $fv->filterPhone($_POST["phone"]);
            $option = $fv->filterNumber($_POST["op"]);
            $password = "";

            if(
                $type == $_POST["type"] && $username == $_POST["username"] && 
                $fullname == $_POST["fullname"] && $email == $_POST["email"] &&
                $address == $_POST["address"] && $phone == $_POST["phone"] &&
                $option == $_POST["op"]
            ){
                switch($option){
                    case 1:
                        if(isset($_POST["password"])){
                            if(!empty($_POST["password"])){
                                $password = $fv->strictFilterString($_POST["password"]);
                                $password = hash("sha512", $password);
        
                                $query = $connection->prepare(
                                    "INSERT INTO users (ctype, username, fullname, email, address," . 
                                    "phone, passwd) VALUES(:ctype, :username, :fullname, :email, :address," . 
                                    ":phone, :passwd)"
                                );
        
                                $res = $query->execute([
                                    ":ctype" => $type,
                                    ":username" => $username,
                                    ":fullname" => $fullname,
                                    ":email" => $email,
                                    ":address" => $address,
                                    ":phone" => $phone,
                                    ":passwd" => $password
                                ]);
        
                                if($res){
                                    $message = [
                                        "status" => "success",
                                        "msg" => "Usuario creado con exito!"
                                    ];
                                }else{
                                    $message = [
                                        "status" => "fail",
                                        "msg" => "Fallo al insertar el usuario! (quizá ya existe)..."
                                    ];
                                }
                            }else{
                                $message = [
                                    "status" => "fail",
                                    "msg" => "El campo contraseña esta vació!"
                                ];
                            }
                        }else{
                            $message = [
                                "status" => "fail",
                                "msg" => "EL campo contraseña no ha sido enviado!"
                            ];
                        }

                        break;
                        
                    case 2:
                        $query = $connection->prepare(
                            "UPDATE users SET ctype = :ctype, fullname = :fullname, email = :email, " . 
                            "address = :address, phone = :phone WHERE username = :username"
                        );

                        $res = $query->execute([
                            ":ctype" => $type,
                            ":fullname" => $fullname,
                            ":email" => $email,
                            ":address" => $address,
                            ":phone" => $phone,
                            ":username" => $username
                        ]);

                        if($res){
                            $message = [
                                "status" => "fail",
                                "msg" => "Información actualizada correctamente!"
                            ];
                        }else{
                            $message = [
                                "status" => "fail",
                                "msg" => "Ha ocurrido un error al actualizar la información!"
                            ];
                        }

                        break;

                    case 3:
                        $query = $connection->prepare("DELETE FROM users WHERE username = :username");

                        $res = $query->execute(["username" => $username]);

                        if($res){
                            $q = $connection->prepare(
                                "ALTER TABLE users AUTO_INCREMENT = 1"
                            );

                            $q->execute();

                            $message = [
                                "status" => "fail",
                                "msg" => "Usuario eliminado correctamente!"
                            ];
                        }else{
                            $message = [
                                "status" => "fail",
                                "msg" => "Error al eliminar el usuario!"
                            ];
                        }

                        break;

                    default:
                        $message = [
                            "status" => "fail",
                            "msg" => "Operación no valida!"
                        ];

                        break;
                }
            }else{
                $message = [
                    "status" => "fail",
                    "msg" => "Porfavor añada información valida!"
                ];
            }
        }else{
            $message = [
                "status" => "fail",
                "msg" => "Hay campos vacios!"
            ];
        }
    }else{
        $message = [
            "status" => "fail",
            "msg" => "Cierta información no ha sido enviada..."
        ];
    }

    echo json_encode($message);

?>
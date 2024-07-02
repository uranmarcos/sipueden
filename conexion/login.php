<?php
session_start();
    $_SESSION["login"] = false;
    $_SESSION["rol"] = null;
    $accion = "mostrar";
    $res = array("error" => false);
    
    if (isset($_GET["accion"])) {
        $accion = $_GET["accion"];
    }


    switch ($accion) {
        case 'login':
            $usuario    = $_POST["usuario"];
            $password   = $_POST["password"];     
            $passwordManuel = '8b0b2021e738647508b217ce1dc0f8f1da60776b4d05d02cb1401ffe7297fbdc';
            $passwordMarcos = 'a03a8d74024938e9ad0e828cbae7df0efd72fe16e40b83d60d16287c9e4dc66b';
            $passwordSiPueden = 'e72ea33b7e3ae11ec699c4dd593ca1359eb2a94502f06abbfa923c786fc43bac';
            // 30827879
            $hash = hash('sha256', $password);

            if ($usuario == "sipueden@fundacionsi.org.ar" && $hash === $passwordSiPueden) {
                $_SESSION["login"] = true;
                $_SESSION["rol"] = "usuario";
                $_SESSION['login_time'] = time();
                $mensaje = "Login ok";
                $token = sha1("usuario", false);
                $res["mensaje"] = $mensaje;
                $res["error"] = false;
                $res["token"] = $token;
            } else if (($usuario == "marcos@fundacionsi.org.ar" && $hash === $passwordMarcos) || 
                ($usuario == "manuel@fundacionsi.org.ar" && $hash === $passwordManuel)) {
                    $_SESSION["login"] = true;
                    $_SESSION["rol"] = "admin";
                    $_SESSION['login_time'] = time();
                    $mensaje = "Login ok";
                    $token = sha1("admin", false);
                    $res["mensaje"] = $mensaje;
                    $res["error"] = false;
                    $res["token"] = $token;

                    if($usuario == "marcos@fundacionsi.org.ar"){
                        $_SESSION["rol"] = "superAdmin";
                    }
            }  else {
                $error = "Los datos ingresados son incorrectos";
                $res["mensaje"] = $error;
                $res["error"] = true;
                $res["usuario"] = $usuario;
                $res["pas"] = $password;
                break;
            }  
        break;

        default:
            # code...
            break;
    }

    echo json_encode($res);
?>
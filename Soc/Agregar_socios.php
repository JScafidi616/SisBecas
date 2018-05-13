<?php
require_once 'config.php';
// definicion y iniciacion de variables con valores vacios.
$Nombre = $P_Apellido = $S_Apellido = $Num_Telefono = $Num_Celular = $Email = $Porcent_Soc = "";
$Nombre_err = $P_Apellido_err = $S_Apellido_err = $Num_Telefono_err = $Num_Celular_err = $Email_err = $Porcent_Soc_err = "";
 
// procesa datos del formulario cuando este se envie
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Valida nombre
    $input_Nombre = trim($_POST["Nombre"]);
    if(empty($input_Nombre)){
        $Nombre_err = "Ingrese el nombre del socio";
    } elseif(!filter_var(trim($_POST["Nombre"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z'-.üñÑáéíóÚÁÉÍÓÚ\s ]+$/")))){
        $Nombre_err = 'Ingrese un nombre valido';
    } else{
        $Nombre = $input_Nombre;
    }
    
    // Valida P_Apellido
    $input_P_Apellido = trim($_POST["P_Apellido"]);
    if(empty($input_P_Apellido)){
        $P_Apellido_err = 'Ingrese el primer apellido.';     
    } else{
        $P_Apellido = $input_P_Apellido;
    }
    
    // Valida S_Apellido
    $input_S_Apellido = trim($_POST["S_Apellido"]);
    if(empty($input_S_Apellido)){
        $S_Apellido_err = 'Ingrese el segundo apellido.';     
    } else{
        $S_Apellido = $input_S_Apellido;
    }
    
    // Valida Num_Telefono
    $input_Num_Telefono = trim($_POST["Num_Telefono"]);
    if(!empty($input_Num_Telefono)){
        if(!filter_var(trim($_POST["Num_Telefono"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^\d{8}$/")))){
            $Num_Telefono_err = 'Ingrese un numero telefonico valido.';
        } else{
            $Num_Telefono = $input_Num_Telefono;
        }
    }else{
        $Num_Telefono = $input_Num_Telefono;
    }
    // Valida Num_Celular
    $input_Num_Celular = trim($_POST["Num_Celular"]);
    if(!empty($input_Num_Celular)){
        if(!filter_var(trim($_POST["Num_Celular"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^\d{8}$/")))){
            $Num_Celular_err = 'Ingrese un numero celular valido.';
        } else{
            $Num_Celular = $input_Num_Celular;
        }
    }else{
        $Num_Celular = $input_Num_Celular;
    }
    // Valida Email
    $input_Email = trim($_POST["Email"]);
    if(!empty($input_Email)){
        if(!filter_var(trim($_POST["Email"]), FILTER_VALIDATE_EMAIL)){
            $Email_err = 'Ingrese un Email - valido formato(nombre @ dominio).';
        } else{
            $Email = $input_Email;
        }
    }else{
        $Email = $input_Email;
    }
    // Valida Porcent_Soc
    //se valida distinto para obtener concreto y no afectar la bd 
    $input_Porcent_Soc = trim($_POST["Porcent_Soc"]);
    if(!empty($input_Porcent_Soc)){
        if(!filter_var(trim($_POST["Porcent_Soc"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^([1-9][0-9]*|0)$/")))){
            $Porcent_Soc_err = 'Ingrese un valor entero para el porcentaje del socio.';
        }else{
            $Porcent_Soc = $input_Porcent_Soc;
        }
    }else{
        $Porcent_Soc = 0; //en caso de no recibir ningun valor, asigna cero por defecto
    }
    
    // comprueba que las variables de errores no tengan contenido para ejecutar la consulta correctamente
    if(empty($Nombre_err) && empty($P_Apellido_err) && empty($Num_Telefono_err)  && empty($Num_Celular_err) && empty($Email_err)  && empty($Porcent_Soc_err)){
        // Prepara el statement de insert 
        $sql = "INSERT INTO `tb_socios` (`ID`, `Nombre`, `P_Apellido`, `S_Apellido`, `Num_Telefono`,
         `Num_Celular`, `Email`, `Porcentaje_Socio`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables para preparar el statement como parametros
            mysqli_stmt_bind_param($stmt, "ssssssi", $param_Nombre, $param_P_Apellido, $param_S_Apellido, 
            $param_Num_Telefono ,$param_Num_Celular, $param_Email, $param_Porcentaje_Socio);
            
            // asigna los parametros 
            $param_Nombre = $Nombre;
            $param_P_Apellido = $P_Apellido;
            $param_S_Apellido = $S_Apellido;
            $param_Num_Telefono = $Num_Telefono;
            $param_Num_Celular = $Num_Celular;
            $param_Email = $Email;
            $param_Porcentaje_Socio = $Porcent_Soc;

            // ejecuta la consulta, si funciona devuelve al inicio del mantenimiento, sino imprima un error.
            if(mysqli_stmt_execute($stmt)){
                header("location: Mantenimiento_Socios.php");
                exit();
            } elseif(!mysqli_stmt_execute($stmt)){
                header("location: error.php");
            }else{
                echo "Something went wrong. Please try again later.";
            }
        }
        // cierra statement
        mysqli_stmt_close($stmt);
    }
    // cierra connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Crear registro</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Agrear socio</h2>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($Nombre_err)) ? 'has-error' : ''; ?>">
                            <label>Nombre</label>
                            <input type="text" name="Nombre" class="form-control" value="<?php echo $Nombre; ?>">
                            <span class="help-block"><?php echo $Nombre_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($P_Apellido_err)) ? 'has-error' : ''; ?>">
                            <label>Primer Apellido</label>
                            <input type="text" name="P_Apellido" class="form-control" value="<?php echo $P_Apellido; ?>">
                            <span class="help-block"><?php echo $P_Apellido_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($S_Apellido_err)) ? 'has-error' : ''; ?>">
                            <label>Segundo Apellido</label>
                            <input type="text" name="S_Apellido" class="form-control" value="<?php echo $S_Apellido; ?>">
                            <span class="help-block"><?php echo $S_Apellido_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($Num_Telefono_err)) ? 'has-error' : ''; ?>">
                            <label>Numero de Telefono</label>
                            <input type="text" name="Num_Telefono" class="form-control" value="<?php echo $Num_Telefono; ?>">
                            <span class="help-block"><?php echo $Num_Telefono_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($Num_Celular_err)) ? 'has-error' : ''; ?>">
                            <label>Numero de celular</label>
                            <input type="text" name="Num_Celular" class="form-control" value="<?php echo $Num_Celular; ?>">
                            <span class="help-block"><?php echo $Num_Celular_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($Email_err)) ? 'has-error' : ''; ?>">
                            <label>Correo electronico</label>
                            <input type="text" name="Email" class="form-control" value="<?php echo $Email; ?>">
                            <span class="help-block"><?php echo $Email_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($Porcent_Soc_err)) ? 'has-error' : ''; ?>">
                            <label>Porcentaje del socio</label>
                            <input type="text" name="Porcent_Soc" class="form-control" value="<?php echo $Porcent_Soc; ?>">
                            <span class="help-block"><?php echo $Porcent_Soc_err;?></span>
                        </div>
                        
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Agregar">
                            <a href="Mantenimiento_Socios.php" class="btn btn-default">Cancel</a>
                        </div>
                        
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
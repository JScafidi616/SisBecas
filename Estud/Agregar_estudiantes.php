<?php
require_once 'config.php';
 // definicion y iniciacion de variables con valores vacios.
$Nombre = $P_Apellido = $S_Apellido = $CIF = $Num_Telefono = $Num_Celular = $Carrera = $Direccion = $Ponderado = "";
$Email = $F_Matricula = $F_IngresoDatos = $Estado = "";

$Nombre_err = $P_Apellido_err = $S_Apellido_err = $CIF_err = $Num_Telefono_err = $Num_Celular_err = $Carrera_err = $Direccion_err = $Ponderado_err = "";
$Email_err = $F_Matricula_err =  $F_IngresoDatos_err = "";
 
// procesa datos del formulario cuando este se envie
if($_SERVER["REQUEST_METHOD"] == "POST"){
    ///Validate Nombre
    $input_Nombre = trim($_POST["Nombre"]);
    if(empty($input_Nombre)){
        $Nombre_err = 'Ingrese el nombre del estudiante.';
    } elseif(!filter_var(trim($_POST["Nombre"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z'-.üñÑáéíóÚÁÉÍÓÚ\s ]+$/")))){
        $Nombre_err = 'Ingrese un nombre valido';
    } else{
        $Nombre = $input_Nombre;
    }
    
    // Validate P_Apellido
    $input_P_Apellido = trim($_POST["P_Apellido"]);
    if(empty($input_P_Apellido)){
        $P_Apellido_err = 'Ingrese el primer apellido del estudiante.';     
    } else{
        $P_Apellido = $input_P_Apellido;
    }
    // Validate S_Apellido
    $input_S_Apellido = trim($_POST["S_Apellido"]);
    if(empty($input_S_Apellido)){
        $S_Apellido_err = 'Ingrese el segundo apellido del estudiante.';     
    } else{
        $S_Apellido = $input_S_Apellido;
    }
     // Validate CIF
    $inputCIF = trim($_POST["CIF"]);
    if(empty($inputCIF)){
        $CIF_err = 'Ingrese el CIF.';     
    } else{
        $CIF = $inputCIF;
    }

    // Validate Num_Telef
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

    // Validate Num_Celular
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

     // Validate Carrera
    $input_Carrera = trim($_POST["Carrera"]);
    if(empty($input_Carrera)){
        $Carrera_err = 'Ingrese la Carrera.';     
    } else{
        $Carrera = $input_Carrera;
    }

    // Validate Direccion
    $input_Direccion = trim($_POST["Direccion"]);
    if(empty($input_Direccion)){
        $Direccion_err = 'Ingrese una Direccion valida.';
    } else{
        $Direccion = $input_Direccion;
    }
    
    // Validate Ponderado
    $input_Ponderado = trim($_POST["Ponderado"]);
    if(empty($input_Ponderado)){
        $Ponderado_err = 'Ingrese el ponderado';     
    } elseif(!filter_var(trim($_POST["Ponderado"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^-?(?:\d+|\d*\.\d+)$/")))){
        $Ponderado_err = 'Ingrese un Ponderado entero.';
    } else{
        $Ponderado = $input_Ponderado;
    }
    // Validate Email
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
     // Validate F_Matricula
    $input_F_Matricula = trim($_POST["F_Matricula"]);
    if(!filter_var(trim($_POST["F_Matricula"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^\d{4}-\d{2}-\d{2}+$/")))){
        $F_Matricula_err = 'Ingrese la fecha de matricula valida.';
    } else{
        $F_Matricula = $input_F_Matricula;
    }
    // comprueba que las variables de errores no tengan contenido para ejecutar la consulta correctamente
    if(empty($Nombre_err) && empty($P_Apellido_err) && empty($S_Apellido_err) && empty($CIF_err) && empty($Num_Telefono_err) 
        && empty($Num_Celular_err) && empty($Carrera_err) && empty($Direccion_err) && empty($Ponderado_err) && empty($Email_err) 
        && empty($F_Matricula_err) ){
        // Prepara el statement de insert 
        $sql = "INSERT INTO `tb_estudiantes` (`ID`, `Nombre`, `P_Apellido`, `S_Apellido`, `CIF`,
         `Num_Telefono`, `Num_Celular`, `Carrera`, `Direccion`, `Ponderado`, `Email`, `F_Matricula`, `F_Clausura`,
         `F_IngresoDatos`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables para preparar el statement como parametros
            mysqli_stmt_bind_param($stmt, "ssssssssdssss", $param_Nombre, $param_P_Apellido, $param_S_Apellido, 
            $param_CIF, $param_Num_Telefono, $param_Num_Celular, $param_Carrera, $param_Direccion, $param_Ponderado, 
            $param_Email, $param_F_Matricula, $param_F_Clausura, $param_F_IngresoDatos);
            date_default_timezone_set("America/Costa_Rica");
            $nowDate = date("Y-m-d h:i:s");
            $futureDate = date('Y-m-d', strtotime($F_Matricula .' +4 months')); //manejo dinamico de fecha final de cuatrimestre

             // asigna los parametros 
            $param_Nombre = $Nombre;
            $param_P_Apellido = $P_Apellido;
            $param_S_Apellido = $S_Apellido;
            $param_CIF = $CIF;
            $param_Num_Telefono = $Num_Telefono;
            $param_Num_Celular = $Num_Celular;
            $param_Carrera = $Carrera;
            $param_Direccion = $Direccion;
            $param_Ponderado = $Ponderado;
            $param_Email = $Email;
            $param_F_Matricula = $F_Matricula;
            $param_F_Clausura = $futureDate;
            $param_F_IngresoDatos = $nowDate;

            // ejecuta la consulta, si funciona devuelve al inicio del mantenimiento, sino imprima un error.
            if(mysqli_stmt_execute($stmt)){
                header("location: Mantenimiento_Estudiantes.php");
                exit();
            }elseif(!mysqli_stmt_execute($stmt)){
                
                echo " ************************ Error en consulta ************************ <br/>";
                $CIF_err = "El estudiante ya fue ingresado -CIF digitado corresponde a un estudiante- ";
            }
            else{
                echo " Error al realizar consulta. Por favor intente de nuevo.";
            }
        }
        // cierra statement
        mysqli_stmt_close($stmt);
        // cierra connection
        mysqli_close($link);
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Crear registro</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script type="text/javascript">
        $(function() {
            $('#date1').datepicker({
                dateFormat:"yy-mm-dd"
            });
        } );
    </script>
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
                        <h2>Agregar estudiante</h2>
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

                        <div class="form-group <?php echo (!empty($CIF_err)) ? 'has-error' : ''; ?>">
                            <label> CIF </label>
                            <input type="text" name="CIF" class="form-control" value="<?php echo $CIF; ?>">
                            <span class="help-block"><?php echo $CIF_err;?></span>
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
                        <div class="form-group <?php echo (!empty($Carrera_err)) ? 'has-error' : ''; ?>">
                            <label>Carrera</label>
                            <input type="text" name="Carrera" class="form-control" value="<?php echo $Carrera; ?>">
                            <span class="help-block"><?php echo $Carrera_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($Direccion_err)) ? 'has-error' : ''; ?>">
                            <label>Direccion</label>
                            <textarea style="resize:none" class="form-control" rows="5" name="Direccion" id="Direccion" maxlength="255"><?php echo $Direccion; ?></textarea>
                            <input type="hidden" class="form-control" value="<?php echo $Direccion; ?>" />
                            <span class="help-block"><?php echo $Direccion_err;?></span>
                            <!-- <input type="text" name="Direccion" class="form-control" value="<?php /*echo $Direccion;*/ ?>"> -->
                        </div>
                        <div class="form-group <?php echo (!empty($Ponderado_err)) ? 'has-error' : ''; ?>">
                            <label>Ponderado</label>
                            <input type="text" name="Ponderado" class="form-control" value="<?php echo $Ponderado; ?>">
                            <span class="help-block"><?php echo $Ponderado_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($Email_err)) ? 'has-error' : ''; ?>">
                            <label>Correo electronico</label>
                            <input type="text" name="Email" class="form-control" value="<?php echo $Email; ?>">
                            <span class="help-block"><?php echo $Email_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($F_Matricula_err)) ? 'has-error' : ''; ?>">
                            <label>Fecha matricula</label>
                            <input type="text" name="F_Matricula" class="form-control" id="date1" value="<?php echo $F_Matricula; ?>">
                            <span class="help-block"><?php echo $F_Matricula_err;?></span>
                        </div>
                        
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Agregar">
                            <a href="Mantenimiento_estudiantes.php" class="btn btn-default">Cancel</a>
                        </div>
                        
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
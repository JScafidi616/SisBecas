<?php
// Include config file
require_once 'config.php';
 
// Define variables and initialize with empty values
$Nombre = $P_Apellido = $S_Apellido = $CIF = $Num_Telefono = $Num_Celular = $Carrera = $Direccion = $Ponderado = $Email = $F_Matricula = $F_Clausura = $F_IngresoDatos = $Estado = "";
$Nombre_err = $P_Apellido_err = $S_Apellido_err = $CIF_err = $Num_Telefono_err = $Num_Celular_err = $Carrera_err = $Direccion_err = $Ponderado_err =  $Email_err = $F_Matricula_err = $F_Clausura_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["ID"]) && !empty($_POST["ID"])){
    // Get hidden input value
    $ID = $_POST["ID"];
    
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

    // Validate Num_Telefono
    $input_Num_Telefono = trim($_POST["Num_Telefono"]);
    if(empty($_POST["Num_Telefono"])){
        $Num_Telefono = $input_Num_Telefono;
    }elseif(!filter_var(trim($_POST["Num_Telefono"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^\d{8}+$/")))){
        $Num_Telefono_err = 'Ingrese un numero telefonico valido.';
    } else{
        $Num_Telefono = $input_Num_Telefono;
    }

    // Validate Num_Celular
    $input_Num_Celular = trim($_POST["Num_Celular"]);
    if(empty($_POST["Num_Celular"])){
        $Num_Celular = $input_Num_Celular;
    } elseif(!filter_var(trim($_POST["Num_Celular"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^\d{8}+$/")))){
        $Num_Celular_err = 'Ingrese un numero celular valido.';
    } else{
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
    if(empty($_POST["Email"])){
        $Email = $input_Email;
    }
    elseif(!filter_var(trim($_POST["Email"]), FILTER_VALIDATE_EMAIL)){
        $Email_err = 'Ingrese un Email valido.';
    } else{
        $Email = $input_Email;
    }
     // Validate F_Matricula
     $input_F_Matricula = trim($_POST["F_Matricula"]);
     if(!filter_var(trim($_POST["F_Matricula"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^\d{4}-\d{2}-\d{2}+$/")))){
         $F_Matricula_err = 'Ingrese la fecha de matricula valida.';
     } else{
         $F_Matricula = $input_F_Matricula;
     }
      // Validate F_Clausura
    $input_F_Clausura = trim($_POST["F_Clausura"]);
    if(!filter_var(trim($_POST["F_Clausura"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^\d{4}-\d{2}-\d{2}+$/")))){
        $F_Clausura_err = 'Ingrese la fecha de Clausura valida. ';
    } else{
        $F_Clausura = $input_F_Clausura;
    }

    ///errores 
    // Check input errors before inserting in database
    if(empty($Nombre_err) && empty($P_Apellido_err) && empty($S_Apellido_err) && empty($CIF_err) && empty($Num_Telef_err) &&
     empty($Num_Celular_err) && empty($Carrera_err) && empty($Direccion_err) && empty($Ponderado_err) && empty($Email_err) && 
     empty($F_Matricula_err) && empty($F_Clausura_err) ){
        // Prepare an update statement
        $sql = "UPDATE `tb_estudiantes` SET `Nombre` = ?, `P_Apellido` = ?, `S_Apellido` = ?, `CIF` = ?,
        `Num_Telefono` = ?, `Num_Celular` = ?, `Carrera` = ?, `Direccion` = ?, `Ponderado` = ?, `Email` = ?,
        `F_Matricula` = ?, `F_Clausura` = ?, `Estado` = ? WHERE `ID`= ?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            // Agrega variables a una sentencia preparada como parámetros, i como integer, s como string por cada  valor
            mysqli_stmt_bind_param($stmt, "ssssssssdsssii", $param_Nombre, $param_P_Apellido, $param_S_Apellido, 
            $paramCIF, $param_Num_Telefono, $param_Num_Celular, $param_Carrera, $param_Direccion, $param_Ponderado,
            $param_Email, $param_F_Matricula, $param_F_Clausura, $param_Estado, $param_id);
            
            // Set parameters
            $param_Nombre = $Nombre;
            $param_P_Apellido = $P_Apellido;
            $param_S_Apellido = $S_Apellido;
            $paramCIF = $CIF;
            $param_Num_Telefono = $Num_Telefono;
            $param_Num_Celular = $Num_Celular;
            $param_Carrera = $Carrera;
            $param_Direccion = $Direccion;
            $param_Ponderado = $Ponderado;
            $param_Email = $Email;
            $param_F_Matricula = $F_Matricula;
            $param_F_Clausura = $F_Clausura;
            //$param_F_IngresoDatos = $F_IngresoDatos;
            $param_Estado = 1;
            $param_id = $ID;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: Mantenimiento_Estudiantes.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
        // Close statement
        mysqli_stmt_close($stmt);
        // Close connection
        mysqli_close($link);
    }
}
else{
    // Check existence of id parameter before processing further
    if(isset($_GET["ID"]) && !empty(trim($_GET["ID"]))){
        // Get URL parameter
        $id =  trim($_GET["ID"]);
        
        // Prepare a select statement
        $sql = "SELECT `ID`, `Nombre`, `P_Apellido`, `S_Apellido`, `CIF`, `Num_Telefono`, `Num_Celular`, `Carrera`, 
        `Direccion`, `Ponderado`, `Email`, `F_Matricula`, `F_Clausura`, `Estado` FROM `tb_estudiantes` WHERE `ID` = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $Nombre = $row["Nombre"];
                    $P_Apellido = $row["P_Apellido"];
                    $S_Apellido = $row["S_Apellido"];
                    $CIF = $row["CIF"];
                    $Num_Telefono = $row["Num_Telefono"];
                    $Num_Celular = $row["Num_Celular"];
                    $Carrera = $row["Carrera"];
                    $Direccion = $row["Direccion"];
                    $Ponderado = $row["Ponderado"];
                    $Email = $row["Email"];
                    $F_Matricula = $row["F_Matricula"];
                    $F_Clausura = $row["F_Clausura"];
                    $Estado = $row["Estado"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Ha habido un error. Por favor intente otra vez.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($link);
    } 
    else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Actualizar Registro</title>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script type="text/javascript">
        $(function() {
            $('#date1').datepicker({
                dateFormat:"yy-mm-dd"
            });    
            $('#date2').datepicker({
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
                        <h2>Actualizar Registro</h2>
                    </div>
                    <p>Edite los espacios de registro a modificar.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
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
                            <label>CIF</label>
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
                            <label>Fecha Matricula</label>
                            <input type="text" name="F_Matricula" class="form-control"  id="date1" value="<?php echo $F_Matricula; ?>">
                            <span class="help-block"><?php echo $F_Matricula_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($F_Clausura_err)) ? 'has-error' : ''; ?>">
                            <label>Fecha clausura</label>
                            <input type="text" name="F_Clausura" class="form-control"  id="date2" value="<?php echo $F_Clausura; ?>">
                            <span class="help-block"><?php echo $F_Clausura_err;?></span>
                        </div>
                        
                        <div class="form-group">
                            <input type="hidden" name="ID" value="<?php echo trim($_GET["ID"]); ?>"/>
                            <input type="submit" class="btn btn-primary" value="Actualizar">
                            <a href="Mantenimiento_estudiantes.php" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
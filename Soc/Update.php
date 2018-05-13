<?php
// Include config file
require_once 'config.php';
 
// Define variables and initialize with empty values
$Nombre = $P_Apellido = $S_Apellido = $Num_Telefono = $Num_Celular = $Email = $Porcent_Soc = "";
$Nombre_err = $P_Apellido_err = $S_Apellido_err = $Num_Telefono_err = $Num_Celular_err = $Email_err = $Porcent_Soc_err = "";
$var_dump = "";
 
// Processing form data when form is submitted
if(isset($_POST["ID"]) && !empty($_POST["ID"])){
    // Get hidden input value
    $ID = $_POST["ID"];
    ///Validate Nombre
    $input_Nombre = trim($_POST["Nombre"]);
    if(empty($input_Nombre)){
        $Nombre_err = "Ingrese el nombre del socio";
    } elseif(!filter_var(trim($_POST["Nombre"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z'-.üñÑáéíóÚÁÉÍÓÚ\s ]+$/")))){
        $Nombre_err = 'Ingrese un nombre valido';
    } else{
        $Nombre = $input_Nombre;
    }
    
    // Validate P_Apellido
    $input_P_Apellido = trim($_POST["P_Apellido"]);
    if(empty($input_P_Apellido)){
        $P_Apellido_err = 'Ingrese el primer apellido.';     
    } else{
        $P_Apellido = $input_P_Apellido;
    }
    // Validate S_Apellido
    $input_S_Apellido = trim($_POST["S_Apellido"]);
    if(empty($input_S_Apellido)){
        $S_Apellido_err = 'Ingrese el segundo apellido.';     
    } else{
        $S_Apellido = $input_S_Apellido;
    }
    
    // Validate Num_Telefono
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

    // Validate Email
    $input_Email = trim($_POST["Email"]);
    if(!empty($input_Email)){
        if(!filter_var(trim($_POST["Email"]), FILTER_VALIDATE_EMAIL)){
            $Email_err = 'Ingrese un Email -valido formato(nombre @ dominio).';
        } else{
            $Email = $input_Email;
        }
    }else{
        $Email = $input_Email;
    }
    
    // Validate Porcent_Soc
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
    
    ///errores 
    // Check input errors before inserting in database
    if(empty($Nombre_err) && empty($P_Apellido_err) && empty($Num_Telefono_err)  && empty($Num_Celular_err) && empty($Email_err)  && empty($Porcent_Soc_err)){
        // Prepare an update statement
        $sql = "UPDATE `tb_socios` SET `Nombre` = ?, `P_Apellido` = ?, `S_Apellido` = ?,
         `Num_Telefono` = ?, `Num_Celular` = ?, `Email` = ?, `Porcentaje_Socio` = ?, `Estado` = ? WHERE `ID`= ?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            // Agrega variables a una sentencia preparada como parámetros, i como integer, s como string por cada  valor
            mysqli_stmt_bind_param($stmt, "ssssssiii", $param_Nombre, $param_P_Apellido, $param_S_Apellido, 
            $param_Num_Telefono ,$param_Num_Celular, $param_Email, $param_Porcentaje_Socio, $param_estado, $param_id);
            
            // Set parameterss
            $param_Nombre = $Nombre;
            $param_P_Apellido = $P_Apellido;
            $param_S_Apellido = $S_Apellido;
            $param_Num_Telefono = $Num_Telefono;
            $param_Num_Celular = $Num_Celular;
            $param_Email = $Email;
            $param_Porcentaje_Socio = $Porcent_Soc;
            $param_estado = 1;
            $param_id = $ID;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: Mantenimiento_Socios.php");
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
        $sql = "SELECT `ID`, `Nombre`, `P_Apellido`, `S_Apellido`, `Num_Telefono`, `Num_Celular`, `Email`, 
        `Porcentaje_Socio` FROM `tb_socios` WHERE `ID` = ?";
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
                    $Num_Telefono = $row["Num_Telefono"];
                    $Num_Celular = $row["Num_Celular"];
                    $Email = $row["Email"];
                    $Porcent_Soc= $row["Porcentaje_Socio"];
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
                            <input type="hidden" name="ID" value="<?php echo trim($_GET["ID"]); ?>"/>
                            <input type="submit" class="btn btn-primary" value="Actualizar">
                            <a href="Mantenimiento_Socios.php" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
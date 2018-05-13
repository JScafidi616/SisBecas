<?php
// Proceso de borrado logico luego de la confirmacion
if(isset($_POST["ID"]) && !empty($_POST["ID"])){
    // Include config file
    require_once 'config.php';
    // prepara consulta
    $sql = "UPDATE `tb_estudiantes` SET `Estado` = 0 WHERE `ID` = ?";
    if($stmt = mysqli_prepare($link, $sql)){
        // Agrega variables a una sentencia preparada como parámetros, i como integer
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        // Asigna parametro a esperar
        $param_id = trim($_POST["ID"]);
        // Intenta ejecutar la consulta
        if(mysqli_stmt_execute($stmt)){
            header("location: Mantenimiento_estudiantes.php");
            exit();
        } else{
            echo "Oops! Ha habido un error. Por favor intente otra vez.";
        }
    }
    // cierra statement
    mysqli_stmt_close($stmt);
    // cierra connection
    mysqli_close($link);
} else{
    // Comprueba existenci del id inviado por parametros
    if(empty(trim($_GET["ID"]))){
        header("location: error.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Eliminar Registro</title>
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
                        <h1>Eliminar Registro</h1>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger fade in">
                            <input type="hidden" name="ID" value="<?php echo trim($_GET["ID"]); ?>"/>
                            <p>Esta seguro de querer eliminar este registro?</p><br>
                            <p>
                                <input type="submit" value="Si" class="btn btn-danger">
                                <a href="Mantenimiento_estudiantes.php" class="btn btn-default">No</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
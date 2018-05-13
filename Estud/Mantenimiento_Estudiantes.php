<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Pantalla principal</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <script src='./js/jquery-paginate.min.js'></script>
    <link rel="stylesheet" type="text/css" href="./style/style.css">
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header Options clearfix ">
                        <div class="col-xs-2"><a href="Agregar_estudiantes.php" class="btn btn-success">Agregar estudiante</a></div>
                        <div class="col-xs-2"><button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">Buscar</button></div>
                        <div class=""><a href="../Index.php" class="btn btn-success pull-right">Regresar</a></div>
                        <form action method="post">
                            <div class="modal fade" id="myModal" role="dialog">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Busqueda por filtro</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="col-xs-12"><input type="text" class="form-control input-sm" name="searchText" id="searchText"></div>
                                            <div class="col-xs-12">
                                                <select class="form-control inputsm" name="check_list[]" id="sel1">
                                                    <option value="none">Filtrar por...</option>
                                                    <option value="nombre">Nombre</option>
                                                    <option value="apellido1">Primer Apellido</option>
                                                    <option value="apellido2">Segundo Apellido</option>
                                                    <option value="CIF">CIF</option>
                                                    <option value="Carrera">Carrera</option>
                                                    <option value="Ponderado">Ponderado</option>
                                                    <option value="Matricula">Fecha matricula</option>
                                                    <option value="Clausura">Fecha cierre de cuatrimestre</option>
                                                    <option value="Activo">Activos</option>
                                                    <option value="Eliminado">Eliminados</option>
                                                </select>
                                                <!--<div class="rbt col-xs-2"><label class="checkbox-inline"><input type="checkbox" name="check_list[]" value="nombre">Nombre</label></div>
                                                <div class="rbt col-xs-2"><label class="checkbox-inline"><input type="checkbox" name="check_list[]" value="apellidos">Apellidos</label></div>
                                                -->
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="submit" name="formSubmit" value="Filtrar" class="btn btn-success pull-left"/>   
                                            <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form> 
                    </div>                 
                    <?php
                    require_once 'config.php';
                    $buscar = " ";// inicializa variable busqueda
                    //si esta limpio, no buscar por filtro
                    if(!empty($_POST['check_list'])) {
                        
                        //recorre array para buscar segun filtro seleccionado
                        foreach($_POST['check_list'] as $check) {
                            if($check === 'nombre') {
                                $buscar = $_POST['searchText'];
                                $sql = "SELECT `ID`,`Nombre`, `P_Apellido`,`S_Apellido`,`CIF`,
                                `Num_Telefono`,`Num_Celular`,`Carrera`,`Direccion`,`Ponderado`,
                                `Email`,`F_Matricula`,`F_Clausura`,`F_IngresoDatos` FROM `tb_estudiantes` 
                                WHERE `Estado` = 1 AND `Nombre` LIKE '$buscar%'";  
                                break;
                            }
                            elseif($check === 'apellido1'){
                                $buscar = $_POST['searchText'];
                                $sql = "SELECT `ID`,`Nombre`, `P_Apellido`,`S_Apellido`,`CIF`,
                                `Num_Telefono`,`Num_Celular`,`Carrera`,`Direccion`,CAST(`Ponderado` as DECIMAL(10,2)) as `Ponderado`,
                                `Email`,`F_Matricula`,`F_Clausura`,`F_IngresoDatos` FROM `tb_estudiantes` 
                                WHERE `Estado` = 1 AND `P_Apellido` LIKE '$buscar%'"; 
                                break;
                            }
                            elseif($check === 'apellido2'){
                                $buscar = $_POST['searchText'];
                                $sql = "SELECT `ID`,`Nombre`, `P_Apellido`,`S_Apellido`,`CIF`,
                                `Num_Telefono`,`Num_Celular`,`Carrera`,`Direccion`, `Ponderado`,
                                `Email`,`F_Matricula`,`F_Clausura`,`F_IngresoDatos` FROM `tb_estudiantes` 
                                WHERE `Estado` = 1 AND `S_Apellido` LIKE '$buscar%'";  
                                break;
                            }
                            elseif($check === 'CIF'){
                                $buscar = $_POST['searchText'];
                                $sql = "SELECT `ID`,`Nombre`, `P_Apellido`,`S_Apellido`,`CIF`,
                                `Num_Telefono`,`Num_Celular`,`Carrera`,`Direccion`, `Ponderado`,
                                `Email`,`F_Matricula`,`F_Clausura`,`F_IngresoDatos` FROM `tb_estudiantes` 
                                WHERE `Estado` = 1 AND `CIF` LIKE '$buscar%'";  
                                break;
                            }
                            elseif($check === 'Carrera'){
                                $buscar = $_POST['searchText'];
                                $sql = "SELECT `ID`,`Nombre`, `P_Apellido`,`S_Apellido`,`CIF`,
                                `Num_Telefono`,`Num_Celular`,`Carrera`,`Direccion`, `Ponderado`,
                                `Email`,`F_Matricula`,`F_Clausura`,`F_IngresoDatos` FROM `tb_estudiantes` 
                                WHERE `Estado` = 1 AND `Carrera` LIKE '$buscar%'";  
                                break;
                            }
                            elseif($check === 'Ponderado'){
                                
                                if(!empty($_POST['searchText'])){
                                    $buscar = $_POST['searchText'];
                                    $sql = "SELECT `ID`,`Nombre`, `P_Apellido`,`S_Apellido`,`CIF`,
                                    `Num_Telefono`,`Num_Celular`,`Carrera`,`Direccion`, `Ponderado`,
                                    `Email`,`F_Matricula`,`F_Clausura`,`F_IngresoDatos` FROM `tb_estudiantes` 
                                    WHERE `Estado`= 1 AND `Ponderado` LIKE '$buscar%'"; 
                                }else{
                                    $sql = "SELECT `ID`,`Nombre`, `P_Apellido`,`S_Apellido`,`CIF`,
                                    `Num_Telefono`,`Num_Celular`,`Carrera`,`Direccion`, `Ponderado`,
                                    `Email`,`F_Matricula`,`F_Clausura`,`F_IngresoDatos` FROM `tb_estudiantes` 
                                    WHERE `Estado`= 1
                                    ORDER BY `Ponderado` DESC";
                                }
                                break;
                            }
                            elseif($check === 'Matricula'){
                                $buscar = $_POST['searchText'];
                                $sql = "SELECT `ID`,`Nombre`, `P_Apellido`,`S_Apellido`,`CIF`,
                                `Num_Telefono`,`Num_Celular`,`Carrera`,`Direccion`, `Ponderado`,
                                `Email`,`F_Matricula`,`F_Clausura`,`F_IngresoDatos` FROM `tb_estudiantes` WHERE `Estado`= 1
                                AND `F_Matricula` LIKE '$buscar%'";
                                break;
                            }
                            elseif($check === 'Clausura'){
                                $buscar = $_POST['searchText'];
                                $sql = "SELECT `ID`,`Nombre`, `P_Apellido`,`S_Apellido`,`CIF`,
                                `Num_Telefono`,`Num_Celular`,`Carrera`,`Direccion`, `Ponderado`,
                                `Email`,`F_Matricula`,`F_Clausura`,`F_IngresoDatos` FROM `tb_estudiantes` WHERE `Estado`= 1
                                AND `F_Clausura` LIKE '$buscar%'";
                                break;
                            }
                            elseif($check === 'Activo'){
                                $sql = "SELECT `ID`,`Nombre`, `P_Apellido`,`S_Apellido`,`CIF`,
                                `Num_Telefono`,`Num_Celular`,`Carrera`,`Direccion`, `Ponderado`,
                                `Email`,`F_Matricula`,`F_Clausura`,`F_IngresoDatos` FROM `tb_estudiantes` WHERE `Estado`= 1";
                                break;
                            }
                            elseif($check === 'Eliminado'){
                                $sql = "SELECT `ID`,`Nombre`, `P_Apellido`,`S_Apellido`,`CIF`,
                                `Num_Telefono`,`Num_Celular`,`Carrera`,`Direccion`,CAST(`Ponderado` as DECIMAL(10,2)) as `Ponderado`,
                                `Email`,`F_Matricula`,`F_Clausura`,`F_IngresoDatos` FROM `tb_estudiantes` WHERE `Estado`= 0";
                                break;
                            }
                            else{
                                $sql = "SELECT `ID`,`Nombre`, `P_Apellido`,`S_Apellido`,`CIF`,
                                `Num_Telefono`,`Num_Celular`,`Carrera`,`Direccion`, `Ponderado`,
                                `Email`,`F_Matricula`,`F_Clausura`,`F_IngresoDatos` FROM `tb_estudiantes`";
                                break;
                            }
                        }
                    }
                    else{
                        //Consulta que selecciona todos los registro de la tabla empleados
                        $sql = "SELECT `ID`,`Nombre`, `P_Apellido`,`S_Apellido`,`CIF`,
                        `Num_Telefono`,`Num_Celular`,`Carrera`,`Direccion`,CAST(`Ponderado` as DECIMAL(10,2)) as `Ponderado`,
                        `Email`,`F_Matricula`,`F_Clausura`,`F_IngresoDatos` FROM `tb_estudiantes` WHERE `Estado`= 1";
                    }
                    //ejecuta la consulta luego de filtrar
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<table id='myTable' class='table table-bordered table-striped'>";
                                echo "<thead class='title-align'>";
                                    echo "<tr>";
                                        echo "<th style='display:none;'>ID</th>";
                                        echo "<th>Nombre</th>";
                                        echo "<th>1er Apellido</th>";
                                        echo "<th>2do Apellido</th>";
                                        echo "<th>CIF</th>"; 
                                        echo "<th>Telefono</th>";
                                        echo "<th>Celular</th>";
                                        echo "<th>Carrera</th>"; 
                                        echo "<th>Direccion</th>"; 
                                        echo "<th>Ponderado</th>"; 
                                        echo "<th>Email</th>";
                                        echo "<th>Matricula</th>"; 
                                        echo "<th>Clausura</th>"; 
                                        echo "<th>Accion</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody class='T_content-align'>";
                                //recibe un arrreglo y distribuye los elementos por fila 
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td style='display:none;'>" . $row['ID'] . "</td>";
                                        echo "<td>" . $row['Nombre'] . "</td>";
                                        echo "<td>" . $row['P_Apellido'] . "</td>";
                                        echo "<td>" . $row['S_Apellido'] . "</td>";
                                        echo "<td>" . $row['CIF'] . "</td>";
                                        echo "<td>" . $row['Num_Telefono'] . "</td>";
                                        echo "<td>" . $row['Num_Celular'] . "</td>";
                                        echo "<td>" . $row['Carrera'] . "</td>";
                                        echo "<td>" . $row['Direccion'] . "</td>";
                                        echo "<td>" . $row['Ponderado'] . "</td>";
                                        echo "<td>" . $row['Email'] . "</td>";
                                        echo "<td>" . $row['F_Matricula'] . "</td>";
                                        echo "<td>" . $row['F_Clausura'] . "</td>";
                                        echo "<td class='actionMenu'>";
                                            echo "<a href='update.php?ID=". $row['ID'] ."' title='Actualizar registro' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                            echo "<a href='delete.php?ID=". $row['ID'] ."' title='Eliminar registro' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";
                            echo "</table>";
                            //libera la memoria asociadaa un resultado.
                            mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>No se encontraron registros.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                    }
                    // Cierra conexion
                    mysqli_close($link);
                    ?>
                </div>
            </div>        
        </div>
        <table class='table table-bordered table-striped'>
            <tr>
                <div id='myNavWrapper'>
                </div>
            </tr>
        </table>
    </div>
</body>
<footer>
<script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });  
        $('#myTable').paginate({ 
            limit: 5,
            previous: true, // Show previous button
            previousText: 'Anterior ', // Change previous button text
            next: true, // Show previous button
            nextText: ' Siguiente',
            optional: false,
            last: false,
            first:false,
            navigationWrapper: $('div#myNavWrapper'), // Append the navigation menu to the `#myNavWrapper` div
            navigationClass: 'page-navigation' // New css class added to the navigation menu
        });
    </script>
</footer>
</html>
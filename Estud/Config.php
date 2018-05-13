<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'Joseph');
define('DB_PASSWORD', 'root');
define('DB_NAME', 'bduisilbecas');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: imposible conectar con la base de datos. " . mysqli_connect_error());
}
?>
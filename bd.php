<?php

$servidor = "localhost:3307"; //127.0.0.1
$baseDeDatos = "curp";
$usuario = "root";
$contrasenia = "";

try{
    $conexion = new PDO("mysql:host=$servidor;dbname=$baseDeDatos",$usuario,$contrasenia);
}catch(Exception $ex){
    echo $ex->getMessage();
}

?>
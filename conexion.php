<?php

$servidor="localhost";
$bbdd="app-php";
$usuario="root";
$password="";

try{
    $conexion=new PDO("mysql:host=$servidor;dbname=$bbdd",$usuario,$password);
}catch(Exception $e){
    echo $ex->getMessage();
}


?>
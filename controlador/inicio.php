<?php
session_start();
if(empty($_SESSION['usuario']))
	header("Location: " . "../controlador/login.php");

$divisor = fgetc(fopen("../vista/citas.txt", "r"));
$archivo = file_get_contents("../vista/citas.txt");
$citas = explode($divisor, $archivo);
$_SESSION['titulo_de_mensaje'] = 'Leyes de Murphy';
$_SESSION['mensaje'] = nl2br($citas[array_rand($citas)]);
unset($archivo);
unset($citas);
require_once '../vista/mostrar_mensaje.html';
?>
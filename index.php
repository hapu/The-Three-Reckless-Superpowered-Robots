<?php
session_start();
if(empty($_SESSION['usuario']))
	header("Location: " . "./controlador/login.php");

require_once './vista/menu.html';
?>
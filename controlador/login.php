<?php
if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']))
{
	session_start();
	if(empty($_SESSION['usuario']))
	{
		require_once ('../modelo/modelo.class.php');
		$usuario = verificar_cuenta($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
		if(is_bool($usuario))
		{
			header('WWW-Authenticate: Basic realm="Restricted Section"');
			header('HTT	P/1.0 401 Unauthorized');
			die("Usuario/Contraseña Incorrectos");
		}
		$_SESSION['usuario'] = $usuario;
	}
}
else
{
	header('WWW-Authenticate: Basic realm="Restricted Section"');
	header('HTTP/1.0 401 Unauthorized');
	die("Usuario/Contraseña Incorrectos");
}

header("Location: " . "../index.php");
// echo "<p>Bienvenido " .  $_SESSION['usuario']->usu_nombre ."</p>";
// die("<p><a href=../index.php>Click here to continue</a></p>");

function verificar_cuenta($usuario, $contraseña)
{
	if(empty($usuario) | empty($contraseña))
		return false;
	else
	{
		$resultado = Modelo::verificar_usuario($usuario, $contraseña);
		if(is_array($resultado) & count($resultado) > 0)
			return $resultado[0];
	}
	return false;
}

?>
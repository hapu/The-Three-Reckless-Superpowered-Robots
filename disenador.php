<?php
/* NO SE NOS OCURRIO NADA :( */
require_once "empleado.class.php";
switch ($_POST['etapa'])
{

	default:
		require_once 'etapa0.html';
		break;
	case '0';
	require_once 'etapa1.html';
	break;
	case '1';
	require_once 'etapa2.html';
	break;
	case '2';
	require_once 'etapa3.html';
	break;
	case '3';
	echo 'Fin';
	break;

}
?>
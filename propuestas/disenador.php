<?php
/* NO SE NOS OCURRIO NADA :( */
require_once "empleado.class.php";

session_start();

$base_de_datos["00000"] = "Grillo Lennon";
$base_de_datos["00001"] = "Omar McCartney";
$base_de_datos["00010"] = "Leopoldo Harrison";
$base_de_datos["00011"] = "Bere Star";
$base_de_datos["00100"] = "John Landeros";
$base_de_datos["00101"] = "Paul Arredondo";
$base_de_datos["00110"] = "George Benavente";
$base_de_datos["00111"] = "Ringo Cervantes";



switch ($_POST['etapa'])
{

	default:
		require_once 'etapa0.html';
		break;
	case '0':
		require_once 'etapa1.html';
		echo $_POST['busqueda'];

		echo '<form method="post" action="">
		<select name="empleado" size="5">';

		foreach ($base_de_datos as $key => $value) {
			if(strpos(strtoupper($value), strtoupper($_POST['busqueda'])) !== false)
				echo '<option value="' . $key . '">' . $key . ' ' . $value .'</option>';
		}

		echo '</select> <input type="hidden" name="etapa" value="1" />
		<p>
		<input type="submit" value="Enviar" />
		</p>
		</form>';
		break;
	case '1':
		$_SESSION['id_empleado'] = $_POST['empleado'];
		require_once 'etapa2.html';
		break;
	case '2':
		$_SESSION['fecha_inicio'] = $_POST['fecha_inicio'];
		$_SESSION['fecha_fin'] = $_POST['fecha_fin'];
		require_once 'etapa3.html';
		break;
	case '3':
		$propuesta[] =  $_POST['empleado'];
		$propuesta[] =  $_POST['propuesta'];
		$propuesta[] =  $_POST['propuesta'];
		$_SESSION['propuesta'] = $propuesta;
		echo 'Fin <br><br>';
		foreach ($_SESSION as $key => $value) {
			echo $key;
			var_dump($value);
			echo '<br>';
		}
		session_destroy();
		break;

}

?>
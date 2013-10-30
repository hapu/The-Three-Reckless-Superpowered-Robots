<?php
/* NO SE NOS OCURRIO NADA :( */
require_once "empleado.class.php";
$base_de_datos[0] = "Grillo Lennon";
$base_de_datos[1] = "Omar McCartney";
$base_de_datos[10] = "Leopoldo Harrison";
$base_de_datos[11] = "Bere Star";
$base_de_datos[100] = "John Landeros";
$base_de_datos[101] = "Paul Arredondo";
$base_de_datos[110] = "George Benavente";
$base_de_datos[111] = "Ringo Cervantes";
switch ($_POST['etapa'])
{

	default:
		require_once 'etapa0.html';
		break;
	case '0':
		require_once 'etapa1.html';
		echo $_POST['busqueda'];
		echo '
		<form method="post" action="">
		<select name="empleado" size="5">';
		foreach ($base_de_datos as $key => $value) {

			echo '<option value="' . $key . '">'. $value .'</option>';
		}

		echo '
		</select> <input type="hidden" name="etapa" value="1" />
		<p>
		<label><input type="submit" value="Enviar" /> </label>
		</p>
		</form>
		';
		break;
	case '1':
		require_once 'etapa2.html';
		break;
	case '2':
		require_once 'etapa3.html';
		break;
	case '3':
		echo 'Fin';
		break;

}
?>
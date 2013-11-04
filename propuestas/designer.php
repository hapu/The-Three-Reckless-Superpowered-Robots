<?php
require_once "empleado.class.php";

session_start();



switch ($_POST['etapa'])
{

	default:
		require_once 'etapa0.html';
		break;


	case '0':
		require_once 'etapa1.html';

		echo '<form method="post" action="">';
		echo 'Nombre o Numero<input type="text" name="busqueda" value="'.$_POST['busqueda'].'">';
		echo'<input type="hidden" name="etapa" value="0" /><input type="submit" value="Buscar"/>
		</form>	';

		require_once 'buscador.class.php';
		$foo = new Buscador();
		$result = $foo->buscar_empleados_por_nombre($_POST['busqueda']);

		echo '<form method="post" action="">
		<select name="empleado" size="5">';

		$rows = mysql_num_rows($result);
		for ($i = 0; $i < $rows; $i++) {
			$row = mysql_fetch_row($result);
			echo '<option value="' . $row[0] . '">' . $row[0] . ' ' . $row[1] .'</option>';
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
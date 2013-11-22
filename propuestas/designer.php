<?php
require_once '../test/modelo.class.php';
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

		$resultados = Modelo::buscar_empleados_por_nombre($_POST['busqueda']);

		echo '<form method="post" action="">
		<select name="empleado" size="5">';

		foreach ($resultados as $empleado) {
			echo '<option value="' . $empleado->id . '">' . $empleado->id . ' ' . $empleado->nombre .'</option>';
		}

		echo '</select> <input type="hidden" name="etapa" value="1" />
		<p>
		<input type="submit" value="Enviar" />
		</p>
		</form>';
		break;


	case '1':

		$_SESSION['empleado'] = Modelo::buscar_empleado_por_id($_POST['empleado']);
		require_once 'etapa2.html';
		break;


	case '1.5':
		$fecha_inicio = strtotime(str_replace('-', '/', $_POST['fecha_inicio']));
		$fecha_fin = strtotime(str_replace('-', '/', $_POST['fecha_fin']));
		if ($fecha_fin < $fecha_inicio)
		{
			require_once 'etapa2.html';
			break;
		}

		$_SESSION['fecha_inicio'] = date('Y-m-d', $fecha_inicio);
		$_SESSION['fecha_fin'] = date('Y-m-d', $fecha_fin);
	case '2':
		require_once 'etapa3.html';
		$empleados_capaces = Modelo::buscar_empleados_que_pueden_cubir_un_puesto($_SESSION['empleado']->puesto);

		echo '<form method="post" action="">
		<select name="empleado" size="5">';

		foreach ($empleados_capaces as $empleado) {
			echo '<option value="' . $empleado->id . '">' . $empleado->id . ' ' . $empleado->nombre .'</option>';
		}

		echo '</select> <input type="hidden" name="etapa" value="3" />
		<p>
		<input type="submit" value="Enviar" />
		</p>
		</form>';
		break;

	case '3':
		var_dump($_POST);
		var_dump($_SESSION);
		session_destroy();
		break;

}

?>
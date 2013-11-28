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
			echo '<option value="' . $empleado->id . '">' . $empleado->id . ' -  ' . $empleado->nombre . ' - ' . $empleado->puesto .'</option>';
		}

		echo '</select> <input type="hidden" name="etapa" value="1" />
		<p>
		<input type="submit" value="Enviar" />
		</p>
		</form>';
		break;


	case '1':
		require_once 'etapa2.html';
		$_SESSION['empleado'] = Modelo::buscar_empleado_por_id($_POST['empleado']);

		echo '<form method="post" action="">';

		echo 'Id <input type="text" name="id" value="'. $_SESSION['empleado']->id .'"><BR>';
		echo 'Nombre <input type="text" name="nombre" value="'. $_SESSION['empleado']->nombre .'"><BR>';
		echo 'Puesto <input type="text" name="puesto" value="'. $_SESSION['empleado']->puesto .'"><BR>';

		echo '</select> <input type="hidden" name="etapa" value="2" />
		<p>	<input type="submit" value="Enviar" /> </p>
		</form>';

		//FIXME
		$resultado = Modelo::consulta("SELECT * FROM Puesto WHERE pst_id NOT IN
				(SELECT emp_puesto FROM Empleado WHERE emp_puesto IS NOT NULL);");
		foreach ($resultado as $puesto)
			echo $puesto->pst_id . "<BR>";

		break;
	case '2':
		$empleado_temporal = new Empleado();
		$empleado_temporal->id = $_POST['id'];
		$empleado_temporal->nombre = $_POST['nombre'];
		$empleado_temporal->puesto = $_POST['puesto'];
		$resultado = Modelo::actualizar_empleado_por_id($_SESSION['empleado']->id, $empleado_temporal);
		header("Location: " . $_SERVER["PHP_SELF"]);
		break;

}

?>
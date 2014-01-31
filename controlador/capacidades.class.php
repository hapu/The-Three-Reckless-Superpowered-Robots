<?php
session_start();
if(empty($_SESSION['usuario']))
	header("Location: " . "./controlador/login.php");

require_once ('../modelo/modelo.class.php');

switch ($_POST['etapa'])
{
	default:
		$resultados = buscar_empleado_o_empleados($_POST['empleado']);
		if(is_bool($resultados))
		{
			require_once '../vista/buscar_empleado.html';
			break;
		}
		elseif (is_array($resultados))
		{
			require_once '../vista/seleccionar_empleado.html';
			break;
		}
		$_SESSION['empleado'] = $resultados;

		$temp = Modelo::buscar_puestos_que_puede_cubrir_un_empleado($_SESSION['empleado']->emp_id);
		$puestos_que_puede_cubrir = Array();
		foreach ($temp as $puesto) {
			$puestos_que_puede_cubrir[$puesto->pst_id] = $puesto;
		}

		$_SESSION['puestos_que_puede_cubrir'] = $puestos_que_puede_cubrir;

		$temp = Modelo::buscar_puestos_que_no_puede_cubrir_un_empleado($_SESSION['empleado']->emp_id);
		$puestos_que_no_puede_cubrir = Array();
		foreach ($temp as $puesto) {
			$puestos_que_no_puede_cubrir[$puesto->pst_id] = $puesto;
		}
		$_SESSION['puestos_que_no_puede_cubrir'] = $puestos_que_no_puede_cubrir;
		$_SESSION['puestos_a_agregar'] = Array();
		$_SESSION['puestos_a_remover'] = Array();

	case 'administrar_capacidades':
		if(!empty($_POST['puestos_a_remover']))
		{
			$id_puesto = $_POST['puestos_a_remover'];
			$_SESSION['puestos_que_no_puede_cubrir'][$id_puesto] = $_SESSION['puestos_que_puede_cubrir'][$id_puesto];
			if(empty($_SESSION['puestos_a_agregar'][$id_puesto]))
				$_SESSION['puestos_a_remover'][$id_puesto] = $_SESSION['puestos_que_puede_cubrir'][$id_puesto];
			unset($_SESSION['puestos_que_puede_cubrir'][$id_puesto]);
			unset($_SESSION['puestos_a_agregar'][$id_puesto]);

		}
		else if(!empty($_POST['puestos_a_agregar']))
		{
			$id_puesto = $_POST['puestos_a_agregar'];
			$_SESSION['puestos_que_puede_cubrir'][$id_puesto] = $_SESSION['puestos_que_no_puede_cubrir'][$id_puesto];
			if(empty($_SESSION['puestos_a_remover'][$id_puesto]))
				$_SESSION['puestos_a_agregar'][$id_puesto] = $_SESSION['puestos_que_no_puede_cubrir'][$id_puesto];
			unset($_SESSION['puestos_que_no_puede_cubrir'][$id_puesto]);
			unset($_SESSION['puestos_a_remover'][$id_puesto]);
		}
		ksort($_SESSION['puestos_que_puede_cubrir']);
		ksort($_SESSION['puestos_que_no_puede_cubrir']);
		require_once '../vista/administrar_capacidades.html';
		break;

	case 'almacenar_cambios':
		require_once '../vista/confirmar.html';
		break;

	case 'confirmacion':
		if($_POST['accion'] == 'aceptar')
		{
			agregar_capacidades($_SESSION['empleado']->emp_id, $_SESSION['puestos_a_agregar']);
			remover_capacidades($_SESSION['empleado']->emp_id, $_SESSION['puestos_a_remover']);
			header("Location: " . "../controlador/inicio.php");
		}
		require_once '../vista/administrar_capacidades.html';
		break;

}

function buscar_empleado_o_empleados($cadena)
{
	if(empty($cadena))
		return false;
	else if(strlen($cadena) == 5 && Modelo::buscar_cantidad_de_empleados_por_id($cadena))
		return Modelo::buscar_empleado_por_id($cadena);
	else if(strlen($cadena) == 8 &&	Modelo::buscar_cantidad_de_empleados_asignados_a_un_puesto($cadena))
		return Modelo::buscar_empleado_por_puesto($cadena);
	else
	{
		$resultados = Modelo::buscar_empleados_por_nombre_o_puesto($cadena);
		if(is_array($resultados) & count($resultados) > 0)
			return $resultados;
	}
	return false;
}

function agregar_capacidades($emp_id, $lista_de_pst_id)
{
	foreach ($lista_de_pst_id as $puesto) {
		Modelo::agregar_capacidad($puesto->pst_id, $emp_id);
	}
}

function remover_capacidades($emp_id, $lista_de_pst_id)
{
	foreach ($lista_de_pst_id as $puesto) {
		Modelo::eliminar_capacidad($puesto->pst_id, $emp_id);
	}
}

function mostrar_cambios()
{
	echo "<TABLE>";
	echo '<tr><th  colspan="2">Puestos a Agregar</th></tr>';
	foreach ($_SESSION['puestos_a_agregar'] as $puesto) {
		echo '<tr><td>';
		echo $puesto->pst_id;
		echo '</td><td> ';
		echo $puesto->pst_nombre;
		echo '</td>';
		echo '</tr>';
	}
	echo "</TABLE>";

	echo '<TABLE id="fondo_rojo">';
	echo '<tr><th id="fondo_rojo" colspan="2">Puestos a Remover</th></tr>';
	foreach ($_SESSION['puestos_a_remover'] as $puesto) {
		echo '<tr><td id="fondo_rojo">';
		echo $puesto->pst_id;
		echo '</td><td id="fondo_rojo">';
		echo $puesto->pst_nombre;
		echo '</td>';
		echo '</tr>';
	}
	echo "</TABLE>";
}

?>
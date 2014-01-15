<?php
require_once ('../modelo/modelo.class.php');
session_start();

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

	case 'administrar_capacidades':

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


?>
<?php
require_once '../modelo/modelo.class.php';
session_start();


switch ($_POST['etapa'])
{
	default:
		if(empty($_POST['empleado']))
		{
			require_once '../vista/buscar_empleado.html';
			break;
		}
		else if(strlen($_POST['empleado']) == 5 &&
				Modelo::verificar_empleado_por_id($_POST['empleado']))
			$_SESSION['empleado'] = Modelo::buscar_empleado_por_id($_POST['empleado']);
		else if(strlen($_POST['empleado']) == 8 &&
				false !== $id_empleado = Modelo::verificar_empleado_por_puesto($_POST['empleado']))
			$_SESSION['empleado'] = Modelo::buscar_empleado_por_id($id_empleado);
		else
		{
			$resultados = Modelo::buscar_empleados_por_nombre_o_puesto($_POST['empleado']);
			if($resultados === false)
				require_once '../vista/buscar_empleado.html';
			else
				require_once '../vista/seleccionar_empleado.php';
			break;
		}


	case 'administrar_capacidades':

		// 		require_once '../vista/administrar_capacidades.php';
		break;

}

function buscar_empleado_o_empleados($cadena)
{
	if(empty($cadena))
		return false;

	if(strlen($cadena) == 5 &&
			Modelo::verificar_empleado_por_id($cadena))
		return Modelo::buscar_empleado_por_id($cadena);

	if(strlen($cadena) == 8 &&
			false !== $id_empleado = Modelo::verificar_empleado_por_puesto($cadena))
		return Modelo::buscar_empleado_por_id($id_empleado);

	$resultados = Modelo::buscar_empleados_por_nombre_o_puesto($cadena);
	return $resultados;
}
?>
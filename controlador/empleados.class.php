<?php
require_once '../modelo/modelo.class.php';
session_start();


switch ($_POST['etapa'])
{
	default:
		require_once('../vista/buscar_empleado.html');
		break;


	case 'seleccionar_empleado':
		if(empty($_POST['busqueda']))
			require_once '../vista/buscar_empleado.html';
		else
		{
			$resultados = Modelo::buscar_empleados_por_nombre($_POST['busqueda']);
			require_once '../vista/seleccionar_empleado.php';
		}
		break;

	case 'almacenar_empleado':
		$_SESSION['incidentes'] = array();
		array_push($_SESSION['incidentes'], Modelo::buscar_empleado_por_id($_POST['empleado']));


	case 'seleccionar_concepto':
		require_once '../vista/seleccionar_concepto.html';
		break;


	case 'validar_fecha':
		$fecha_inicio = strtotime(str_replace('-', '/', $_POST['fecha_inicio']));
		$fecha_fin = strtotime(str_replace('-', '/', $_POST['fecha_fin']));
		if ($fecha_inicio === false || $fecha_inicio === false || $fecha_inicio > $fecha_fin)
		{
			require_once '../vista/seleccionar_concepto.html';
			break;
		}

		$_SESSION['fecha_inicio'] = date('Y-m-d', $fecha_inicio);
		$_SESSION['fecha_fin'] = date('Y-m-d', $fecha_fin);
		$_SESSION['concepto'] = $_POST['concepto'];

	case 'evaluacion_de_incidencia':
		if(!empty($_POST['empleado']))
			array_push($_SESSION['incidentes'], Modelo::buscar_empleado_por_id($_POST['empleado']));

		end($_SESSION['incidentes']);
		$empleados_capaces = current($_SESSION['incidentes'])->puesto != '00000000' ? Modelo::buscar_empleados_que_pueden_cubir_un_puesto(current($_SESSION['incidentes'])->puesto) : false;

		//Filtrar Empleados Capaces
		foreach ($empleados_capaces as $key => $empleado_a_comparar) {
			foreach ($_SESSION['incidentes'] as $incidente_a_comparar) {
				if($empleado_a_comparar->id === $incidente_a_comparar->id)
				{
					// 					var_dump($empleados_capaces[$key]);
					unset($empleados_capaces[$key]);
					break;
				}
			}
		}

		require_once '../vista/evaluacion_de_incidencia.php';
		break;

	case 'almacenar_incidencia':
		var_dump($_POST);
		var_dump($_SESSION);
		session_destroy();
		break;

}
?>
<?php
require_once '../modelo/modelo.class.php';
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

	// Almacenar Empleado
		$_SESSION['incidentes'] = array();
		array_push($_SESSION['incidentes'], $_SESSION['empleado']);


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
		$pst_id = current($_SESSION['incidentes'])->puesto;
		$fecha_inicio = $_SESSION['fecha_inicio'];
		$fecha_fin = $_SESSION['fecha_fin'];
		$empleados_capaces = $pst_id != '00000000' ? Modelo::buscar_empleados_que_pueden_cubir_un_puesto($pst_id, $fecha_inicio, $fecha_fin) : false;

		//Filtrar Empleados Capaces
		foreach ($empleados_capaces as $key => $empleado_a_comparar) {
			foreach ($_SESSION['incidentes'] as $incidente_a_comparar) {
				if($empleado_a_comparar->emp_id === $incidente_a_comparar->id)
				{
					// 					var_dump($empleados_capaces[$key]);
					unset($empleados_capaces[$key]);
					break;
				}
			}
		}

		require_once '../vista/evaluacion_de_incidencia.html';
		break;

	case 'almacenar_incidencia':
		$empleados_incidentes = $_SESSION['incidentes'];
		$concepto = $_SESSION['concepto'];
		$fecha_inicio = $_SESSION['fecha_inicio'];
		$fecha_fin = $_SESSION['fecha_fin'];
		$usuario = $_SESSION['usuario'];

// 		var_dump($empleados_incidentes[0]->id);
// 		var_dump($concepto);
// 		var_dump($fecha_inicio);
// 		var_dump($fecha_fin);
// 		var_dump($usuario);
		$numero_de_empleados = count($empleados_incidentes);
		Modelo::agregar_incidencia($empleados_incidentes[0]->id, $concepto, $fecha_inicio, $fecha_fin, $usuario);
		for ($i = 1; $i < $numero_de_empleados; $i++)
			Modelo::agregar_incidencia($empleados_incidentes[$i]->id, 'Cubriendo:'.$empleados_incidentes[$i - 1]->id, $fecha_inicio, $fecha_fin, $usuario);

		session_destroy();
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
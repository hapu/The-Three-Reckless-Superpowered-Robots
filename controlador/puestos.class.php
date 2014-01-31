<?php
session_start();
if(empty($_SESSION['usuario']))
	header("Location: " . "./controlador/login.php");

require_once ('../modelo/modelo.class.php');

switch ($_SESSION['modo'])
{
	default:

		break;

	case 'busquedas':
		switch ($_POST['etapa'])
		{
			default:
				//Buscar Puesto
			case 'resultados':
				//Redireccion
				break;
		}
		break;
	case 'altas':
		switch ($_POST['etapa'])
		{
			default:
				//Pagina de Captura
				break;
			case 'verificacion':
				//Validacion de Datos
				//Pagina de Confirmacion y Redirreccion
				break;
		}
		break;
	case 'bajas':
		switch ($_POST['etapa'])
		{
			default:
				//Buscar Puesto
				//Seleccionar Puesto
				//Pagina de Confirmacion y Redirreccion
				break;
		}
		break;
	case 'cambios':
		switch ($_POST['etapa'])
		{
			default:
				//Buscar Puesto
				//Seleccionar Puesto
			case 'edicion':
				//validacion de datos
				//Pagina de Confirmacion y Redirreccion
				break;
		}
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
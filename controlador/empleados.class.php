<?php
require_once '../modelo/modelo.class.php';
session_start();


switch ($_POST['etapa'])
{
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
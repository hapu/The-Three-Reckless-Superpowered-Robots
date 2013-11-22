<?php
define("SUCCESS",0);
define("WARNING",-1);
define("ERROR",-2);

class Propuesta
{
    var $fecha_inicio;     // tipo fecha
    var $fecha_fin;        // tipo fecha
    var $empleados;        // arreglo de objetos Empleado
    var $last_error;       // variable para obtener el ultimo error

    function __construct()
    {
        $empleados = Array();
    }

    function pushEmpleado($empleado)
    {

    }

    function popEmpleado()
    {

    }

    function guardar() // ojo esta hace cosas grandes
    {

    }

    function evaluar()
    {
    	// puede retornar ERROR, WARNING o SUCCESS
    	// almacena el resultado  en $this->last_error
    }
}

?>
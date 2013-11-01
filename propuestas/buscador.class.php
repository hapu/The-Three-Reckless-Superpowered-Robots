<?php
require_once("empleado.class.php");

class Buscador
{
    var $last_error;
    function __construct()
    {
    	require_once 'Login.php';
    	$db_server = mysql_connect($db_hostname, $db_username, $db_password);
    	if (!db_server)
    		die("Unable to connect to MySQL: " . mysql_error());

    	//Seleccion de Base de Datos
    	mysql_select_db($db_database)
    	or die("Unable to select database: " . mysql_error());

    	$db_table = 'Empleados';
    }

    function buscarPorCapacidad($puesto)
    {
          // retorna una lista de Empleados capaces de trabajar en un puesto
    }

    function mostrarCostos($puesto, $cantidad = false)
    {
          // retorna un arreglo de Puestos afectados por mover
          // a un empleado en un puesto dado
    }
}

?>
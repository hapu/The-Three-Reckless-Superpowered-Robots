<?php
require_once("empleado.class.php");

class Buscador
{
	public $last_error;
	private $db_server;
	private $db_table;

	function __construct()
	{
		require_once ('../Login.php');
		$this->db_server = mysql_connect($db_hostname, $db_username, $db_password);
		if (!db_server)
			die("Unable to connect to MySQL: " . mysql_error());

		//Seleccion de Base de Datos
		mysql_select_db($db_database)
		or die("Unable to select database: " . mysql_error());

		$this->db_table = 'Empleado';
	}

	function buscar_empleados_por_nombre($busqueda)
	{
		$result = mysql_query("SELECT * FROM Empleado WHERE emp_nombre LIKE '%$busqueda%';");
		if (!$result) die ("Database access failed: " . mysql_error());
		return $result;
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
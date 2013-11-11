<?php

$lista = Modelo::buscar_empleados_por_nombre("");

var_dump($lista);

$emp = Modelo::buscar_empleado_por_id("00001");

var_dump($emp);


class Modelo
{
	private static $db_hostname = '127.0.0.1';
	private static $db_username = 'root';
	private static $db_password = 'toor';
	private static $db_database = 'CFE';

	private static function conexion()
	{
		$db_server = new mysqli(self::$db_hostname, self::$db_username, self::$db_password, self::$db_database);
		if ($db_server->connect_errno)
			die('Connect Error (' . $db_server->connect_errno . ') ' . $db_server->connect_error);
		return $db_server;
	}

	public static function buscar_empleados_por_nombre($busqueda)
	{
		$db_server = self::conexion();
		$result = $db_server->query("SELECT * FROM Empleado WHERE emp_nombre LIKE '%$busqueda%';");
		if (!$result) die ("Database access failed: " . $db_server->error);
		$lista_de_empleados = array();

		require_once('empleado.class.php');

		while ($row = $result->fetch_object()) {
			$empleado_temporal = new Empleado();
			$empleado_temporal->id = $row->emp_id;
			$empleado_temporal->nombre = $row->emp_nombre;
			$empleado_temporal->puesto = $row->emp_puesto;
			$lista_de_empleados[] = $empleado_temporal;
		}
		$db_server->close();
		return $lista_de_empleados;
	}

	public static function buscar_empleado_por_id($id)
	{
		$db_server = self::conexion();
		$result = $db_server->query("SELECT * FROM Empleado WHERE emp_id = '$id';");
		if (!$result) die ("Database access failed: " . $db_server->error);

		require_once('empleado.class.php');

		$temp = $result->fetch_object();
		if(empty($temp))
			return false;

		$empleado_temporal = new Empleado();
		$empleado_temporal->id = $temp->emp_id;
		$empleado_temporal->nombre = $temp->emp_nombre;
		$empleado_temporal->puesto = $temp->emp_puesto;

		$db_server->close();
		return $empleado_temporal;
	}

	public static function buscar_capacidades_por_id_del_empleado($id)
	{
		$db_server = self::conexion();
		$result = $db_server->query("SELECT * FROM Empleado WHERE emp_nombre LIKE '%$busqueda%';");
		if (!$result) die ("Database access failed: " . $db_server->error);
		$lista_de_empleados = array();

		require_once('empleado.class.php');

		while ($row = $result->fetch_object()) {
			$empleado_temporal = new Empleado();
			$empleado_temporal->id = $row->emp_id;
			$empleado_temporal->nombre = $row->emp_nombre;
			$empleado_temporal->puesto = $row->emp_puesto;
			$lista_de_empleados[] = $empleado_temporal;
		}
		$db_server->close();
		return $lista_de_empleados;
	}

	function leer_arbol_de_la_base_de_datos($id)
	{
		$db_server = coneccion();
		$result = $db_server->query("SELECT
				`Puesto`.`pst_id`,
				`Puesto`.`pst_nombre`
				FROM `CFE`.`Puesto`
				WHERE `pst_id` = '$id';");
		$row = $result->fetch_row();
		$nodo = new Puesto();
		$nodo->setIdPuesto($row[0]);
		$nodo->setNombrePuesto($row[1]);
		$db_server->close();
		return $nodo;
	}

	function agregar_nodo_a_la_base_de_datos(Puesto $nodo)
	{
		$db_server = coneccion();

		$puesto_id = $nodo->getIdPuesto();
		$puesto_nombre = $nodo->getNombrePuesto();

		$result = $db_server->query("INSERT INTO `CFE`.`Puesto`
				(`pst_id`,
				`pst_nombre`)
				VALUES
				(
				'$puesto_id',
				'$puesto_nombre'
		);
				");
		echo $db_server->affected_rows . '<BR>';

		$suplentes = $nodo->getPuestosSuplentes();

		foreach ($suplentes as $sup) {
			$subpuesto_id = $sup->getIdPuesto();
			$result = $db_server->query("INSERT INTO `CFE`.`Subpuesto`
					(`spt_puesto_superior`,
					`spt_puesto_inferior`)
					VALUES
					(
					'$puesto_id',
					'$subpuesto_id'
			);");
			echo $db_server->affected_rows . '<BR>';

			// 		echo("INSERT INTO `CFE`.`Subpuesto`
			// 				(`spt_puesto_superior`,
			// 				`spt_puesto_inferior`)
			// 				VALUES
			// 				(
			// 				'$puesto_id',
			// 				'$subpuesto_id'
			// 		);<BR>");
			// 		echo $db_server->error;
			;
		}

		$db_server->close();
		foreach ($suplentes as $sup)
			if(isset($sup)) agregar_nodo_a_la_base_de_datos($sup);
	}
}

?>
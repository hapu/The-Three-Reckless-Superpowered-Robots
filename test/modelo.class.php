<?php
// error_reporting(E_ALL);
// $lista_emp = Modelo::buscar_empleados_por_nombre("ava");
// var_dump($lista_emp);

// $emp = Modelo::buscar_empleado_por_id("00001");
// var_dump($emp);

$lista_pst = Modelo::buscar_puestos_que_puede_cubrir_un_empleado("00111");
var_dump($lista_pst);

$lista_pst = Modelo::buscar_puestos_que_no_puede_cubrir_un_empleado("00111");
var_dump($lista_pst);

// $lista_emp = Modelo::buscar_empleados_que_pueden_cubir_un_puesto2("003");
// var_dump($lista_emp);


// print __LINE__ ."<BR>";


class Modelo
{
	private static $db_hostname = '127.0.0.1';
	private static $db_username = 'root';
	private static $db_password = 'toor';
	private static $db_database = 'CFE';
	public static $db_error;

	public static function consulta($query)
	{
		$db_server = new mysqli(self::$db_hostname, self::$db_username, self::$db_password, self::$db_database);
		if ($db_server->connect_errno)
		{
			self::$db_error = $db_server->connect_error;
			return false;
		}

		$result = $db_server->query($query);
		if (!$result)
		{
			self::$db_error = $db_server->error;
			return false;
		}

		if($result === true)
			return true;

		$resultado = array();
		while ($row = $result->fetch_object()) {
			$resultado[] = $row;
		}

		$db_server->close();
		return $resultado;
	}

	public static function buscar_empleados_por_nombre($nombre)
	{
		$query = "SELECT * FROM Empleado WHERE emp_nombre LIKE '%$nombre%';";
		$resultado = self::consulta($query);

		if($resultado === false)
			return false;

		require_once('empleado.class.php');
		$lista_de_empleados = array();
		foreach ($resultado as $renglon) {
			$empleado_temporal = new Empleado();
			$empleado_temporal->id = $renglon->emp_id;
			$empleado_temporal->nombre = $renglon->emp_nombre;
			$empleado_temporal->puesto = $renglon->emp_puesto;
			$lista_de_empleados[] = $empleado_temporal;
		}
		return $lista_de_empleados;
	}

	public static function buscar_empleado_por_id($id_empleado)
	{
		$query = "SELECT * FROM Empleado WHERE emp_id = '$id_empleado';";
		$resultado = self::consulta($query);

		require_once('empleado.class.php');

		if($resultado === false)
			return false;

		$empleado_temporal = new Empleado();
		$empleado_temporal->id = $resultado[0]->emp_id;
		$empleado_temporal->nombre = $resultado[0]->emp_nombre;
		$empleado_temporal->puesto = $resultado[0]->emp_puesto;

		return $empleado_temporal;
	}

	public static function buscar_puestos_que_puede_cubrir_un_empleado($id_empleado)
	{
		$query = "SELECT Puesto.* FROM Puesto JOIN Capacidad ON cap_puesto = pst_id WHERE  cap_empleado = '$id_empleado';";
		$resultado = self::consulta($query);

		if($resultado === false)
			return false;

		require_once('puesto.class.php');

		$lista_de_puestos = array();

		foreach ($resultado as $renglon) {
			$puesto_temporal = new Puesto();
			$puesto_temporal->id = $renglon->pst_id;
			$puesto_temporal->nombre = $renglon->pst_nombre;
			$lista_de_puestos[] = $puesto_temporal;
		}
		return $lista_de_puestos;
	}

	public static function buscar_puestos_que_no_puede_cubrir_un_empleado($id_empleado)
	{//@TODO
		$query = "SELECT * FROM Puesto WHERE pst_id != (SELECT Puesto.pst_id FROM Puesto JOIN Capacidad ON cap_puesto = pst_id WHERE  cap_empleado = '$id_empleado');";
		$resultado = self::consulta($query);

		if($resultado === false)
			return false;

		require_once('puesto.class.php');

		$lista_de_puestos = array();

		foreach ($resultado as $renglon) {
			$puesto_temporal = new Puesto();
			$puesto_temporal->id = $renglon->pst_id;
			$puesto_temporal->nombre = $renglon->pst_nombre;
			$lista_de_puestos[] = $puesto_temporal;
		}
		return $lista_de_puestos;
	}

	public static function buscar_empleados_que_pueden_cubir_un_puesto($id_puesto)
	{
		$query = "SELECT Empleado.* FROM Empleado JOIN Capacidad ON emp_id = cap_empleado WHERE  cap_puesto = '$id_puesto';";
		$resultado = self::consulta($query);

		if($resultado === false)
			return false;

		$lista_de_empleados = array();

		require_once('empleado.class.php');

		foreach ($resultado as $renglon) {
			$empleado_temporal = new Empleado();
			$empleado_temporal->id = $renglon->emp_id;
			$empleado_temporal->nombre = $renglon->emp_nombre;
			$empleado_temporal->puesto = $renglon->emp_puesto;
			$lista_de_empleados[] = $empleado_temporal;
		}
		return $lista_de_empleados;
	}

	public static function leer_arbol_de_la_base_de_datos($id_puesto)
	{
		$query = "SELECT * FROM Puesto WHERE pst_id = '$id_puesto';";
		$resultado = self::consulta($query);

		if($resultado === false)
			return false;

		require_once('puesto.php');
		$nodo = new Puesto();
		$nodo->setIdPuesto($resultado[0]->pst_id);
		$nodo->setNombrePuesto($resultado[0]->pst_nombre);
		return $nodo;
	}

	public static function agregar_nodo_a_la_base_de_datos(Puesto $nodo)
	{
		require_once('puesto.php');

		$puesto_id = $nodo->getIdPuesto();
		$puesto_nombre = $nodo->getNombrePuesto();

		$query = "INSERT INTO Puesto (pst_id, pst_nombre) VALUES ('$puesto_id', '$puesto_nombre');";
		$resultado = self::consulta($query);
		if($resultado === false)
			echo self::$db_error . '<BR>';
		else
			'Nice <BR>';

		$suplentes = $nodo->getPuestosSuplentes();

		foreach ($suplentes as $sup) {
			$subpuesto_id = $sup->getIdPuesto();
			$query = "INSERT INTO Subpuesto (spt_puesto_superior, spt_puesto_inferior) VALUES ('$puesto_id','$subpuesto_id');";
			$resultado = self::consulta($query);
			if($resultado === false)
				echo self::$db_error . '<BR>';
			else
				'Nice <BR>';
		}
		foreach ($suplentes as $sup)
			if(isset($sup))
				self::agregar_nodo_a_la_base_de_datos($sup);
	}
}
?>
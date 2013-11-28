<?php
require_once('puesto.class.php');
require_once('empleado.class.php');
// error_reporting(E_ALL);
// $lista_emp = Modelo::buscar_empleados_por_nombre("ava");
// var_dump($lista_emp);

// $emp = Modelo::buscar_empleado_por_id("00001");
// var_dump($emp);

// $lista_pst = Modelo::buscar_puestos_que_puede_cubrir_un_empleado("00111");
// var_dump($lista_pst);

// $lista_pst = Modelo::buscar_puestos_que_no_puede_cubrir_un_empleado("00111");
// var_dump($lista_pst);

// $lista_emp = Modelo::buscar_empleados_que_pueden_cubir_un_puesto("003");
// var_dump($lista_emp);

// $pst = Modelo::buscar_puesto_por_id("001");
// var_dump($pst);

// $arbol = Modelo::leer_nodo_de_puesto("001");
// var_dump($arbol);

// Modelo::agregar_nodo_de_puesto($arbol);


// print __LINE__ ."<BR>";


class Modelo
{

	private static $db_hostname = '127.0.0.1';
	private static $db_username = 'root';
	private static $db_password = 'toor';
	private static $db_database = 'CFE';
	public static $db_error;

	/**
	 *
	 * @param string $query
	 * @return boolean | array
	 */
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

	/**
	 *
	 * @param string $nombre
	 * @return boolean | array::Puesto
	 */
	public static function buscar_empleados_por_nombre($nombre)
	{
		$query = "SELECT * FROM Empleado WHERE emp_nombre LIKE '%$nombre%';";
		$resultado = self::consulta($query);

		if($resultado === false)
			return false;

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

	/**
	 *
	 * @param string $id_empleado
	 * @return boolean | Empleado
	 */
	public static function buscar_empleado_por_id($id_empleado)
	{
		$query = "SELECT * FROM Empleado WHERE emp_id = '$id_empleado';";
		$resultado = self::consulta($query);

		if($resultado === false)
			return false;

		$empleado_temporal = new Empleado();
		$empleado_temporal->id = $resultado[0]->emp_id;
		$empleado_temporal->nombre = $resultado[0]->emp_nombre;
		$empleado_temporal->puesto = $resultado[0]->emp_puesto;

		return $empleado_temporal;
	}

	/**
	 *
	 * @param string $id_empleado
	 * @param Empleado $emp
	 * @return boolean
	 */
	public static function actualizar_empleado_por_id($id_empleado, Empleado $emp)
	{
		$query = "UPDATE Empleado
		SET
		emp_id = '$emp->id',
		emp_nombre = '$emp->nombre',
		emp_puesto = '$emp->puesto'
		WHERE emp_id = '$id_empleado';";
		$resultado = self::consulta($query);

		return $resultado;
	}

	/**
	 *
	 * @param string $id_puesto
	 * @return boolean | Puesto
	 */
	public static function buscar_puesto_por_id($id_puesto)
	{
		$query = "SELECT * FROM Puesto WHERE pst_id = '$id_puesto';";
		$resultado = self::consulta($query);

		if(!is_array($resultado) || count($resultado) == 0)
			return false;

		$puesto_temporal = new Puesto();
		$puesto_temporal->id = $resultado[0]->pst_id;
		$puesto_temporal->nombre = $resultado[0]->pst_nombre;

		return $puesto_temporal;
	}

	/**
	 *
	 * @param string $id_empleado "clave de el empleado"
	 * @return boolean | array:Puesto
	 */
	public static function buscar_puestos_que_puede_cubrir_un_empleado($id_empleado)
	{
		$query = "SELECT Puesto.* FROM Puesto JOIN Capacidad ON cap_puesto = pst_id WHERE  cap_empleado = '$id_empleado';";
		$resultado = self::consulta($query);

		if($resultado === false)
			return false;


		$lista_de_puestos = array();

		foreach ($resultado as $renglon) {
			$puesto_temporal = new Puesto();
			$puesto_temporal->id = $renglon->pst_id;
			$puesto_temporal->nombre = $renglon->pst_nombre;
			$lista_de_puestos[] = $puesto_temporal;
		}
		return $lista_de_puestos;
	}

	/**
	 *
	 * @param string $id_empleado
	 * @return boolean | array:Puesto
	 */
	public static function buscar_puestos_que_no_puede_cubrir_un_empleado($id_empleado)
	{
		$query = "SELECT * FROM Puesto WHERE pst_id != (SELECT Puesto.pst_id FROM Puesto JOIN Capacidad ON cap_puesto = pst_id WHERE  cap_empleado = '$id_empleado');";
		$resultado = self::consulta($query);

		if($resultado === false)
			return false;


		$lista_de_puestos = array();

		foreach ($resultado as $renglon) {
			$puesto_temporal = new Puesto();
			$puesto_temporal->id = $renglon->pst_id;
			$puesto_temporal->nombre = $renglon->pst_nombre;
			$lista_de_puestos[] = $puesto_temporal;
		}
		return $lista_de_puestos;
	}

	/**
	 *
	 * @param string $id_puesto
	 * @return boolean | array:Empleado
	 */
	public static function buscar_empleados_que_pueden_cubir_un_puesto($id_puesto)
	{
		$query = "SELECT Empleado.* FROM Empleado JOIN Capacidad ON emp_id = cap_empleado WHERE  cap_puesto = '$id_puesto';";
		$resultado = self::consulta($query);

		if($resultado === false)
			return false;

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

	/**
	 *
	 * @param string $id_puesto
	 * @return NULL | Puesto
	 */
	public static function leer_nodo_de_puesto($id_puesto)
	{
		$puesto_temporal = self::buscar_puesto_por_id($id_puesto);
		if(!is_a($puesto_temporal, Puesto))
			return null;

		$query = "SELECT spt_puesto_inferior FROM Subpuesto WHERE spt_puesto_superior = '$id_puesto';";
		$subpuestos = self::consulta($query);

		if(!is_array($subpuestos) || count($subpuestos) == 0)
			return $puesto_temporal;

		$lista_de_subpuestos = array();

		foreach ($subpuestos as $renglon_subpuesto) {
			$id_subpuesto = $renglon_subpuesto->spt_puesto_inferior;
			$subpuesto_temporal = self::leer_nodo_de_puesto($id_subpuesto);
			$lista_de_subpuestos[] = $subpuesto_temporal;
		}

		$puesto_temporal->subpuestos = $lista_de_subpuestos;

		return $puesto_temporal;
	}

	/**
	 *
	 * @param Puesto $nodo_puesto
	 * @return void|boolean
	 */
	public static function agregar_nodo_de_puesto(Puesto $nodo_puesto)
	{
		$pst_id = $nodo_puesto->id;
		$pst_nombre = $nodo_puesto->nombre;
		$query = "INSERT INTO Puesto (pst_id, pst_nombre) VALUES ('$pst_id', '$pst_nombre');";
		$resultado = self::consulta($query);
		print $query."<BR>";
		if($resultado === false)//@todo
			return false;
		if (!isset($nodo_puesto->subpuestos))
			return ;
		$subpuestos = $nodo_puesto->subpuestos;
		foreach ($subpuestos as $sub) {
			$spt_id = $sub->id;
			$query = "INSERT INTO Subpuesto (spt_puesto_superior, spt_puesto_inferior) VALUES ('$pst_id','$spt_id');";
			$resultado = self::consulta($query);
			print $query."<BR>";

			if($resultado === false)//@todo
				return false;
			self::agregar_nodo_de_puesto($sub);
			return ;
		}

	}
}
?>
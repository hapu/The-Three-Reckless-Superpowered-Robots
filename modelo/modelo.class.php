<?php
error_reporting(E_ALL);
var_dump(Modelo::buscar_empleado_por_id("0000a"));
class Modelo
{

	private static $db_hostname = '127.0.0.1';
	private static $db_username = 'root';
	private static $db_password = 'toor';
	private static $db_database = 'CFE';
	public static $db_error;
	public static $db_num_error;

	/**
	 *
	 * @param string $query
	 * @return boolean | array
	 */
	private static function consulta($query)
	{
		$db_server = new mysqli(self::$db_hostname, self::$db_username, self::$db_password, self::$db_database);

		if ($db_server->connect_errno)
		{
			self::$db_error = $db_server->connect_error;
			self::$db_num_error = $db_server->connect_errno;
			return false;
		}

		$result = $db_server->query($query);

		if (is_bool($result))
		{
			if(!$result)
			{
				self::$db_error = $db_server->error;
				self::$db_num_error = $db_server->errno;
			}
			return $result;
		}

		$resultado = array();
		while ($row = $result->fetch_object()) {
			$resultado[] = $row;
		}

		$db_server->close();

		return $resultado;
	}

	/**
	 *
	 * @param string $cadena
	 * @return boolean | array
	 */
	public static function buscar_empleados_por_nombre_o_puesto($cadena)
	{
		$query = "SELECT
		emp_id, emp_nombre, pst_id, pst_nombre
		FROM
		Empleado
		JOIN
		Puesto ON emp_puesto = pst_id
		WHERE
		emp_nombre LIKE '%$cadena%' OR pst_nombre LIKE '%$cadena%';";

		$resultado = self::consulta($query);

		return $resultado;
	}

	/**
	 *
	 * @param string $id_empleado
	 * @return boolean | int
	 */
	public static function cantidad_de_empleados_por_id($emp_id)
	{
		$query = "SELECT
		Count(*) as emp_cantidad
		FROM
		Empleado
		WHERE
		emp_id = '$emp_id';";

		$resultado = self::consulta($query);

		if(is_array($resultado))
			return (int)$resultado[0]->emp_cantidad;
		return false;
	}

	/**
	 *
	 * @param string $id_puesto
	 * @return boolean | int
	 */
	public static function cantidad_de_empleados_asignados_a_un_puesto($pst_id)
	{
		$query = "SELECT
		Count(*) as emp_cantidad
		FROM
		Empleado
		JOIN
		Puesto ON emp_puesto = pst_id
		WHERE
		pst_id = '$pst_id';";

		$resultado = self::consulta($query);

		if(is_array($resultado))
			return (int)$resultado[0]->emp_cantidad;
		return false;
	}

	/**
	 *
	 * @param string $id_empleado
	 * @return boolean | stdClass
	 */
	public static function buscar_empleado_por_id($emp_id)
	{
		$query = "SELECT
		*
		FROM
		Empleado
		WHERE
		emp_id = '$emp_id';";

		$resultado = self::consulta($query);

		if(is_bool($resultado))
			return false;

		return $resultado[0];
	}

	/**
	 *
	 * @param string $id_puesto
	 * @return boolean | stdClass
	 */
	public static function buscar_empleado_por_puesto($pst_id)
	{
		$query = "SELECT
		Empleado . *
		FROM
		Empleado
		JOIN
		Puesto ON emp_puesto = pst_id
		WHERE
		pst_id = '$pst_id';";

		$resultado = self::consulta($query);

		if(is_bool($resultado))
			return false;

		return $resultado[0];
	}

	/**
	 *
	 * @param string $emp_id
	 * @param string $nuevo_emp_id
	 * @param string $nuevo_emp_nombre
	 * @param string $nuevo_emp_puesto
	 * @return boolean
	 */
	public static function actualizar_empleado_por_id($emp_id, $nuevo_emp_id, $nuevo_emp_nombre, $nuevo_emp_puesto)
	{
		$query = "UPDATE
		Empleado
		SET
		emp_id = '$nuevo_emp_id',
		emp_nombre = '$nuevo_emp_nombre',
		emp_puesto = '$nuevo_emp_puesto'
		WHERE
		emp_id = '$emp_id';";

		$resultado = self::consulta($query);

		return $resultado;
	}

	/**
	 *
	 * @param string $pst_id
	 * @return boolean | stdClass
	 */
	public static function buscar_puesto_por_id($pst_id)
	{
		$query = "SELECT
		*
		FROM
		Puesto
		WHERE
		pst_id = '$pst_id';";

		$resultado = self::consulta($query);

		if(is_bool($resultado))
			return false;

		return $resultado[0];
	}

	/**
	 *
	 * @param string $emp_id
	 * @return boolean | array:stdClass
	 */
	public static function buscar_puestos_que_puede_cubrir_un_empleado($emp_id)
	{
		$query = "SELECT
		Puesto . *
		FROM
		Puesto
		JOIN
		Capacidad ON cap_puesto = pst_id
		WHERE
		cap_empleado = '$emp_id';";

		$resultado = self::consulta($query);

		return $resultado;
	}

	/**
	 *
	 * @param string $emp_id
	 * @return boolean | array:stdClass
	 */
	public static function buscar_puestos_que_no_puede_cubrir_un_empleado($emp_id)
	{
		//@TODO
		$query = "SELECT
		*
		FROM
		Puesto
		WHERE
		pst_id NOT IN (SELECT
		Puesto.pst_id
		FROM
		Puesto
		JOIN
		Capacidad ON cap_puesto = pst_id
		WHERE
		cap_empleado = '$emp_id');";

		$resultado = self::consulta($query);

		return $resultado;
	}

	/**
	 *
	 * @param string $id_puesto
	 * @return boolean | array:Empleado
	 */
	public static function buscar_empleados_que_pueden_cubir_un_puesto($id_puesto, $fecha_inicio, $fecha_fin)
	{
		//@TODO
		//$query = "SELECT Empleado.* FROM Empleado JOIN Capacidad ON emp_id = cap_empleado WHERE  cap_puesto = '$id_puesto';";
		$query = "SELECT Empleado.*,
		pst_nombre,
		(SELECT COUNT(*)
		FROM Incidencia
		WHERE inci_empleado = emp_id
		AND inci_inicio <= '$fecha_fin'
		AND inci_fin >= '$fecha_inicio' ) AS emp_incidencias
		FROM Empleado
		JOIN Capacidad ON emp_id = cap_empleado
		JOIN Puesto ON pst_id = emp_puesto
		WHERE cap_puesto = '$id_puesto';";
		$resultado = self::consulta($query);

		if($resultado === false)
			return false;

		return $resultado;
	}

	/**
	 *
	 * @param string $empleado
	 * @param string $concepto
	 * @param string $fecha_inicio
	 * @param string $fecha_fin
	 * @param string $usuario
	 * @return boolean
	 */
	public static function agregar_incidencia($empleado, $concepto, $fecha_inicio, $fecha_fin, $usuario)
	{
		$query = "INSERT INTO
		Incidencia
		(inci_inicio, inci_fin, inci_concepto, inci_empleado, inci_usuario)
		VALUES
		('$fecha_inicio', '$fecha_fin', '$concepto', '$empleado', '$usuario');";

		$resultado = self::consulta($query);

		return $resultado;
	}
}
?>
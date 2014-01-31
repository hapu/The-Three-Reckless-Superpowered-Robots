<?php
class Modelo
{
	// 	Parametros
	private static $db_hostname = '127.0.0.1';
	private static $db_username = 'root';
	private static $db_password = 'toor';
	private static $db_database = 'CFE';



	// 	Errores
	public static $db_error;
	public static $db_num_error;

	// 	Conecciones
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


	public static function verificar_usuario($usuario, $contraseña)
	{
		$query = "SELECT
		usu_id, usu_empleado, usu_nombre
		FROM
		Usuario
		WHERE
		usu_nombre = '$usuario' AND usu_password = '$contraseña'";

		$resultado = self::consulta($query);

		return $resultado;
	}

	// 	Busquedas
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
		LEFT JOIN
		Puesto ON emp_puesto = pst_id
		WHERE
		emp_nombre LIKE '%$cadena%' OR pst_nombre LIKE '%$cadena%';";

		$resultado = self::consulta($query);

		return $resultado;
	}

	/**
	 *
	 * @param string $emp_id
	 * @return boolean | int
	 */
	public static function buscar_cantidad_de_empleados_por_id($emp_id)
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
	 * @param string $pst_id
	 * @return boolean | int
	 */
	public static function buscar_cantidad_de_empleados_asignados_a_un_puesto($pst_id)
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
	 * @param string $emp_id
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
	 * @param string $pst_id
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
		Puesto.*
		FROM
		Puesto
		LEFT JOIN
		Capacidad ON cap_empleado = '$emp_id' AND cap_puesto = pst_id
		WHERE cap_empleado IS NOT NULL;";

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
		$query = "SELECT
		Puesto.*
		FROM
		Puesto
		LEFT JOIN
		Capacidad ON cap_empleado = '$emp_id' AND cap_puesto = pst_id
		WHERE cap_empleado IS NULL;";

		$resultado = self::consulta($query);

		return $resultado;
	}

	/**
	 *
	 * @param string $id_puesto
	 * @param string $fecha_inicio
	 * @param string $fecha_fin
	 * @return boolean | array:stdClass
	 */
	public static function buscar_incidencias_de_empleados_capaces_de_cubir_un_puesto($id_puesto, $fecha_inicio, $fecha_fin)
	{
		$query = "SELECT
		emp_id,
		emp_nombre,
		pst_id,
		pst_nombre,
		Count(inci_empleado) as emp_incidencias
		FROM
		Empleado
		JOIN
		Capacidad ON emp_id = cap_empleado AND cap_puesto = '$id_puesto'
		LEFT JOIN
		Incidencia ON emp_id = inci_empleado AND inci_inicio <= '$fecha_fin' AND inci_fin >= '$fecha_inicio'
		LEFT JOIN
		Puesto ON emp_puesto = pst_id
		GROUP BY emp_id";
		$resultado = self::consulta($query);

		return $resultado;
	}

	/**
	 *
	 * @param string $id_puesto
	 * @param string $fecha_inicio
	 * @param string $fecha_fin
	 * @return boolean | array:stdClass
	 */
	public static function buscar_incidencias_de_empleados_incapaces_de_cubir_un_puesto($id_puesto, $fecha_inicio, $fecha_fin)
	{
		$query = "SELECT
		Empleado.emp_id,
		Empleado.emp_nombre,
		pst_id,
		pst_nombre,
		Count(inci_empleado) as emp_incidencias
		FROM
		Empleado
		LEFT JOIN
		Capacidad ON Empleado.emp_id = cap_empleado AND cap_puesto = '$id_puesto'
		LEFT JOIN
		Incidencia ON Empleado.emp_id = inci_empleado AND inci_inicio <= '$fecha_fin' AND inci_fin >= '$fecha_inicio'
		LEFT JOIN
		Puesto ON Empleado.emp_puesto = pst_id
		WHERE
		cap_empleado IS NULL
		GROUP BY emp_id;";
		$resultado = self::consulta($query);

		return $resultado;
	}



	// 	Altas
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

	public static function agregar_empleado($emp_id, $emp_nombre, $emp_puesto){
		$query = "INSERT INTO Empleado
		(emp_id,
		emp_nombre,
		emp_puesto)
		VALUES
		(
		'$emp_id',
		'$emp_nombre',
		'$emp_puesto'
		);";
		$resultado = self::consulta($query);

		return $resultado;
	}

	public static function agregar_puesto($pst_id, $pst_nombre){
		$query = "INSERT INTO Puesto
		(pst_id,
		pst_nombre)
		VALUES
		(
		'$pst_id',
		'$pst_nombre'
		);";

		$resultado = self::consulta($query);

		return $resultado;
	}

	public static function agregar_capacidad($cap_puesto, $cap_empleado, $cap_puntacion = '0')
	{
		echo $cap_puntacion;
		$query = "INSERT INTO Capacidad
		(cap_puntuacion,
		cap_puesto,
		cap_empleado)
		VALUES
		(
		'$cap_puntuacion',
		'$cap_puesto',
		'$cap_empleado'
		);";

		$resultado = self::consulta($query);

		return $resultado;
	}


	// 	Bajas
	public static function eliminar_incidencia_por_id($inci_id)
	{
		$query = "DELETE FROM Incidencia
		WHERE inci_id = '$inci_id';";

		$resultado = self::consulta($query);

		return $resultado;
	}

	public static function eliminar_empleado_por_id($emp_id)
	{
		$query = "DELETE FROM Empleado
		WHERE emp_id = '$emp_id';";

		$resultado = self::consulta($query);

		return $resultado;
	}

	public static function eliminar_puesto_por_id($pst_id)
	{
		$query = "DELETE FROM Puesto
		WHERE pst_id = '$pst_id';";

		return $resultado;
	}

	public static function eliminar_capacidad($cap_puesto, $cap_empleado)
	{
		$query = "DELETE FROM Capacidad
		WHERE cap_puesto = '$cap_puesto'
		AND cap_empleado = '$cap_empleado';";

		$resultado = self::consulta($query);

		return $resultado;
	}



	// 	Cambios
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
		$query = "UPDATE Empleado
		SET
		emp_id = '$emp_id',
		emp_nombre = '$emp_nombre',
		emp_puesto = '$emp_puesto'
		WHERE emp_id = '$emp_id';";

		$resultado = self::consulta($query);

		return $resultado;
	}

	public static function actualizar_puesto_por_id($pst_id_original, $pst_id, $pst_nombre)
	{
		$query = "UPDATE Puesto
		SET
		pst_id = '$pst_id',
		pst_nombre = '$pst_nombre'
		WHERE pst_id = '$pst_id_original';";

		$resultado = self::consulta($query);

		return $resultado;
	}

	public static function actualizar_incidencia_por_id($inci_id_original, $inci_id, $inci_inicio, $inci_fin, $inci_concepto, $inci_empleado, $inci_usuario)
	{
		$query = "UPDATE Incidencia
		SET
		inci_id = '$inci_id',
		inci_inicio = '$inci_inicio',
		inci_fin = '$inci_fin',
		inci_concepto = '$inci_concepto',
		inci_empleado = '$inci_empleado',
		inci_usuario = '$inci_usuario'
		WHERE inci_id = '$inci_id_original';";

		$resultado = self::consulta($query);

		return $resultado;
	}

	public static function actualizar_capacidad($cap_puesto_original, $cap_empleado_original, $cap_puntuacion, $cap_puesto, $cap_empleado)
	{
		$query = "UPDATE Capacidad
		SET
		cap_puntuacion = '$cap_puntuacion',
		cap_puesto = '$cap_puesto',
		cap_empleado = '$cap_empleado'
		WHERE cap_puesto = '$cap_puesto_original'
		AND cap_empleado = '$cap_empleado_original';";

		$resultado = self::consulta($query);

		return $resultado;
	}
}
?>
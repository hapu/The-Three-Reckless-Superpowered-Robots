SELECT 
    Empleado.emp_id,
    Empleado.emp_nombre,
    pst_id,
    pst_nombre,
    (SELECT 
            COUNT(*)
        FROM
            Incidencia
        WHERE
            inci_empleado = Empleado.emp_id AND inci_inicio <= '2014-01-16' AND inci_fin >= '2013-01-15') AS emp_incidencias
FROM
    Empleado
        JOIN
    Capacidad ON Empleado.emp_id = cap_empleado
        JOIN
    Puesto ON Empleado.emp_puesto = pst_id
        JOIN
    Empleado as Incidente ON cap_puesto = Incidente.emp_puesto
WHERE
    Empleado.emp_id != Incidente.emp_id AND Incidente.emp_id = '00111';



-- Listar Empleados que Coincidan
SELECT 
    emp_id, emp_nombre, pst_id, pst_nombre
FROM
    Empleado
        JOIN
    Puesto ON emp_puesto = pst_id
WHERE
    emp_nombre LIKE '%$cadena%' OR pst_nombre LIKE '%$cadena%';

-- Verificar Empleado
SELECT 
    emp_id
FROM
    Empleado
WHERE
    emp_id = '$emp_id';

-- Verificar Puesto
SELECT 
    emp_id
FROM
    Empleado
        JOIN
    Puesto ON emp_puesto = pst_id
WHERE
    pst_id = '$pst_id';

-- 	 Consultar Insidencias de un Empleado en el rango de las fechas dadas
--  	Y Mostrar Concepto de la Incidencia y Fechas
SELECT 
    inci_inicio, inci_fin, inci_concepto
FROM
    Incidencia
WHERE
    inci_empleado = '$emp_id' AND inci_inicio <= '$fecha_fin' AND inci_fin >= '$fecha_inicio';

-- 	 Consulta de empleados capaces de cubrir el puesto
-- 	 (Clave de Empleado, Nombre de Empleado
-- 	 Clave de Puesto, Nombre de Puesto
-- 	 Insidencias en el Rango de Fechas)
SELECT 
    Empleado.emp_id,
    Empleado.emp_nombre,
    pst_id,
    pst_nombre,
    (SELECT 
            COUNT(*)
        FROM
            Incidencia
        WHERE
            inci_empleado = Empleado.emp_id AND inci_inicio <= '$fecha_fin' AND inci_fin >= '$fecha_inicio') AS emp_incidencias
FROM
    Empleado
        JOIN
    Capacidad ON Empleado.emp_id = cap_empleado
        JOIN
    Puesto ON Empleado.emp_puesto = pst_id
        JOIN
    Empleado as Incidente ON cap_puesto = Incidente.emp_puesto
WHERE
    Empleado.emp_id != Incidente.emp_id AND Incidente.emp_id = '$emp_id';

-- 	 Captura de Insidencia
INSERT INTO Incidencia 
(inci_inicio, inci_fin, inci_concepto, inci_empleado, inci_usuario) 
VALUES
('$fecha_inicio', '$fecha_fin', '$concepto', '$emp_id', '$usuario');

SELECT
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
		cap_empleado = '00111');

SELECT
		Puesto.*
		FROM
		Puesto
		OUTER JOIN
		Capacidad ON cap_puesto = pst_id
		WHERE
		cap_empleado = '00111';
SELECT 
    emp_id,
    emp_nombre,
    pst_id,
    pst_nombre,
    Count(inci_empleado) as emp_incidencias
FROM
    Empleado
        LEFT JOIN
    Puesto ON emp_puesto = pst_id
        LEFT JOIN
    Capacidad ON emp_id = cap_empleado
        LEFT JOIN
    Incidencia ON emp_id = inci_empleado AND inci_inicio <= '2014_01_20' AND inci_fin >= '2014_01_10'
WHERE
    cap_puesto = '00000003'
GROUP BY emp_id;



SELECT 
    emp_id,
    emp_nombre,
    pst_id,
    pst_nombre,
    Count(inci_empleado) as emp_incidencias
FROM
    Empleado
        LEFT JOIN
    Puesto ON emp_puesto = pst_id
        LEFT JOIN
    Incidencia ON emp_id = inci_empleado AND inci_inicio <= '2014_01_20' AND inci_fin >= '2014_01_10'
WHERE
    emp_id NOT IN (SELECT 
            emp_id
        From
            Empleado
                LEFT JOIN
            Capacidad ON emp_id = cap_empleado
        WHERE
            cap_puesto = '00000003')
GROUP BY emp_id;
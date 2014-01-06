<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta name="generator" content="Bluefish 2.2.4">
<link rel="stylesheet" type="text/css" href="estilo.css">
<title>Administrar Capacidades</title>
</head>
<body>
	<form method="post" action="">
		<select name="empleado" size="5"><?php
		if($empleados_capaces !== false)
		{
			foreach ($empleados_capaces as $empleado) {
				echo '<option value="' . $empleado->emp_id . '">' . $empleado->emp_id  . ' ' . $empleado->emp_nombre . '<BR> ' . $empleado->emp_puesto . ' ' . $empleado->pst_nombre . ' ' . $empleado->emp_incidencias . ' ' . '</option>';
			}
		}?>
		</select>
		<p>
			<input type="submit" value="Enviar">
		</p>
	</form>
</body>
</html>

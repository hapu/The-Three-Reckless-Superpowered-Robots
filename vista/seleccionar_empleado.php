<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="estilo.css">
<meta charset="UTF-8">
<title>Seleccionar Empleado</title>
</head>
<body>
	<form method="post" action="">
		<p>
			Nombre o Numero <input type="text" name="empleado"
				value="<?php echo $_POST['empleado'];?>" /><input type="submit"
				value="Buscar" />
		</p>
	</form>
	<form method="post" action="">
		<select name="empleado" size="5">
			<?php
			foreach ($resultados as $empleado) {
				echo '<option value="' . $empleado->emp_id. '">' . $empleado->emp_id . ' | ' . $empleado->emp_nombre . ' | ' . $empleado->pst_id . ' | ' . $empleado->pst_nombre . '</option>';
			}
			?>
		</select>
		<p>
			<input type="submit" value="Seleccionar" />
		</p>
	</form>
</body>
</html>

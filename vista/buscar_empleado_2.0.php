<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Seleccionar Empleado</title>
</head>
<body>
	<form method="post" action="">
		<p>
			Nombre o Numero <input type="text" name="busqueda"
				value="<?php echo $_POST['busqueda'];?>" /><input type="submit"
				value="Buscar" />
		</p>
	</form>
	<?php
	if($resultados !== false)
	{
		echo '<form method="post" action="">
		<select name="empleado" size="5">';
		foreach ($resultados as $empleado) {
			echo '<option value="' . $empleado->id. '">' . $empleado->id . ' ' . $empleado->nombre .'</option>';
		}
		echo '</select> <input type="hidden" name="etapa" value="almacenar_empleado" />
		<p>
		<input type="submit" value="Enviar" />
		</p>
		</form>';
	}
	else
	{
	}
	?>
</body>
</html>

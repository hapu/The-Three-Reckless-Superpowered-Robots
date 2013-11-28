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
				value="<?php echo $_POST['busqueda'];?>" /><input type="hidden"
				name="etapa" value="seleccionar_empleado" /><input type="submit"
				value="Buscar" />
		</p>
	</form>
	<form method="post" action="">
		<select name="empleado" size="5">
			<?php
			foreach ($resultados as $empleado) {
				echo '<option value="' . $empleado->id. '">' . $empleado->id . ' ' . $empleado->nombre .'</option>';
			}
			?>
		</select> <input type="hidden" name="etapa" value="almacenar_empleado" />
		<p>
			<input type="submit" value="Enviar" />
		</p>
	</form>
</body>
</html>

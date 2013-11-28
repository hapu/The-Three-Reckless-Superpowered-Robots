<!DOCTYPE html>
<html>
<head>
<title>Evaluando Propuesta</title>
</head>
<body>
	<form method="post" action="">
		<input type="hidden" name="etapa" value="evaluacion_de_insidencia" /> <select
			name="empleado" size="5">
			<?php
			foreach ($empleados_capaces as $empleado) {
				echo '<option value="' . $empleado->id . '">' . $empleado->id . ' ' . $empleado->nombre .'</option>';
			}
			?>
		</select>
		<table>
			<?php
			foreach ($_SESSION['incidentes'] as $empleado) {
				echo '<tr><td>' . $empleado->id . '</td><td> ' . $empleado->nombre . '</td><td>' . $empleado->puesto .'</td><tr>';
			}
			?>
		</table>
		<p>
			<input type="submit" value="Enviar" />
		</p>
	</form>
</body>
</html>

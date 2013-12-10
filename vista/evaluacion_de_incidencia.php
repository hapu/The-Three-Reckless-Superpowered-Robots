<!DOCTYPE html>
<html>
<head>
<title>Evaluando Propuesta</title>
</head>
<body>
	<form method="post" action="">
		<?php
		if($empleados_capaces === false)
			echo '<input type="hidden" name="etapa" value="almacenar_incidencia" />';
		else
			echo '<input type="hidden" name="etapa" value="evaluacion_de_incidencia" />';
		?>
		<?php
		if($empleados_capaces !== false)
		{
			echo '<select name="empleado" size="5">';
			foreach ($empleados_capaces as $empleado) {
				echo '<option value="' . $empleado->emp_id . '">' . $empleado->emp_id  . ' ' . $empleado->emp_nombre . '<BR> ' . $empleado->emp_puesto . ' ' . $empleado->pst_nombre . ' ' . $empleado->emp_incidencias . ' ' . '</option>';
			}
			echo '</select>';
		}

		?>
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

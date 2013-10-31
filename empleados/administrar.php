<?php
//Login
require_once 'Login.php';
$db_server = mysql_connect($db_hostname, $db_username, $db_password);
if (!db_server)
	die("Unable to connect to MySQL: " . mysql_error());

//Seleccion de Base de Datos
mysql_select_db($db_database)
or die("Unable to select database: " . mysql_error());

$db_table = 'Empleados';

//Consultar Columnas de la Tabla
$result = mysql_query('SHOW FULL COLUMNS IN ' . $db_table . ';');
if (!$result) die ("Database access failed: " . mysql_error());
$rows = mysql_num_rows($result);

//Insertar Datos
//Revision de Parametros
$consultaCompleta = true;
for ($i = 0; $i < $rows; $i++) {
	if (empty($_POST[mysql_result($result, $i, 0)]) | $_POST[mysql_result($result, $i, 0)] == ""){
		$consultaCompleta = false;
	}
}


if ($consultaCompleta)
{
	//Formar Consulta para Insercion
	$query = 'INSERT INTO ' . $db_table . '(';
	$query .= mysql_result($result, 0, 0);
	for ($i = 1; $i < $rows; $i++) {
		$query .= ', ' . mysql_result($result, $i, 0) ;
	}
	$query .= ') VALUES(';
	$query .= $_POST[mysql_result($result, 0, 0)];
	for ($i = 1; $i < $rows; $i++) {
		$query .= ', \'' . $_POST[mysql_result($result, $i, 0)] . '\'';
	}
	$query .= ');';
	//Realizar Insercion
	//echo $query;
	if(!mysql_query($query))
		echo mysql_error();
}


//Imprimir Inputs
echo '<form method="post" action="Empleados.php"/>';
for ($i = 0; $i < $rows; $i++) {
	echo mysql_result($result, $i, 8);
	echo '<br><input type="text" name="' . mysql_result($result, $i, 0) . '" /><br><br>';
}
echo '<input type="submit" >';
echo "<br>";
echo "<br>";

//Imprimir Tabla
//Titulos
echo '<table border="1">';
echo "<tr>";
for ($i = 0; $i < $rows; $i++) {
	echo '<th>' . mysql_result($result, $i, 8) . '</th>';
}
echo '<th>Acciones</th>';
echo '</tr>';
//Campos
$result = mysql_query("SELECT * FROM $db_table");
if (!$result) die ("Database access failed: " . mysql_error());
$rows = mysql_num_rows($result);
for ($i = 0; $i < $rows; $i++) {
	$row = mysql_fetch_row($result);
	echo "</tr>";
	foreach ($row as $value) {
		echo "<td> $value </td>";
	}
	echo '<td>Boton</td>';
	echo "</tr>";
}
mysql_close($db_server);
?>
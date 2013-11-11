<?php

// Inicialisacion
require_once 'puesto.php';
$tronco = new Puesto();

// Lectura
$tronco = unserialize(file_get_contents("Tree.txt"));
// $tronco = leer_arbol_de_la_base_de_datos("001");



// Impresion
imprimir($tronco);

agregar_nodo_a_la_base_de_datos($tronco);

// Escritura
// file_put_contents("Tree.txt", serialize($tronco));

// Buscar Nodo
// $nodoTemp = buscarNodo($tronco, "006");
// imprimir($nodoTemp);

// Bandera
print __LINE__."\n";

function imprimir($nodo)
{
	if(empty($nodo)){
		echo "Nodo Vacio <BR>";
		return;
	}

	echo "<UL>";
	imprimirRecursivo($nodo);
	echo "</UL>";
}

function imprimirRecursivo(Puesto $nodo)
{
	echo "<LI>" . $nodo->getIdPuesto() . " " . $nodo->getNombrePuesto() . "</LI>";

	$suplentes = $nodo->getPuestosSuplentes();
	$cantSuplentes = count($suplentes);
	if ($cantSuplentes > 0){
		echo "<UL>";
		foreach ($suplentes as $sup)
			if(isset($sup)) imprimirRecursivo($sup);
		echo "</UL>";
	}
}

function buscarNodo(Puesto $nodo, $idPuesto)
{
	if ($nodo->getIdPuesto() === $idPuesto) return $nodo;

	$puestosSuplentes = $nodo->getPuestosSuplentes();
	if (isset($puestosSuplentes)){
		foreach ($puestosSuplentes as $sup)
		{
			$tempNodo = buscarNodo($sup, $idPuesto);
			if (isset($tempNodo)) return $tempNodo;
		}
	}

	else return null;
}

function conexion()
{
	require	 ('../Login.php');
	$db_server = new mysqli($db_hostname, $db_username, $db_password, $db_database);
	if ($db_server->connect_errno)
		die('Connect Error (' . $db_server->connect_errno . ') ' . $db_server->connect_error);
	return $db_server;
}

function leer_arbol_de_la_base_de_datos($id)
{
	$db_server = conexion();
	$result = $db_server->query("SELECT
			`Puesto`.`pst_id`,
			`Puesto`.`pst_nombre`
			FROM `CFE`.`Puesto`
			WHERE `pst_id` = '$id';");
	$row = $result->fetch_row();
	$nodo = new Puesto();
	$nodo->setIdPuesto($row[0]);
	$nodo->setNombrePuesto($row[1]);
	$db_server->close();
	return $nodo;
}

function agregar_nodo_a_la_base_de_datos(Puesto $nodo)
{
	$db_server = conexion();

	$puesto_id = $nodo->getIdPuesto();
	$puesto_nombre = $nodo->getNombrePuesto();

	$result = $db_server->query("INSERT INTO `CFE`.`Puesto`
			(`pst_id`,
			`pst_nombre`)
			VALUES
			(
			'$puesto_id',
			'$puesto_nombre'
	);
			");
	echo $db_server->affected_rows . '<BR>';

	$suplentes = $nodo->getPuestosSuplentes();

	foreach ($suplentes as $sup) {
		$subpuesto_id = $sup->getIdPuesto();
		$result = $db_server->query("INSERT INTO `CFE`.`Subpuesto`
				(`spt_puesto_superior`,
				`spt_puesto_inferior`)
				VALUES
				(
				'$puesto_id',
				'$subpuesto_id'
		);");
		echo $db_server->affected_rows . '<BR>';

		// 		echo("INSERT INTO `CFE`.`Subpuesto`
		// 				(`spt_puesto_superior`,
		// 				`spt_puesto_inferior`)
		// 				VALUES
		// 				(
		// 				'$puesto_id',
		// 				'$subpuesto_id'
		// 		);<BR>");
		// 		echo $db_server->error;
		;
	}

	$db_server->close();
	foreach ($suplentes as $sup)
		if(isset($sup)) agregar_nodo_a_la_base_de_datos($sup);
}
?>
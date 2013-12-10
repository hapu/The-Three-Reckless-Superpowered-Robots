<?php

// Inicialisacion
require_once ('../test/modelo.class.php');
$tronco = new Puesto();

// Lectura
// $tronco = unserialize(file_get_contents("Tree.txt"));
$tronco = leer_arbol_de_la_base_de_datos("001");



// Impresion
imprimir($tronco);

// Escritura
Modelo::agregar_nodo_a_la_base_de_datos($tronco);
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
?>
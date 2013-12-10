<?php
class Puesto
{
	private $idPuesto;
	private $nombrePuesto;
	private $puestosSuplentes;

	function setIdPuesto($idPuesto) {
		$this->idPuesto = $idPuesto;
	}

	function getIdPuesto() {
		return $this->idPuesto;
	}


	function setNombrePuesto($nombrePuesto)
	{
		$this->nombrePuesto = $nombrePuesto;
	}

	function getNombrePuesto()
	{
		return $this->nombrePuesto;
	}


	function setPuestosSuplentes($puestosSuplentes)
	{
		$this->puestosSuplentes = $puestosSuplentes;
	}

	function getPuestosSuplentes()
	{
		return $this->puestosSuplentes;
	}
}
?>
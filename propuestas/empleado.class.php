<?php
require_once("puesto.class.php");

class Empleado
{
    var $id;                          // entero
    var $nombre;                      // cadena
    var $puesto;                      // objeto de la clase puesto
    var $capacidades;                 // arreglo de objetos puesto
    var $fecha_termino_de_contrato;   // tipo fecha

    function __construct()
    {
         //base de datos
    }
}
?>
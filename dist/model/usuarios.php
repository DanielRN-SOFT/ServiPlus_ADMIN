<?php

class Usuarios
{
    private $id;
    private $nombre;
    private $cargo;
    private $rol;

    public function __construct($id = null, $nombre = null, $cargo = null)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->cargo = $cargo;
    }

    // ID
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    // Nombre
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    // Cargo
    public function setRol($cargo)
    {
        $this->cargo = $cargo;
    }

    public function getRol()
    {
        return $this->cargo;
    }

    public function setNombreRol($rol){
        $this->rol = $rol;
    }

    public function getNombreRol(){
        return $this->rol;
    }
}

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Departamentos
 *
 * @author David Garcia
 * @ORM\Entity
 */
class Departamento {

    /**
     *
     * @ORM\Id()
     * @ORM\Column(type="string", length=3)
     */
    private $codDepartamento;

    /**
     *
     * @ORM\Column(type="string", length=255)
     */
    private $descDepartamento;

    /**
     *
     * @ORM\Column(type="integer")
     */
    private $volumenNegocio;

    /**
     *
     * @ORM\Column(type="datetime", options={"default" : "CURRENT_TIMESTAMP"})
     */
    private $fechaCreacion;

    /**
     *
     * @ORM\Column(type="datetime", nullable=true, options={"default" : null})
     */
    private $fechaBajaLogica;

    function __construct($codDepartamento, $descDepartamento, $volumenNegocio, $fechaCreacion, $fechaBajaLogica) {
        $this->codDepartamento = $codDepartamento;
        $this->descDepartamento = $descDepartamento;
        $this->volumenNegocio = $volumenNegocio;
        $this->fechaCreacion = $fechaCreacion;
        $this->fechaBajaLogica = $fechaBajaLogica;
    }

    function getCodDepartamento() {
        return $this->codDepartamento;
    }

    function getDescDepartamento() {
        return $this->descDepartamento;
    }

    function getVolumenNegocio() {
        return $this->volumenNegocio;
    }

    function getFechaCreacion() {
        return $this->fechaCreacion;
    }

    function getFechaBajaLogica() {
        return $this->fechaBajaLogica;
    }

    function setCodDepartamento($codDepartamento) {
        $this->codDepartamento = $codDepartamento;
    }

    function setDescDepartamento($descDepartamento) {
        $this->descDepartamento = $descDepartamento;
    }

    function setVolumenNegocio($volumenNegocio) {
        $this->volumenNegocio = $volumenNegocio;
    }

    function setFechaCreacion($fechaCreacion) {
        $this->fechaCreacion = $fechaCreacion;
    }

    function setFechaBajaLogica($fechaBajaLogica) {
        $this->fechaBajaLogica = $fechaBajaLogica;
    }

}

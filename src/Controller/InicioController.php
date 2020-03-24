<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Driver\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * 
 * @Route("/inicio")
 */
class InicioController extends AbstractController {

    /**
     * 
     *  @Route("/", name="index")
     */
    public function index(Connection $conexion) {

        return $this->render("inicio/index.html.twig");
    }

}

<?php

namespace App\Controller;

use App\Entity\Usuario;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Driver\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\DBAL\ParameterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

/**
 * Description of PerfilController
 *
 * @author Arzurian
 * @Route("/perfil")
 */
class PerfilController extends AbstractController {

    /**
     * @Route("/", name="perfil_index")
     */
    public function index() {
        return $this->render("perfil/index.html.twig");
    }

    /**
     * @Route("/editar", name="editar_perfil", methods={"GET", "POST"})
     */
    public function edit(Connection $conexion, Request $request) {
        $queryBuilder = $conexion->createQueryBuilder();
        $form = $this->createFormBuilder()
                ->add("usuario", TextType::class)
                ->add("cod_usuario", HiddenType::class)
                ->add("descripcion", TextType::class)
                ->getForm()
        ;
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $queryBuilder
                    ->update("usuario")
                    ->set("descripcion", "?")
                    ->where("username = ?")
                    ->setParameter(0, $form->get("descripcion")->getData(), ParameterType::STRING)
                    ->setParameter(1, $form->get("cod_usuario")->getData(), ParameterType::STRING)
                    ->execute()
            ;
            return $this->redirectToRoute("perfil_index");
        }

        return $this->render("perfil/editar.html.twig", [
                    'form' => $form->createView()
        ]);
    }

    /**
     * 
     * @Route("/editar/password", name="editar_password", methods={"GET", "POST"})
     */
    public function editPassword(Connection $conexion, Request $request) {

        $queryBuilder = $conexion->createQueryBuilder();
        $form = $this->createFormBuilder()
                ->add("cod_usuario", HiddenType::class)
                ->add("pass_vieja", PasswordType::class)
                ->add("pass_nueva_uno", PasswordType::class)
                ->add("pass_nueva_dos", PasswordType::class)
                ->getForm()
        ;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $passVieja = $request->get("pass_vieja")->getData();
            $passNuevaUno = $request->get("pass_nueva_uno")->getData();
            $passNuevaDos = $request->get("pass_nueva_dos")->getData();
            
            
            
            
            $queryBuilder
                    ->update("usuario")
                    ->set("descripcion", "?")
                    ->where("username = ?")
                    ->setParameter(0, $form->get("descripcion")->getData(), ParameterType::STRING)
                    ->setParameter(1, $form->get("cod_usuario")->getData(), ParameterType::STRING)
                    ->execute()
            ;
            return $this->redirectToRoute("perfil_index");
        }
        
        
        
        return $this->render("perfil/editar_password.html.twig", [
                    "form" => $form->createView()
        ]);
    }

}

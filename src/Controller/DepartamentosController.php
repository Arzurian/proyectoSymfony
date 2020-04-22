<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Entity\Departamentos;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\DBAL\ParameterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

/**
 * Description of DepartamentosController
 *
 * @author David Garcia
 * @Route("/departamentos")
 */
class DepartamentosController extends AbstractController {

    /**
     * 
     * @Route("/", name="departamentos_index")
     */
    public function index(Connection $conexion): Response {

        $queryBuilder = $conexion->createQueryBuilder();
        $queryBuilder
                ->select("*")
                ->from("departamento")
        ;
        $departamentos = $queryBuilder->execute()->fetchAll();
        return $this->render("departamentos/index.html.twig", [
                    "departamentos" => $departamentos,
        ]);
    }

    /**
     * 
     * @Route("/nuevo", name="departamento_nuevo", methods={"GET", "POST"})
     */
    public function new(Connection $conexion, Request $request) {

        $queryBuilder = $conexion->createQueryBuilder();
        $form = $this->createFormBuilder()
                ->add("cod_departamento", TextType::class)
                ->add("desc_departamento", TextType::class)
                ->add("volumen_negocio", IntegerType::class)
                ->getForm()
        ;

        $form->handleRequest($request);
//        $conexion->beginTransaction();
        if ($form->isSubmitted() && $form->isValid()) {
            $codDepartamento = strtoupper($form->get("cod_departamento")->getData());
            $descDepartamento = $form->get("desc_departamento")->getData();
            $volumen = $form->get("volumen_negocio")->getData();
            try {
                $queryBuilder
                        ->insert("departamento")
                        ->setValue("cod_departamento", ":cod_departamento")
                        ->setValue("desc_departamento", ":desc_departamento")
                        ->setValue("volumen_negocio", ":volumen_negocio")
                        ->setParameter(":cod_departamento", $codDepartamento, ParameterType::STRING)
                        ->setParameter(":desc_departamento", $descDepartamento, ParameterType::STRING)
                        ->setParameter(":volumen_negocio", $volumen, ParameterType::INTEGER)
                ;
                $queryBuilder->execute();
//                $conexion->beginTransaction();
            } catch (\Exception $exc) {
//                $conexion->rollBack();
                return $this->redirectToRoute("departamento_nuevo", [
                            "codigo" => $codDepartamento,
                            "descripcion" => $descDepartamento,
                            "volumen" => $volumen,
                            "form" => $form->createView()
                ]);
            } finally {
                
            }
            return $this->redirectToRoute("departamentos_index");
        }

        return $this->render("departamentos/nuevo.html.twig", [
                    "form" => $form->createView()
        ]);
    }

    /**
     * 
     * @Route("/departamento/{cod_departamento}", name="ver_departamento", methods={"GET"})
     */
    public function show(Connection $conexion, $cod_departamento) {
        $queryBuilder = $conexion->createQueryBuilder();
        $queryBuilder
                ->select("*")
                ->from("departamento")
                ->where("cod_departamento=?")
                ->setParameter(0, $cod_departamento)

        ;

        $departamento = $queryBuilder->execute()->fetch();

        return $this->render("departamentos/mostrar.html.twig", [
                    "departamento" => $departamento
        ]);
    }

    /**
     * 
     * @Route("/editar/{cod_departamento}", name="editar_departamento", methods={"GET", "POST"})
     */
    public function edit(Connection $conexion, Request $request, $cod_departamento) {
        $queryBuilder = $conexion->createQueryBuilder();
        $queryBuilder
                ->select("*")
                ->from("departamento")
                ->where("cod_departamento=?")
                ->setParameter(0, $cod_departamento)
        ;
        $departamento = $queryBuilder->execute()->fetch();

        $form = $this->createFormBuilder($departamento)
                ->add("cod_departamento", TextType::class, ["disabled" => true])
                ->add("desc_departamento", TextType::class)
                ->add("volumen_negocio", IntegerType::class)
                ->getForm()
        ;

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $queryBuilder
                    ->update("departamento")
                    ->set("desc_departamento", "?")
                    ->set("volumen_negocio", "?")
                    ->setParameter(0, $form->get("desc_departamento")->getData(), ParameterType::STRING)
                    ->setParameter(1, $form->get("volumen_negocio")->getData(), ParameterType::INTEGER)
                    ->setParameter(2, $cod_departamento, ParameterType::STRING)
                    ->execute()
            ;
            return $this->redirectToRoute("departamentos_index");
        }


        return $this->render("departamentos/editar.html.twig", [
                    "departamento" => $departamento,
                    "form" => $form->createView()
        ]);
    }

    /**
     * 
     * @Route("/{cod_departamento}", name="borrar_departamento", methods={"DELETE"})
     */
    public function delete(Connection $conexion, Request $request, $cod_departamento) {
        if ($this->isCsrfTokenValid('delete', $request->request->get('_token'))) {
            $queryBuilder = $conexion->createQueryBuilder();
            $queryBuilder
                    ->delete("departamento")
                    ->where("cod_departamento = :cod")
                    ->setParameter(":cod", $cod_departamento)
                    ->execute()
            ;
        }
        return $this->redirectToRoute("departamentos_index");
    }

}

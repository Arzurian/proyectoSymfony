<?php

namespace App\Controller;

use App\Form\UsuarioFormType;
use App\Entity\Usuario;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\ParameterType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistroController extends AbstractController {

    /**
     * 
     * @Route("/registro", name="registro")
     */
    public function registro(Request $request, UserPasswordEncoderInterface $passwordEncode, Connection $conexion) {
        $usuario = new Usuario();
        $form = $this->createForm(UsuarioFormType::class, $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $queryBuilder = $conexion->createQueryBuilder();
            $passHash = $passwordEncode->encodePassword($usuario, $form->get("password")->getData());

            $queryBuilder
                    ->insert("usuario")
                    ->setValue("username", ":usuario")
                    ->setValue("roles", ":rol")
                    ->setValue("password", ":pass")
                    ->setValue("descripcion", ":desc")
                    ->setParameter(":usuario", $form->get("username")->getData())
                    ->setParameter(":rol", '["ROLE_USER"]')
                    ->setParameter(":pass", $passHash)
                    ->setParameter(":desc", $form->get("descripcion")->getData())
                    ->execute()
            ;
            return $this->redirectToRoute("index");
        }

        return $this->render('registro/registro.html.twig', [
            "registro" => $form->createView()
        ]);
    }

}

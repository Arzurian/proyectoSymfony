<?php
//Fichero generado, editado por mi
namespace App\Form;

use App\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsuarioFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('username')
                ->add('password', PasswordType::Class, [
                    "constraints" => [
                        new NotBlank([
                            "message" => "Campo vacio"
                                ]),
                        new Length([
                            "min" => 4,
                            "minMessage" => "Logitud minima {{ limit }} caracteres",
                            "max" => 4096
                                ])
                    ]
                ])
                ->add('descripcion')
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Usuario::class,
        ]);
    }
}

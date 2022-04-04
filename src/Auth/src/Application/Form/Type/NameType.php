<?php
declare(strict_types=1);

namespace Auth\Application\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class NameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('first', TextType::class, [
                'attr' => [
//                    'class' => 'form-control form-control-sign-up',
//                    'class' => 'form-control form-control-sign-up',
                    'placeholder' => 'First Name'
                ],
            ])
            ->add('last', TextType::class, [
                'attr' => [
//                    'class' => 'form-control form-control-user',
//                    'class' => 'form-control form-control-sign-up',
                    'placeholder' => 'Last Name'
                ],
            ])
        ;
    }
}
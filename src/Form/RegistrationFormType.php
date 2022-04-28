<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationFormType extends AbstractType
{
    /**
     * Permet d'avoir la configuration de base d'un champ
     *
     * @param [type] $label
     * @param [type] $maxlength
     * @param [type] $required
     * @param array $options
     * @return array
     */
    public function getConfiguration($label, $placeholder, $maxlength, $required, $options = []) {
        return array_merge([
            'label' => $label,
            'attr' => [
                'class' => 'form-control',
                'placeholder' => $placeholder,
                'maxlength' => $maxlength
            ],
            'row_attr' => [
                'class' => 'form-group'
            ],
            'required' => $required
        ], $options);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, $this->getConfiguration('Prénom', 'John', '20', true))
            ->add('lastName', TextType::class, $this->getConfiguration('Nom', 'Doe', '20', true))
            ->add('email', EmailType::class, $this->getConfiguration('Email', 'john.doe@symfony.com', '255', true))
            ->add('avatar', UrlType::class, $this->getConfiguration('Avatar', '', '255', false))
            ->add('password', PasswordType::class, $this->getConfiguration('Mot de passe', '', '255', true))
            //->add('passwordConfirm', PasswordType::class, $this->getConfiguration('Confirmation du mot de passe', '255', true))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserRegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => array('autocomplete' => 'off'),
            ])
            ->add('name', null, [
                'attr' => array('autocomplete' => 'off')
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match',
                'required' => true,
                'first_options'  => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password']
            ])
            ->add('dateOfBirth', DateType::class, [
                'format' => 'dd - MM - yyyy',
                'years' => $this->dateOfBirthArrayGenerator()
            ])
            ->add('male', RadioType::class, [
                'value' => '1',
            ])
            ->add('male', ChoiceType::class, [
//                'value' => '0',
            'expanded' => true,
                'trim' => true,
                'choices'  => [
                    'Man' => 0,
                    'Woman' => 1,
                ],
            ])
        ;
    }

    public function dateOfBirthArrayGenerator(): array {
        for ($i = date("Y") - 10; $i >= 1950; $i--){
            $years[] = $i;
        }
        return $years;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }
}

<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',null, [
//                'attr' => ['maxlength' => 12],
            'attr' => array('autocomplete' => 'off'),
                'constraints' => [
//                    new Length(['min' => 4, 'max' => 12]),
                    new NotBlank()
                ],
            ])
            ->add('price', null, [
                'attr' => array('autocomplete' => 'off'),
                'constraints' => [
                    new Type([
                        'type' => 'float',
                        'message' => 'Field Price shold be type {{ type }}',
                    ]),
//                    new Length([
//                        'min' => 4,
//                        'minMessage' => 'min 4'
//                    ])
                ],
            ])
            ->add('qty', null, [
                'attr' => array('autocomplete' => 'off'),
            ])
            ->add('category', EntityType::class, ['class' => Category::class, 'choice_label' => 'name'])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'name',
                 'multiple' => true,
//                 'expanded' => true,
            'required' => false
            ])
            ->add('image', FileType::class,[
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new Image()
                ],
            ])
//            ->getForm()
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}

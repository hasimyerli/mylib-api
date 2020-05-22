<?php

namespace App\Form\UserBookType;


use App\Entity\UserBook;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class SaveUserBookType extends UserBookType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add(
                  'bookId',
                        NumberType::class,
                        [
                            'mapped' => false,
                            'constraints' => [new NotBlank()]
                        ]
            );
    }
}
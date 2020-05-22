<?php

namespace App\Form;


use App\Entity\UserBook;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserBookType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                  'bookId',
                        NumberType::class,
                        [
                            'mapped' => false,
                            'constraints' => [new NotBlank()]
                        ]
            )
            ->add(
                  'listIds',
                        CollectionType::class,
                        [
                            'allow_add' => true,
                            'entry_type' => NumberType::class,
                            'mapped' => false,
                            'prototype' => true,
                        ]
            )
            ->add(
                  'tagIds',
                        CollectionType::class,
                        [
                            'allow_add' => true,
                            'entry_type' => NumberType::class,
                            'mapped' => false,
                            'prototype' => true,
                        ]
            )
            ->add(
                'note',
                TextType::class
            )
            ->add(
                'editionNumber',
                CollectionType::class, [
                    'entry_type' => NumberType::class,
                    'allow_add' => true,
                    'prototype' => true,
                ]
            );
    }

    public function getCustomConfigureOptions()
    {
        return [
            'data_class' => UserBook::class,
        ];
    }
}
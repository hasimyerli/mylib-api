<?php

namespace App\Form\UserBookType;


use App\Entity\UserBook;
use App\Form\BaseType;
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
                'listIds',
                CollectionType::class,
                [
                    'allow_add' => true,
                    'entry_type' => NumberType::class,
                    'prototype' => true,
                ]
            )
            ->add(
                'tagIds',
                CollectionType::class,
                [
                    'allow_add' => true,
                    'entry_type' => NumberType::class,
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
<?php


namespace App\Form;

use App\Entity\User;
use App\Model\BaseFilterModel;
use App\Model\BookFilterModel;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Regex;

class BookListType extends BaseListType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add(
                'authorIds',
                CollectionType::class,
                [
                    'allow_add' => true,
                    'entry_type' => NumberType::class,
                    'mapped' => false,
                    'prototype' => true,
                    'required' => false,
                ]
            )
            ->add(
                'barcode',
                TextType::class,
                [
                    'constraints' => [
                        new Length([
                            'min' => 0,
                            'max' => 13,
                        ])
                    ],
                    'empty_data' => '',
                    'mapped' => true,
                    'required' => false,
                ]
            )
            ->add(
                'categoryIds',
                CollectionType::class,
                [
                    'allow_add' => true,
                    'entry_type' => NumberType::class,
                    'mapped' => false,
                    'prototype' => true,
                    'required' => false,
                ]
            )
            ->add(
                'languageIds',
                CollectionType::class,
                [
                    'allow_add' => true,
                    'entry_type' => NumberType::class,
                    'mapped' => false,
                    'prototype' => true,
                    'required' => false,
                ]
            )
            ->add(
                'publisherIds',
                CollectionType::class,
                [
                    'allow_add' => true,
                    'entry_type' => NumberType::class,
                    'mapped' => false,
                    'prototype' => true,
                    'required' => false,
                ]
            )
            ->add(
                'rateValues',
                CollectionType::class,
                [
                    'allow_add' => true,
                    'entry_type' => NumberType::class,
                    'mapped' => false,
                    'prototype' => true,
                    'required' => false,
                ]
            )
            ->add(
                'translatorIds',
                CollectionType::class,
                [
                    'allow_add' => true,
                    'entry_type' => NumberType::class,
                    'mapped' => false,
                    'prototype' => true,
                    'required' => false,
                ]
            );

    }

    public function getCustomConfigureOptions()
    {
        return [
            'data_class' => BookFilterModel::class
        ];
    }
}

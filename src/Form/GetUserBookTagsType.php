<?php


namespace App\Form;

use App\Entity\User;
use App\Entity\UserBookTag;
use App\Model\BaseFilterModel;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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

class GetUserBookTagsType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'searchText',
                null,
                [
                    'constraints' => [
                        new Length([
                            "max" => 255,
                        ])
                    ],
                    'empty_data' => '',
                    'mapped' => true,
                    'required' => false,
                ]
            )
            ->add(
                'sort',
                ChoiceType::class,
                [
                    'choices' => [
                       'id',
                       'name'
                    ],
                    'mapped' => true
                ]
            )
            ->add(
                'order',
                ChoiceType::class,
                [
                    'choices' => [
                        'asc',
                        'desc'
                    ],
                    'mapped' => true
                ]
            )
            ->add(
                'page',
                IntegerType::class,
                [
                    'constraints' => [
                        new Range([
                            'min' => 1,
                        ])
                     ],
                    'mapped' => true,
                ]
            );

    }

    public function getCustomConfigureOptions()
    {
        return [
            'data_class' => BaseFilterModel::class
        ];
    }
}

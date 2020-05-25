<?php


namespace App\Form;

use App\Entity\User;
use App\Entity\UserBookTag;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class UserBookTagType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'constraints' => [
                        new NotBlank(),
                        new Length([
                            "max" => 255
                        ])
                    ]
                ]
            )
            ->add(
                'color',
                TextType::class,
                [
                    'constraints' => [
                        new Length([
                            "max" => 10,

                        ]),
                        new NotBlank(),
                        new Regex(['pattern' => '/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', 'match' => true, 'message' => $this->translator->trans('error.user_book.tag.color_invalid')])
                    ]
                ]
            );

    }

    public function getCustomConfigureOptions()
    {
        return [
            'data_class' => UserBookTag::class,
        ];
    }
}

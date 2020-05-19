<?php


namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class UserProfileUpdateType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'firstName',
                TextType::class,
                [
                    'constraints' => [new NotBlank()],
                ]
            )
            ->add(
                'lastName',
                TextType::class,
                [
                    'constraints' => [new NotBlank()],
                ]
            )
            ->add(
                'mobilePhone',
                TextType::class,
                [
                    'constraints' => [
                        new Regex(['pattern' => '/(^05)+[0-9]{9}+$/', 'match' => true, 'message' => 'Geçerli bir değer giriniz.'])
                    ],
                ]
            )
            ->add(
                'password',
                PasswordType::class,
                [
                    'constraints' => [
                        new Length(['min' => User::PASSWORD_MAX_LENGTH])
                    ]
                ]
            )
            ->add(
                'profileImage',
                TextType::class,
                [
                    'constraints' => [
                        new Regex(['pattern' => '/data:image\/([a-zA-Z]*);base64,([^\"]*)/', 'match' => true, 'message' => 'Resim geçersiz.'])
                    ]
                ]
            );
    }

    public function getCustomConfigureOptions()
    {
        return [
            'data_class' => User::class,
        ];
    }
}

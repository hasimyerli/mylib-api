<?php


namespace App\Form\CommentType;

use App\Entity\Comment;
use App\Form\BaseType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class CommentUpdateType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
            'text',
            TextType::class,
            [
                'constraints' => [
                    new NotBlank()
                ]
            ]
            );
    }

    public function getCustomConfigureOptions()
    {
        return [
            'data_class' => Comment::class,
        ];
    }
}

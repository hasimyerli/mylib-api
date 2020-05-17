<?php


namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class BaseType extends AbstractType
{
    public abstract function getCustomConfigureOptions();

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array_merge(
                [
                    'csrf_protection' => false,
                ],
                $this->getCustomConfigureOptions()
            )
        );
    }
}

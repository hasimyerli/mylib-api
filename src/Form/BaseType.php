<?php


namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

abstract class BaseType extends AbstractType
{
    protected $translator;
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

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

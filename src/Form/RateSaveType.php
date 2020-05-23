<?php


namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

class RateSaveType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'value',
            IntegerType::class,
            [
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Range([
                        'min' => 1,
                        'max' => 5,
                        'notInRangeMessage' => $this->translator->trans('validation.rate.invalid_range')
                    ])
                ]
            ]
        );
    }

    public function getCustomConfigureOptions()
    {
        return [];
    }
}

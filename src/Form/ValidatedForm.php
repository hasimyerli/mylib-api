<?php


namespace App\Form;


class ValidatedForm
{
    private $valid;
    private $validations;

    public function isValid():bool
    {
        return $this->valid;
    }

    /**
     * @param bool $valid
     */
    public function setValid(bool $valid)
    {
        $this->valid = $valid;
    }

    /**
     * @return array
     */
    public function getValidations(): array
    {
        return $this->validations;
    }

    /**
     * @param array $validations
     */
    public function setValidations(array $validations)
    {
        $this->validations = $validations;
    }

}
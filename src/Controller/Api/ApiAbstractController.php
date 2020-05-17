<?php

namespace App\Controller\Api;


use App\Form\ValidatedForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class ApiAbstractController extends AbstractController
{
    protected function getFormValidations(FormInterface $form)
    {
        $errors = array();
        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }
        foreach ($form->all() as $childForm) {
            if ($childForm instanceof FormInterface && ($childErrors = $this->getFormValidations($childForm))) {
                $errors[$childForm->getName()] = $childErrors;
            }
        }
        return $errors;
    }

    /**
     * @param $formType
     * @param $entity
     * @param Request $request
     * @return ValidatedForm
     */
    protected function ValidForm($formType, $entity, Request $request)
    {
        $validatedForm = new ValidatedForm();

        $form =  $this->createForm($formType, $entity);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        $validatedForm->setValid($form->isSubmitted() && $form->isValid());
        $validatedForm->setValidations($this->getFormValidations($form));

        return $validatedForm;
    }
}



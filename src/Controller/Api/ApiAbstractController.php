<?php

namespace App\Controller\Api;


use App\Form\ValidatedForm;
use App\Response\ApiResponse\JsonFailureResponse;
use App\Util\ExceptionUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;

class ApiAbstractController extends AbstractController
{
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

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
     * @param array $requestParams
     */
    protected function validateForm($formType, $entity, $request, &$requestParams = [])
    {
        $validatedForm = new ValidatedForm();

        $form =  $this->createForm($formType, $entity);
        $requestParams = json_decode($request->getContent(), true);
        $form->submit($requestParams);

        $validatedForm->setValid($form->isSubmitted() && $form->isValid());
        $validatedForm->setValidations($this->getFormValidations($form));

        if(!$validatedForm->isValid()) {
            ExceptionUtil::throwException(
                JsonFailureResponse::build()
                ->setMessage($this->translator->trans('error.form'))
                ->setValidations($validatedForm->getValidations()
            ));
        }
    }


}




<?php

namespace AppBundle\Service;


use Symfony\Component\Form\FormInterface;

/**
 * Class FormError
 * @package AppBundle\Service
 */
class FormError
{
    /**
     * @var FormInterface
     */
    private $form;

    /**
     * FormError constructor.
     * @param FormInterface $form
     */
    public function __construct(FormInterface $form)
    {
        $this->form = $form;
    }

    /**
     * @return array
     */
    public function getErrorDetails()
    {
        return [
            'error' => 1,
            'message' => 'Validation Error',
            'validation_errors' => $this->getFormErrors(),
        ];
    }

    /**
     * @return array
     */
    private function getFormErrors()
    {
        $errors = [];
        foreach ($this->form->getErrors(true, false) as $error) {
            $errors[] = $error->getMessage();
        }

        return $errors;
    }
}
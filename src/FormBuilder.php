<?php

declare(strict_types=1);

namespace Pollen\Form;

class FormBuilder implements FormBuilderInterface
{
    /**
     * @var FormInterface
     */
    private $form;

    /**
     * @param FormInterface $form
     */
    public function __construct(FormInterface $form)
    {
        $this->form = $form;
    }

    /**
     * @inheritDoc
     */
    public function get(): FormInterface
    {
        if (!$this->form->isBooted()) {
            $this->form->boot();
        }
        return $this->form;
    }
}
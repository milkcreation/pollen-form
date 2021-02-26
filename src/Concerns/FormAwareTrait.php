<?php

declare(strict_types=1);

namespace Pollen\Form\Concerns;

use Pollen\Form\FormInterface;

trait FormAwareTrait
{
    /**
     * Instance du formulaire associé.
     * @var FormInterface|null
     */
    private $form;

    /**
     * Récupération de l'instance du formulaire associé.
     *
     * @return FormInterface
     */
    public function form(): FormInterface
    {
        return $this->form;
    }

    /**
     * Définition de l'addon associé.
     *
     * @param FormInterface $form
     *
     * @return static
     */
    public function setForm(FormInterface $form): FormAwareTrait
    {
        $this->form = $form;

        return $this;
    }
}
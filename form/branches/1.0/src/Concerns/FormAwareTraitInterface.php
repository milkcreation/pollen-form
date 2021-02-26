<?php

declare(strict_types=1);

namespace Pollen\Form\Concerns;

use Pollen\Form\FormInterface;

interface FormAwareTraitInterface
{
    /**
     * Récupération de l'instance du formulaire associé.
     *
     * @return FormInterface
     */
    public function form(): FormInterface;

    /**
     * Définition de l'addon associé.
     *
     * @param FormInterface $form
     *
     * @return FormAwareTrait
     */
    public function setForm(FormInterface $form): FormAwareTrait;
}
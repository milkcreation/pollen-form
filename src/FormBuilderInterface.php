<?php

declare(strict_types=1);

namespace Pollen\Form;

interface FormBuilderInterface
{
    /**
     * Récupération de l'instance du formulaire.
     * 
     * @return FormInterface
     */
    public function get(): FormInterface;
}
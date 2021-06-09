<?php

declare(strict_types=1);

namespace Pollen\Form\Concerns;

use Pollen\Form\AddonDriverInterface;
use Pollen\Form\FormInterface;

interface FormAddonAwareTraitInterface
{
    /**
     * Récupération de l'instance de l'addon associé.
     *
     * @return AddonDriverInterface
     */
    public function formAddon(): AddonDriverInterface;

    /**
     * Récupération de l'instance du formulaire associé.
     *
     * @return FormInterface
     */
    public function form(): FormInterface;

    /**
     * Définition de l'addon associé.
     *
     * @param AddonDriverInterface $formAddon
     *
     * @return FormAddonAwareTraitInterface
     */
    public function setFormAddon(AddonDriverInterface $formAddon): FormAddonAwareTraitInterface;
}
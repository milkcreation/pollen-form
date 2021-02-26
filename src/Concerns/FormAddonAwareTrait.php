<?php

declare(strict_types=1);

namespace Pollen\Form\Concerns;

use LogicException;
use Pollen\Form\AddonDriverInterface;
use Pollen\Form\FormInterface;

trait FormAddonAwareTrait
{
    /**
     * Instance de l'addon de formulaire associé.
     * @var AddonDriverInterface|null
     */
    private $formAddon;

    /**
     * Instance du formulaire associé.
     * @var FormInterface|null
     */
    private $form;

    /**
     * Récupération de l'instance de l'addon associé.
     *
     * @return AddonDriverInterface
     */
    public function formAddon(): AddonDriverInterface
    {
        if ($this->formAddon instanceof AddonDriverInterface) {
            return $this->formAddon;
        }

        throw new LogicException('Unavailable related Form addon');
    }

    /**
     * Récupération de l'instance du formulaire associé.
     *
     * @return FormInterface
     */
    public function form(): FormInterface
    {
        return $this->formAddon()->form();
    }

    /**
     * Définition de l'addon associé.
     *
     * @param AddonDriverInterface $formAddon
     *
     * @return static
     */
    public function setFormAddon(AddonDriverInterface $formAddon): FormAddonAwareTrait
    {
        $this->formAddon = $formAddon;

        return $this;
    }
}
<?php

declare(strict_types=1);

namespace Pollen\Form\Concerns;

use LogicException;
use Pollen\Form\AddonDriverInterface;
use Pollen\Form\FormInterface;

trait AddonAwareTrait
{
    /**
     * Instance de l'addon de formulaire associé.
     * @var AddonDriverInterface|null
     */
    protected $addon;

    /**
     * Instance du formulaire associé.
     * @var FormInterface|null
     */
    protected $form;

    /**
     * Récupération de l'instance de l'addon associé.
     *
     * @return AddonDriverInterface
     */
    public function addon(): AddonDriverInterface
    {
        if ($this->addon instanceof AddonDriverInterface) {
            return $this->addon;
        }

        throw new LogicException('Unavailable related addon');
    }

    /**
     * Récupération de l'instance du formulaire associé.
     *
     * @return FormInterface
     */
    public function form(): FormInterface
    {
        return $this->addon()->form();
    }

    /**
     * Définition de l'addon associé.
     *
     * @param AddonDriverInterface $addon
     *
     * @return static
     */
    public function setAddon(AddonDriverInterface $addon): AddonAwareTrait
    {
        $this->addon = $addon;

        return $this;
    }
}
<?php

declare(strict_types=1);

namespace Pollen\Form\Factory;

use Pollen\Form\Concerns\FormAwareTraitInterface;
use Pollen\Session\AttributeKeyBagInterface;
use Pollen\Session\SessionManagerInterface;
use Pollen\Support\Concerns\BootableTraitInterface;

interface SessionFactoryInterface extends AttributeKeyBagInterface, BootableTraitInterface, FormAwareTraitInterface
{
    /**
     * Chargement.
     *
     * @return SessionFactoryInterface
     */
    public function boot(): SessionFactoryInterface;

    /**
     * Définition de l'instance du gestionnaire de session.
     *
     * @param SessionManagerInterface $sessionManager
     *
     * @return SessionFactoryInterface
     */
    public function setSessionManager(SessionManagerInterface $sessionManager): SessionFactoryInterface;
}
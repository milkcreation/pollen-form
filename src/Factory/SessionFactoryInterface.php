<?php

declare(strict_types=1);

namespace Pollen\Form\Factory;

use Pollen\Session\AttributeKeyBagInterface;
use Pollen\Session\SessionManagerInterface;

/**
 * @mixin \Pollen\Support\Concerns\BootableTrait
 * @mixin \Pollen\Form\Concerns\FormAwareTrait
 */
interface SessionFactoryInterface extends AttributeKeyBagInterface
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
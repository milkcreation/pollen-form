<?php

declare(strict_types=1);

namespace Pollen\Form\Factory;

use Pollen\Form\Concerns\FormAwareTraitInterface;
use Pollen\Session\AttributeKeyBagInterface;
use Pollen\Session\FlashBagInterface;
use Pollen\Support\Concerns\BootableTraitInterface;
use Pollen\Support\Proxy\SessionProxyInterface;

interface SessionFactoryInterface extends
    AttributeKeyBagInterface,
    BootableTraitInterface,
    FormAwareTraitInterface,
    SessionProxyInterface
{
    /**
     * Chargement.
     *
     * @return SessionFactoryInterface
     */
    public function boot(): SessionFactoryInterface;

    /**
     * Définition|Récupération|Instance du gestionnaire de données de session éphémères.
     *
     * @param string|array|null $key
     * @param mixed $default
     *
     * @return string|array|object|null|FlashBagInterface
     */
    public function flash($key = null, $default = null);
}
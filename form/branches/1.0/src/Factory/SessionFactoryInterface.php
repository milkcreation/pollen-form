<?php

declare(strict_types=1);

namespace Pollen\Form\Factory;

use Pollen\Form\Concerns\FormAwareTraitInterface;
use Pollen\Session\AttributeKeyBagInterface;
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
}
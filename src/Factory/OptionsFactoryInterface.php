<?php

declare(strict_types=1);

namespace Pollen\Form\Factory;

use Pollen\Form\Concerns\FormAwareTraitInterface;
use Pollen\Support\Concerns\BootableTraitInterface;
use Pollen\Support\Concerns\ParamsBagDelegateTraitInterface;

interface OptionsFactoryInterface extends
    BootableTraitInterface,
    FormAwareTraitInterface,
    ParamsBagDelegateTraitInterface
{
    /**
     * Chargement.
     *
     * @return OptionsFactoryInterface
     */
    public function boot(): OptionsFactoryInterface;
}
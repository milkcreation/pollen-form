<?php

declare(strict_types=1);

namespace Pollen\Form\Factory;

/**
 * @mixin \Pollen\Form\Concerns\FormAwareTrait
 * @mixin \Pollen\Support\Concerns\BootableTrait
 * @mixin \Pollen\Support\Concerns\ParamsBagAwareTrait
 * @mixin \Pollen\Support\ParamsBag
 */
interface OptionsFactoryInterface
{
    /**
     * Délégation d'appel des methodes de ParamsBag.
     *
     * @param string $method
     * @param array $arguments
     *
     * @return mixed
     */
    public function __call(string $method, array $arguments);

    /**
     * Chargement.
     *
     * @return OptionsFactoryInterface
     */
    public function boot(): OptionsFactoryInterface;
}
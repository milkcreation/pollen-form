<?php

declare(strict_types=1);

namespace Pollen\Form;

/**
 * @mixin \Pollen\Form\Concerns\FormAwareTrait
 * @mixin \Pollen\Support\Concerns\BootableTrait
 * @mixin \Pollen\Support\Concerns\BuildableTrait
 * @mixin \Pollen\Support\Concerns\ParamsBagAwareTrait
 */
interface AddonDriverInterface
{
    /**
     * Chargement.
     *
     * @return static
     */
    public function boot(): AddonDriverInterface;

    /**
     * Initialisation.
     *
     * @return static
     */
    public function build(): AddonDriverInterface;

    /**
     * Liste des attributs de configuration par défaut du formulaire associé.
     *
     * @return array
     */
    public function defaultFormOptions(): array;

    /**
     * Liste des attributs de configuration par défaut des champs du formulaire associé.
     *
     * @return array
     */
    public function defaultFieldOptions(): array;

    /**
     * Récupération de l'alias de qualification.
     *
     * @return string
     */
    public function getAlias(): string;

    /**
     * Définition de l'alias de qualification.
     *
     * @param string $alias
     *
     * @return static
     */
    public function setAlias(string $alias): AddonDriverInterface;
}
<?php

declare(strict_types=1);

namespace Pollen\Form;

/**
 * @mixin \Pollen\Form\Concerns\FormAwareTrait
 * @mixin \Pollen\Support\Concerns\BootableTrait
 * @mixin \Pollen\Support\Concerns\BuildableTrait
 * @mixin \Pollen\Support\Concerns\ParamsBagAwareTrait
 */
interface ButtonDriverInterface
{
    /**
     * Résolution de sortie de l'affichage du contrôleur.
     *
     * @return string
     */
    public function __toString(): string;

    /**
     * Initialisation du contrôleur.
     *
     * @return static
     */
    public function boot(): ButtonDriverInterface;

    /**
     * Initialisation.
     *
     * @return static
     */
    public function build(): ButtonDriverInterface;

    /**
     * Récupération de l'alias de qualification.
     *
     * @return string
     */
    public function getAlias(): string;

    /**
     * Récupération de l'ordre d'affichage.
     *
     * @return int
     */
    public function getPosition(): int;

    /**
     * Vérification d'existance d'encapsuleur HTML.
     *
     * @return bool
     */
    public function hasWrapper(): bool;

    /**
     * Affichage.
     *
     * @return string
     */
    public function render(): string;

    /**
     * Définition de l'alias de qualification.
     *
     * @param string $alias
     *
     * @return static
     */
    public function setAlias(string $alias): ButtonDriverInterface;
}
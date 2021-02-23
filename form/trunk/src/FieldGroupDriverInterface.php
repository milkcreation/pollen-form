<?php

declare(strict_types=1);

namespace Pollen\Form;

use Illuminate\Support\Collection;
use Pollen\Form\Factory\FieldGroupsFactoryInterface;

/**
 * @mixin \Pollen\Form\Concerns\FormAwareTrait
 * @mixin \Pollen\Support\Concerns\BootableTrait
 * @mixin \Pollen\Support\Concerns\ParamsBagTrait
 */
interface FieldGroupDriverInterface
{
    /**
     * Chargement.
     *
     * @return static
     */
    public function boot(): FieldGroupDriverInterface;

    /**
     * Post-affichage.
     *
     * @return string
     */
    public function after(): string;

    /**
     * Pré-affichage.
     *
     * @return string
     */
    public function before(): string;

    /**
     * Récupération de l'alias de qualification.
     *
     * @return string
     */
    public function getAlias(): string;

    /**
     * Récupération de la liste des attributs de balise HTML.
     *
     * @param bool $linearized Linéarisation des valeurs.
     *
     * @return string|array
     */
    public function getAttrs(bool $linearized = true);

    /**
     * Récupération de la liste des champs associé au groupe.
     *
     * @return Collection|FieldDriver[]|array
     */
    public function getFields(): iterable;

    /**
     * Récupération du groupe parent
     *
     * @return FieldGroupDriverInterface|null
     */
    public function getParent(): ?FieldGroupDriverInterface;

    /**
     * Récupération du positionnement de l'élément.
     *
     * @return int
     */
    public function getPosition(): int;

    /**
     * Instance du gestionnaire de groupe de champs.
     *
     * @return FieldGroupsFactoryInterface
     */
    public function groupsManager(): FieldGroupsFactoryInterface;

    /**
     * Définition de l'alias de qualification.
     *
     * @param string $alias
     *
     * @return static
     */
    public function setAlias(string $alias): FieldGroupDriverInterface;

    /**
     * Définition du gestionnaire de groupes de champs.
     *
     * @param FieldGroupsFactoryInterface $groupsManager
     *
     * @return static
     */
    public function setGroupManager(FieldGroupsFactoryInterface $groupsManager): FieldGroupDriverInterface;
}
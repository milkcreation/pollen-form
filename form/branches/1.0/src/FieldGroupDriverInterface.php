<?php

declare(strict_types=1);

namespace Pollen\Form;

use Illuminate\Support\Collection;
use Pollen\Form\Concerns\FormAwareTraitInterface;
use Pollen\Form\Factory\FieldGroupsFactoryInterface;
use Pollen\Support\Concerns\BootableTraitInterface;
use Pollen\Support\Concerns\ParamsBagAwareTraitInterface;

interface FieldGroupDriverInterface extends
    BootableTraitInterface,
    FormAwareTraitInterface,
    ParamsBagAwareTraitInterface
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
     * @return Collection|FormFieldDriver[]|array
     */
    public function getFormFields(): iterable;

    /**
     * Récupération de l'indice de qualification.
     *
     * @return int
     */
    public function getIndex(): int;

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

    /**
     * Définition de l'indice de qualification.
     *
     * @param int $index
     *
     * @return static
     */
    public function setIndex(int $index): FieldGroupDriverInterface;
}
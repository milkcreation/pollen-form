<?php

declare(strict_types=1);

namespace Pollen\Form\Factory;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use Illuminate\Support\Collection;
use Pollen\Form\Concerns\FormAwareTraitInterface;
use Pollen\Form\FieldGroupDriverInterface;
use Pollen\Support\Concerns\BootableTraitInterface;

interface FieldGroupsFactoryInterface extends
    ArrayAccess,
    BootableTraitInterface,
    Countable,
    FormAwareTraitInterface,
    IteratorAggregate
{
    /**
     * Récupération de la liste des pilotes déclarés.
     *
     * @return FieldGroupDriverInterface[]|array
     */
    public function all(): array;

    /**
     * Initialisation.
     *
     * @return static
     */
    public function boot(): FieldGroupsFactoryInterface;

    /**
     * Collection.
     *
     * @param array|null $items Si null, liste des pilotes déclarés.
     *
     * @return Collection|FieldGroupsFactory[]|iterable
     */
    public function collect(?array $items = null): iterable;

    /**
     * Récupération d'un pilote déclaré selon son alias.
     *
     * @param string $alias
     *
     * @return FieldGroupDriverInterface|null
     */
    public function get(string $alias): ?FieldGroupDriverInterface;

    /**
     * Récupération de l'indice incrémentale de qualification d'un groupe.
     *
     * @return int
     */
    public function getIncrement(): int;

    /**
     * Définition d'un pilote.
     *
     * @param string $alias
     * @param array|FieldGroupDriverInterface $driverDefinition
     *
     * @return static
     */
    public function setDriver(string $alias, $driverDefinition = []): FieldGroupsFactoryInterface;
}
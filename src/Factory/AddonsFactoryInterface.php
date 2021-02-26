<?php

declare(strict_types=1);

namespace Pollen\Form\Factory;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use Illuminate\Support\Collection;
use Pollen\Form\AddonDriverInterface;
use Pollen\Form\Concerns\FormAwareTraitInterface;
use Pollen\Support\Concerns\BootableTraitInterface;

interface AddonsFactoryInterface extends
    ArrayAccess,
    BootableTraitInterface,
    Countable,
    FormAwareTraitInterface,
    IteratorAggregate
{
    /**
     * Récupération de la liste des pilotes déclarés.
     *
     * @return AddonDriverInterface[]|array
     */
    public function all(): array;

    /**
     * Initialisation.
     *
     * @return static
     */
    public function boot(): AddonsFactoryInterface;

    /**
     * Collection.
     *
     * @param array|null $items Si null, liste des pilotes déclarés
     *
     * @return Collection|AddonDriverInterface[]|iterable
     */
    public function collect(?array $items = null): iterable;

    /**
     * Récupération d'un pilote déclaré selon son alias.
     *
     * @param string $alias
     *
     * @return AddonDriverInterface|null
     */
    public function get(string $alias): ?AddonDriverInterface;
}
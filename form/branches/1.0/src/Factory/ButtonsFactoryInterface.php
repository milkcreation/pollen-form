<?php

declare(strict_types=1);

namespace Pollen\Form\Factory;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use Illuminate\Support\Collection;
use Pollen\Form\ButtonDriverInterface;

/**
 * @mixin \Pollen\Form\Concerns\FormAwareTrait
 * @mixin \Pollen\Support\Concerns\BootableTrait
 */
interface ButtonsFactoryInterface extends ArrayAccess, Countable, IteratorAggregate
{
    /**
     * Récupération de la liste des pilotes déclarés.
     *
     * @return ButtonDriverInterface[]|array
     */
    public function all(): array;

    /**
     * Initialisation.
     *
     * @return static
     */
    public function boot(): ButtonsFactoryInterface;

    /**
     * Collection.
     *
     * @param array|null $items Si null, liste des pilotes déclarés.
     *
     * @return Collection|ButtonDriverInterface[]|iterable
     */
    public function collect(?array $items = null): iterable;

    /**
     * Récupération de la liste des éléments par ordre d'affichage.
     *
     * @return Collection|ButtonDriverInterface[]|iterable
     */
    public function collectByPosition(): iterable;

    /**
     * Récupération d'un pilote déclaré selon son alias.
     *
     * @param string $alias
     *
     * @return ButtonDriverInterface|null
     */
    public function get(string $alias): ?ButtonDriverInterface;
}
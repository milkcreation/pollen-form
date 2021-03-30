<?php

declare(strict_types=1);

namespace Pollen\Form\Factory;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use Illuminate\Support\Collection;
use Pollen\Form\Concerns\FormAwareTraitInterface;
use Pollen\Form\FormFieldDriverInterface;
use Pollen\Support\Concerns\BootableTraitInterface;

interface FormFieldsFactoryInterface extends
    ArrayAccess,
    BootableTraitInterface,
    Countable,
    FormAwareTraitInterface,
    IteratorAggregate
{
    /**
     * Récupération de la liste des pilotes déclarés.
     *
     * @return FormFieldDriverInterface[]|array
     */
    public function all(): array;

    /**
     * Chargement.
     *
     * @return static
     */
    public function boot(): FormFieldsFactoryInterface;

    /**
     * Collection.
     *
     * @param array|null $items Si null, liste des pilotes déclarés
     *
     * @return Collection|FormFieldDriverInterface[]|iterable
     */
    public function collect(?array $items = null): iterable;

    /**
     * Récupération d'un pilote déclaré selon son alias.
     *
     * @param string $alias
     *
     * @return FormFieldDriverInterface|null
     */
    public function get(string $alias): ?FormFieldDriverInterface;

    /**
     * Récupération de la liste des champs par groupe d'appartenance.
     *
     * @param string $groupAlias Alias de qualification du groupe.
     *
     * @return Collection|FormFieldDriverInterface[]|null
     */
    public function fromGroup(string $groupAlias): ?iterable;

    /**
     * Pré-traitement de la liste des champs en vue d'un affichage du rendu.
     *
     * @return FormFieldsFactoryInterface
     */
    public function preRender(): FormFieldsFactoryInterface;
}

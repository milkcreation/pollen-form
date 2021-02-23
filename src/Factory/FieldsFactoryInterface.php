<?php

declare(strict_types=1);

namespace Pollen\Form\Factory;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use Illuminate\Support\Collection;
use Pollen\Form\FieldDriverInterface;

/**
 * @mixin \Pollen\Form\Concerns\FormAwareTrait
 * @mixin \Pollen\Support\Concerns\BootableTrait
 */
interface FieldsFactoryInterface extends ArrayAccess, Countable, IteratorAggregate
{
    /**
     * Récupération de la liste des pilotes déclarés.
     *
     * @return FieldDriverInterface[]|array
     */
    public function all(): array;

    /**
     * Chargement.
     *
     * @return static
     */
    public function boot(): FieldsFactoryInterface;

    /**
     * Collection.
     *
     * @param array|null $items Si null, liste des pilotes déclarés
     *
     * @return Collection|FieldDriverInterface[]|iterable
     */
    public function collect(?array $items = null): iterable;

    /**
     * Récupération d'un pilote déclaré selon son alias.
     *
     * @param string $alias
     *
     * @return FieldDriverInterface|null
     */
    public function get(string $alias): ?FieldDriverInterface;

    /**
     * Récupération de la liste des champs par groupe d'appartenance.
     *
     * @param string $groupAlias Alias de qualification du groupe.
     *
     * @return Collection|FieldDriverInterface[]|null
     */
    public function fromGroup(string $groupAlias): ?iterable;

    /**
     * Récupération de valeur(s) de champ(s) basée(s) sur leurs variables d'identifiant de qualification.
     *
     * @param mixed $tags Variables de qualification de champs.
     * string ex. "%%{{slug#1}}%% %%{{slug#2}}%%"
     * array ex ["%%{{slug#1}}%%", "%%{{slug#2}}%%"]
     * @param boolean $raw Activation de la valeur de retour au format brut.
     *
     * @return string|null
     */
    public function metatagsValue($tags, bool $raw = true): ?string;

    /**
     * Pré-traitement de la liste des champs en vue d'un affichage du rendu.
     *
     * @return FieldsFactoryInterface
     */
    public function preRender(): FieldsFactoryInterface;
}

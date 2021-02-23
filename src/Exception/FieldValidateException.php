<?php

declare(strict_types=1);

namespace Pollen\Form\Exception;

use InvalidArgumentException;
use Pollen\Form\FieldDriverInterface;

class FieldValidateException extends InvalidArgumentException
{
    /**
     * Alias de qualification.
     * @var string
     */
    private $alias = '';

    /**
     * Instance du champ associé.
     * @var FieldDriverInterface|null
     */
    private $field;

    /**
     * Récupération de l'alias de qualification.
     *
     * @return string
     */
    public function getAlias(): string
    {
        return $this->alias;
    }

    /**
     * Récupération de l'instance du pilote de champ.
     *
     * @return FieldDriverInterface
     */
    public function getField(): FieldDriverInterface
    {
        return $this->field;
    }

    /**
     * Vérification de correspondance de l'alias de qualification.
     *
     * @param string $alias
     *
     * @return bool
     */
    public function is(string $alias): bool
    {
        return $this->alias === $alias;
    }

    /**
     * Vérification de correspondance de l'alias de qualification.
     *
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->alias === '_required';
    }

    /**
     * Définition de l'alias de qualification.
     *
     * @param string $alias
     *
     * @return static
     */
    public function setAlias(string $alias): self
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Définition de l'instance du champ associé.
     *
     * @param FieldDriverInterface $field
     *
     * @return static
     */
    public function setField(FieldDriverInterface $field): self
    {
        $this->field = $field;

        return $this;
    }
}
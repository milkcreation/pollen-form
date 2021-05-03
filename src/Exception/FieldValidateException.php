<?php

declare(strict_types=1);

namespace Pollen\Form\Exception;

use InvalidArgumentException;
use Pollen\Form\FormFieldDriverInterface;
use Throwable;

class FieldValidateException extends InvalidArgumentException implements FormException
{
    /**
     * Drapeaux d'identification.
     * @var array
     */
    private $flags = [];

    /**
     * Instance du champ associé.
     * @var FormFieldDriverInterface|null
     */
    private $formField;

    /**
     * @param FormFieldDriverInterface $formField
     * @param string $message
     * @param array $flags
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(FormFieldDriverInterface $formField, string $message = "", array $flags = [], int $code = 0, Throwable $previous = null)
    {
        $this->formField = $formField;

        parent::__construct($message, $code, $previous);
    }

    /**
     * Définition d'un drapeau d'identification
     *
     * @param string $flag
     *
     * @return static
     */
    public function addFlag(string $flag): self
    {
        return $this->addFlags([$flag]);
    }

    /**
     * Définition de drapeaux d'identification
     *
     * @param array $flags
     *
     * @return static
     */
    public function addFlags(array $flags): self
    {
        foreach(array_values($flags) as $flag) {
            if (is_string($flag) && !in_array($flag, $this->flags, true)) {
                $this->flags[] = $flag;
            }
        }

        return $this;
    }

    /**
     * Récupération de l'instance du pilote de champ.
     *
     * @return FormFieldDriverInterface
     */
    public function getFormField(): FormFieldDriverInterface
    {
        return $this->formField;
    }

    /**
     * Vérification d'existance d'un drapeau d'identification.
     *
     * @param string $flag
     *
     * @return bool
     */
    public function hasFlag(string $flag): bool
    {
        return in_array($flag, $this->flags, true);
    }

    /**
     * Vérification d'existance du drapeau de champ requis.
     *
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->hasFlag('required');
    }

    /**
     * Définition du drapeau de champ requis.
     *
     * @return static
     */
    public function setRequired(): self
    {
        return $this->addFlag('required');
    }
}
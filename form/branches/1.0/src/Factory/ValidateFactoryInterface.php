<?php

declare(strict_types=1);

namespace Pollen\Form\Factory;

use Pollen\Form\Concerns\FormAwareTraitInterface;
use Pollen\Support\Concerns\BootableTraitInterface;

interface ValidateFactoryInterface extends BootableTraitInterface, FormAwareTraitInterface
{
    /**
     * Chargement.
     *
     * @return static
     */
    public function boot(): ValidateFactoryInterface;

    /**
     * Appel d'un test d'intégrité de valeur.
     *
     * @param string|callable $callback Fonction de traitement de vérification.
     * @param mixed $value Valeur à vérifier.
     * @param array $args Liste des variables passées en argument.
     *
     * @return bool
     */
    public function call($callback, $value, $args = []): bool;

    /**
     * Méthode de controle par défaut.
     *
     * @param mixed $value Valeur à vérifier.
     *
     * @return bool
     */
    public function default($value): bool;

    /**
     * Compare deux chaînes de caractères.
     * @internal ex. mot de passe <> confirmation mot de passe
     *
     * @param mixed $value Valeur du champ courant à comparer.
     * @param mixed $tags Variables de qualification de champs de comparaison.
     *
     * @return bool
     */
    public function compare($value, $tags): bool;
}
<?php

declare(strict_types=1);

namespace Pollen\Form\Factory;

use BadMethodCallException;
use tiFy\Contracts\Session\Store as SessionStorageContract;
use tiFy\Session\Store as SessionStorage;

/**
 * @mixin \Pollen\Form\Concerns\FormAwareTrait
 * @mixin SessionStorage
 */
interface SessionFactoryInterface
{
    /**
     * Délégation d'appel des méthodes du controleur de données de session associé.
     *
     * @param string $name Nom de la méthode à appeler.
     * @param array $arguments Liste des variables passées en argument.
     *
     * @return mixed
     *
     * @throws BadMethodCallException
     */
    public function __call(string $name, array $arguments);

    /**
     * Chargement.
     *
     * @return SessionFactory
     */
    public function boot(): SessionFactory;

    /**
     * Récupération du jeton de qualification.
     *
     * @return string
     */
    public function getToken(): string;

    /**
     * Récupération de l'instance du gestionnaire de session associé.
     *
     * @return SessionStorageContract
     */
    public function store(): SessionStorageContract;
}
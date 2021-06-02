<?php

declare(strict_types=1);

namespace Pollen\Form\Factory;

use InvalidArgumentException;
use Pollen\Form\Concerns\FormAwareTraitInterface;
use Pollen\Http\RedirectResponse;
use Pollen\Support\Concerns\BootableTraitInterface;
use Pollen\Support\ParamsBag;

interface HandleFactoryInterface extends BootableTraitInterface, FormAwareTraitInterface
{
    /**
     * Chargement.
     *
     * @return static
     */
    public function boot(): HandleFactoryInterface;

    /**
     * Définition|Récupération|Instance des données de requête HTTP de traitement du formulaire.
     *
     * @param array|string|null $key
     * @param mixed $default
     *
     * @return string|int|array|mixed|ParamsBag
     *
     * @throws InvalidArgumentException
     */
    public function datas($key = null, $default = null);

    /**
     * Traitement de l'échec de la requête de soumission du formulaire.
     *
     * @return static
     */
    public function fail(): HandleFactoryInterface;

    /**
     * Récupération de l'url de redirection en cas d'échec.
     *
     * @return string
     */
    public function getFailedRedirectUrl(): string;

    /**
     * Récupération de l'url de redirection en cas de succès.
     *
     * @return string
     */
    public function getSucceedRedirectUrl(): string;

    /**
     * Vérification de soumission du formulaire.
     *
     * @return boolean
     */
    public function isSubmitted(): bool;

    /**
     * Vérification du succès de validation de la soumission du formulaire.
     *
     * @return bool
     */
    public function isValidated(): bool;

    /**
     * Persistance des données en session.
     *
     * @param string $key
     * @param mixed $value
     *
     * @return static
     */
    public function persist(string $key, $value): HandleFactoryInterface;

    /**
     * Processus de traitement de la requête de soumission du formulaire.
     *
     * @return RedirectResponse
     */
    public function proceed(): RedirectResponse;

    /**
     * Redirection de la requête de traitement du formulaire.
     *
     * @return RedirectResponse
     */
    public function redirectResponse(): RedirectResponse;

    /**
     * Définition d'un message d'erreur.
     * {@internal Si le champs indiqué en paramètre n'est pas disponible, l'erreur est passée au formulaire.}
     *
     * @param string $message
     * @param array $context
     * @param string|null $fieldSlug
     *
     * @return static
     */
    public function safeError($message = '', $context = [], string $fieldSlug = null): HandleFactoryInterface;

    /**
     * Définition de l'url de redirection en cas d'échec.
     *
     * @param string $url
     * @param bool $raw Activation/Désactivation du formatage automatique.
     *
     * @return static
     */
    public function setFailedRedirectUrl(string $url, bool $raw = false): HandleFactoryInterface;

    /**
     * Définition de l'url de redirection en cas de succès.
     *
     * @param string $url
     * @param bool $raw Activation/Désactivation du formatage automatique.
     *
     * @return static
     */
    public function setSucceedRedirectUrl(string $url, bool $raw = false): HandleFactoryInterface;

    /**
     * Traitement du succès de la requête de soumission du formulaire.
     *
     * @return static
     */
    public function success(): HandleFactoryInterface;

    /**
     * Traitement de la validation de soumission du formulaire.
     *
     * @return static
     */
    public function validate(): HandleFactoryInterface;
}
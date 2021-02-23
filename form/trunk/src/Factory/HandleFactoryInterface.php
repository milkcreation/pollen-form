<?php

declare(strict_types=1);

namespace Pollen\Form\Factory;

use Pollen\Http\RedirectResponse;

/**
 * @mixin \Pollen\Form\Concerns\FormAwareTrait
 * @mixin \Pollen\Support\Concerns\BootableTrait
 * @mixin \Pollen\Support\Concerns\ParamsBagTrait
 */
interface HandleFactoryInterface
{
    /**
     * Chargement.
     *
     * @return static
     */
    public function boot(): HandleFactoryInterface;

    /**
     * Traitement de l'échec de la requête de soumission du formulaire.
     *
     * @return static
     */
    public function fail(): HandleFactoryInterface;

    /**
     * Récupération de l'url de redirection.
     *
     * @return string
     */
    public function getRedirectUrl(): string;

    /**
     * Récupération de la valeur de la protection CSRF.
     *
     * @return string
     */
    public function getToken(): string;

    /**
     * Vérification de soumission du formulaire.
     *
     * @return boolean
     */
    public function isSubmitted(): bool;

    /**
     * Vérification du succes de validation de la soumission du formulaire.
     *
     * @return bool
     */
    public function isValidated(): bool;

    /**
     * Traitement de la requête de soumission du formulaire.
     *
     * @return RedirectResponse|null
     */
    public function response(): ?RedirectResponse;

    /**
     * Redirection de la requête de traitement du formulaire.
     *
     * @return RedirectResponse
     */
    public function redirect(): RedirectResponse;

    /**
     * Définition de l'url de redirection.
     *
     * @param string $url
     * @param bool $raw Désactivation du formatage (indicateur de succès && ancre).
     *
     * @return static
     */
    public function setRedirectUrl(string $url, bool $raw = false): HandleFactoryInterface;

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
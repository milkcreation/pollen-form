<?php

declare(strict_types=1);

namespace Pollen\Form\Factory;

use Pollen\Form\Concerns\FormAwareTraitInterface;
use Pollen\Http\RedirectResponse;
use Pollen\Support\Concerns\BootableTraitInterface;
use Pollen\Support\Concerns\ParamsBagAwareTraitInterface;

interface HandleFactoryInterface extends BootableTraitInterface, FormAwareTraitInterface, ParamsBagAwareTraitInterface
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
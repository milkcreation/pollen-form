<?php

declare(strict_types=1);

namespace Pollen\Form;

use Pollen\Field\FieldManagerInterface;
use Pollen\Http\RequestInterface;
use Pollen\Partial\PartialManagerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @mixin \Pollen\Form\Concerns\FactoryBagTrait
 * @mixin \Pollen\Support\Concerns\BootableTrait
 * @mixin \Pollen\Support\Concerns\BuildableTrait
 * @mixin \Pollen\Support\Concerns\MessagesBagAwareTrait
 * @mixin \Pollen\Support\Concerns\ParamsBagAwareTrait
 * @mixin \Pollen\Translation\Concerns\LabelsBagAwareTrait
 */
interface FormInterface
{
    /**
     * Résolution de sortie de l'affichage du formulaire.
     *
     * @return string
     */
    public function __toString(): string;

    /**
     * Chargement.
     *
     * @return FormInterface
     */
    public function boot(): FormInterface;

    /**
     * Initialisation.
     *
     * @return FormInterface
     */
    public function build(): FormInterface;

    /**
     * Récupération de la chaîne de sécurisation du formulaire (CSRF).
     *
     * @return string
     */
    public function csrf(): string;

    /**
     * Liste des intitulés de qualification par défaut.
     *
     * @return array
     */
    public function defaultLabels(): array;

    /**
     * Déclaration d'un message d'erreur.
     *
     * @param string $message Intitulé du message.
     * @param array $datas Données associées à l'erreur
     *
     * @return string Identifiant de qualification du message d'erreur
     */
    public function error(string $message, array $datas = []): string;

    /**
     * Récupération de l'instance du gestionnaire de champs.
     *
     * @return FieldManagerInterface
     */
    public function fieldManager(): FieldManagerInterface;

    /**
     * Récupération de l'instance du gestionnaire de formulaire.
     *
     * @return FormManagerInterface
     */
    public function formManager(): FormManagerInterface;

    /**
     * Récupération de l'action du formulaire (url).
     *
     * @return string
     */
    public function getAction(): string;

    /**
     * Récupération de l'alias de qualification du champ.
     *
     * @return string
     */
    public function getAlias(): string;

    /**
     * Récupération de l'ancre du formulaire.
     *
     * @return string
     */
    public function getAnchor(): string;

    /**
     * Instance de la requête HTTP de traitement du formulaire.
     *
     * @return RequestInterface|Request
     */
    public function getHandleRequest(): RequestInterface;

    /**
     * Récupération de l'indice du formulaire.
     *
     * @return int
     */
    public function getIndex(): int;

    /**
     * Récupération de la méthode de soumission du formulaire.
     *
     * @return string
     */
    public function getMethod(): string;

    /**
     * Récupération de la liste des attributs de support.
     *
     * @return string[]
     */
    public function getSupports(): array;

    /**
     * Récupération de l'intitulé de qualification du formulaire.
     *
     * @return string
     */
    public function getTitle(): string;

    /**
     * Vérification du status en erreur du formulaire.
     *
     * @return bool
     */
    public function hasError(): bool;

    /**
     * Vérification de soumission du formulaire.
     *
     * @return bool
     */
    public function isSubmitted(): bool;

    /**
     * Vérifie si le formulaire a été soumis avec succès.
     *
     * @return bool
     */
    public function isSuccessful(): bool;

    /**
     * Evénement de déclenchement à l'initialisation du formulaire en tant que formulaire courant.
     *
     * @return void
     */
    public function onSetCurrent(): void;

    /**
     * Evénement de déclenchement à la réinitialisation du formulaire courant du formulaire.
     *
     * @return void
     */
    public function onResetCurrent(): void;

    /**
     * Récupération de l'instance du gestionnaire de partial.
     *
     * @return PartialManagerInterface
     */
    public function partialManager(): PartialManagerInterface;

    /**
     * Affichage.
     *
     * @return string
     */
    public function render(): string;

    /**
     * Initialisation du rendu.
     *
     * @return static
     */
    public function renderBuild(): FormInterface;

    /**
     * Initialisation du rendu des attributrs HTML.
     *
     * @return static
     */
    public function renderBuildAttrs(): FormInterface;

    /**
     * Initialisation du rendu de l'identifiant de qualification HTML.
     *
     * @return static
     */
    public function renderBuildId(): FormInterface;

    /**
     * Initialisation du rendu des messages de notification.
     *
     * @return static
     */
    public function renderBuildNotices(): FormInterface;

    /**
     * Initialisation du rendu de l'encapsulation.
     *
     * @return static
     */
    public function renderBuildWrapper(): FormInterface;

    /**
     * Définition de l'alias de qualification.
     *
     * @param string $alias
     *
     * @return static
     */
    public function setAlias(string $alias): FormInterface;

    /**
     * Définition du gestionnaire de formulaire.
     *
     * @param FormManagerInterface $formManager
     *
     * @return static
     */
    public function setFormManager(FormManagerInterface $formManager): FormInterface;

    /**
     * Définition de la requête HTTP de traitement du formulaire.
     *
     * @param RequestInterface $handleRequest
     *
     * @return static
     */
    public function setHandleRequest(RequestInterface $handleRequest): FormInterface;

    /**
     * Définition de l'indicateur de statut de formulaire en succès.
     *
     * @param boolean $status
     *
     * @return static
     */
    public function setSuccessful(bool $status = true): FormInterface;

    /**
     * Vérification de support.
     *
     * @param string $support
     *
     * @return bool
     */
    public function supports(string $support): bool;

    /**
     * Récupération du nom de qualification du formulaire dans les attributs de balises HTML.
     *
     * @return string
     */
    public function tagName(): string;

    /**
     * Instance du gestionnaire de gabarits d'affichage ou rendu du gabarit d'affichage.
     *
     * @param string|null view Nom de qualification du gabarit.
     * @param array $data Liste des variables passées en argument.
     *
     * @return FormViewEngineInterface|string
     */
    public function view(?string $view = null, array $data = []);
}
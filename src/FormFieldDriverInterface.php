<?php

declare(strict_types=1);

namespace Pollen\Form;

use Pollen\Form\Concerns\FormAwareTraitInterface;
use Pollen\Form\Exception\FieldValidateException;
use Pollen\Support\Concerns\BootableTraitInterface;
use Pollen\Support\Concerns\BuildableTraitInterface;
use Pollen\Support\Concerns\ParamsBagAwareTraitInterface;

interface FormFieldDriverInterface extends
    BootableTraitInterface,
    BuildableTraitInterface,
    FormAwareTraitInterface,
    ParamsBagAwareTraitInterface
{
    /**
     * Résolution de sortie sous forme d'une chaîne de caractères.
     *
     * @return string
     */
    public function __toString(): string;

    /**
     * Définition d'un message de notification associé au champ.
     *
     * @param string $message
     * @param string $level
     * @param array $context
     *
     * @return static
     */
    public function addNotice(string $message, string $level = 'error', array $context = []): FormFieldDriverInterface;

    /**
     * Récupération du pré-affichage.
     *
     * @return string
     */
    public function after(): string;

    /**
     * Récupération du post-affichage.
     *
     * @return string
     */
    public function before(): string;

    /**
     * Chargement.
     *
     * @return static
     */
    public function boot(): FormFieldDriverInterface;

    /**
     * Initialisation.
     *
     * @return static
     */
    public function build(): FormFieldDriverInterface;

    /**
     * Définition d'un message d'erreur associé au champ.
     *
     * @param string $message
     * @param array $context
     *
     * @return static
     */
    public function error(string $message, array $context = []): FormFieldDriverInterface;

    /**
     * Récupération de l'alias de qualification.
     *
     * @return string
     */
    public function getAlias(): string;

    /**
     * Récupération d'attributs de configuration d'un addon associé.
     * {@internal Retourne la liste complète si $key est à null.}
     *
     * @param string $alias Alias de qualification de l'addon associé.
     * @param null|string $key Clé d'indexe de l'attribut. Syntaxe à point permise.
     * @param mixed $default Valeur de retour par défaut.
     *
     * @return mixed
     */
    public function getAddonOption(string $alias, ?string $key = null, $default = null);

    /**
     * Récupération de la valeur par défaut.
     *
     * @return int|string|array
     */
    public function getDefault();

    /**
     * Récupération d'attributs de configuration complémentaires.
     *
     * @param string|null $key Clé d'indexe de l'attribut. Syntaxe à point permise. Laisser à null (défaut) pour
     *                         récupérer la liste complète.
     * @param mixed $default Valeur de retour par défaut.
     *
     * @return mixed
     */
    public function getExtras(?string $key = null, $default = null);

    /**
     * Récupération du groupe d'appartenance.
     *
     * @return FieldGroupDriverInterface
     */
    public function getGroup(): ?FieldGroupDriverInterface;

    /**
     * Récupération de l'indice de qualification de la variable de requête.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Récupération des messages de notifications associés au champ selon leur type.
     *
     * @param string|null $type error|success|notice|warning
     *
     * @return string[]|array
     */
    public function getNotices(?string $type = null): array;

    /**
     * Récupération de l'ordre d'affichage.
     *
     * @return int
     */
    public function getPosition(): int;

    /**
     * Récupération d'attributs de champ requis.
     *
     * @param string|null $key Clé d'indexe d'attributs. Syntaxe à point permise. Liste complète si null.
     * @param mixed $default Valeur de retour par défaut.
     *
     * @return mixed
     */
    public function getRequired(?string $key = null, $default = null);

    /**
     * Récupération de l'identifiant de qualification.
     *
     * @return string
     */
    public function getSlug(): string;

    /**
     * Récupération de la liste des attributs de support.
     *
     * @return string[]
     */
    public function getSupports(): array;

    /**
     * Récupération de l'intitulé de qualification.
     *
     * @return string
     */
    public function getTitle(): string;

    /**
     * Récupération du type.
     *
     * @return string
     */
    public function getType(): string;

    /**
     * Récupération de la valeur.
     *
     * @param boolean Activation de la valeur de retour au format brut.
     *
     * @return mixed
     */
    public function getValue(bool $raw = true);

    /**
     * Récupération de la liste des valeurs.
     *
     * @param bool $raw Activation de la valeur de retour au format brut.
     * @param string|null $glue Caractère(s) d'assemblage de la valeur.
     *
     * @return string|array
     */
    public function getValues(bool $raw = true, ?string $glue = ', ');

    /**
     * Vérification d'existance d'une étiquette.
     *
     * @return boolean
     */
    public function hasLabel(): bool;

    /**
     * Vérification si le champ est associé à des messages de notifications.
     *
     * @param string|null $level error|success|notice|warning
     *
     * @return bool
     */
    public function hasNotices(?string $level = null): bool;

    /**
     * Vérification d'existance d'encapsuleur HTML.
     *
     * @return boolean
     */
    public function hasWrapper(): bool;

    /**
     * Vérification de pré-traitement du rendu.
     *
     * @return bool
     */
    public function isRendering(): bool;

    /**
     * Traitement récursif des tests de validation.
     *
     * @param string|array $validations Test de validation à traiter.
     * @param array $results Liste des tests de validations traités.
     *
     * @return array
     */
    public function parseValidations($validations, array $results = []): array;

    /**
     * Pré-traitement du champ en vue de l'affichage du rendu.
     *
     * @return static
     */
    public function preRender(): FormFieldDriverInterface;

    /**
     * Affichage.
     *
     * @return string
     */
    public function render(): string;

    /**
     * Réinitionalisation  de la valeur.
     *
     * @return static
     */
    public function resetValue(): FormFieldDriverInterface;

    /**
     * Définition de l'alias de qualification.
     *
     * @param string $alias
     *
     * @return static
     */
    public function setAlias(string $alias): FormFieldDriverInterface;

    /**
     * Définition de la valeur par défaut.
     *
     * @param int|string|array|Closure $default
     *
     * @return static
     */
    public function setDefault($default): FormFieldDriverInterface;

    /**
     * Définition d'une attributs de configuration complémentaire.
     *
     * @param string $key Clé d'indexe de l'attribut.
     * @param mixed $value Valeur à définir.
     *
     * @return static
     */
    public function setExtra(string $key, $value): FormFieldDriverInterface;

    /**
     * Définition de l'ordre d'affichage.
     *
     * @param int $position Valeur de la position.
     *
     * @return $this
     */
    public function setPosition(int $position = 0): FormFieldDriverInterface;

    /**
     * Définition de la valeur du champ basée sur la donnée de session.
     *
     * @return static
     */
    public function setValueFromSession(): FormFieldDriverInterface;

    /**
     * Définition de l'identifiant de qualification.
     *
     * @param string $slug
     *
     * @return static
     */
    public function setSlug(string $slug): FormFieldDriverInterface;

    /**
     * Définition de la valeur du champ.
     *
     * @param mixed $value Valeur à définir.
     *
     * @return static
     */
    public function setValue($value): FormFieldDriverInterface;

    /**
     * Vérification de support.
     *
     * @param string $support Attribut de support à controler.
     *
     * @return bool
     */
    public function supports(string $support): bool;

    /**
     * Validation du champs de formulaire.
     *
     * @param mixed $value
     *
     * @return void
     *
     * @throws FieldValidateException
     */
    public function validate($value = null): void;
}
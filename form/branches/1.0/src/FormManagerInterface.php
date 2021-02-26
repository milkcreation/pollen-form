<?php

declare(strict_types=1);

namespace Pollen\Form;

use Closure;
use Pollen\Support\Concerns\BootableTraitInterface;
use Pollen\Support\Concerns\ConfigBagAwareTraitInterface;
use Pollen\Support\Proxy\ContainerProxyInterface;
use Pollen\Support\Proxy\EventDispatcherProxyInterface;
use Pollen\Support\Proxy\FieldManagerProxyInterface;
use Pollen\Support\Proxy\PartialManagerProxyInterface;
use Pollen\Support\Proxy\SessionManagerProxyInterface;

/**

 */
interface FormManagerInterface extends
    BootableTraitInterface,
    ConfigBagAwareTraitInterface,
    ContainerProxyInterface,
    EventDispatcherProxyInterface,
    FieldManagerProxyInterface,
    PartialManagerProxyInterface,
    SessionManagerProxyInterface
{
    /**
     * Récupération de la liste des formulaires déclarés.
     *
     * @return FormInterface[]|array
     */
    public function all(): array;

    /**
     * Chargement.
     *
     * @return static
     */
    public function boot(): FormManagerInterface;

    /**
     * Création d'un formulaire.
     *
     * @param string|array|FormInterface $definition
     *
     * @return FormBuilderInterface
     */
    public function buildForm($definition): FormBuilderInterface;

    /**
     * Récupération d'une instance de formulaire associé à son alias de qualification.
     *
     * @param string $alias
     *
     * @return FormInterface
     */
    public function get(string $alias): FormInterface;

    /**
     * Récupération d'un pilote d'addon déclaré.
     *
     * @param string $alias
     *
     * @return AddonDriverInterface
     */
    public function getAddonDriver(string $alias): AddonDriverInterface;

    /**
     * Récupération d'un pilote de bouton déclaré.
     *
     * @param string $alias
     *
     * @return ButtonDriverInterface
     */
    public function getButtonDriver(string $alias): ButtonDriverInterface;

    /**
     * Récupération du formulaire courant.
     *
     * @return FormInterface|null
     */
    public function getCurrentForm(): ?FormInterface;

    /**
     * Récupération d'un pilote de champ déclaré.
     *
     * @param string $alias
     *
     * @return FieldDriverInterface
     */
    public function getFieldDriver(string $alias): FieldDriverInterface;

    /**
     * Récupération de l'indice de déclaration d'un formulaire.
     *
     * @param FormInterface $form
     *
     * @return int
     */
    public function getFormIndex(FormInterface $form): int;

    /**
     * Déclaration d'un pilote d'addon.
     *
     * @param string $alias
     * @param string|array|AddonDriverInterface $addonDriverDefinition
     * @param Closure|null $registerCallback
     *
     * @return FormManagerInterface
     */
    public function registerAddonDriver(
        string $alias,
        $addonDriverDefinition,
        ?Closure $registerCallback = null
    ): FormManagerInterface;

    /**
     * Déclaration d'un pilote de bouton.
     *
     * @param string $alias
     * @param string|array|ButtonDriverInterface $buttonDriverDefinition
     * @param Closure|null $registerCallback
     *
     * @return FormManagerInterface
     */
    public function registerButtonDriver(
        string $alias,
        $buttonDriverDefinition,
        ?Closure $registerCallback = null
    ): FormManagerInterface;

    /**
     * Déclaration d'un pilote de champ.
     *
     * @param string $alias
     * @param string|array|FieldDriverInterface $fieldDriverDefinition
     * @param Closure|null $registerCallback
     *
     * @return FormManagerInterface
     */
    public function registerFieldDriver(
        string $alias,
        $fieldDriverDefinition,
        ?Closure $registerCallback = null
    ): FormManagerInterface;

    /**
     * Déclaration d'un formulaire.
     *
     * @param string $alias
     * @param string|array|FormInterface $formDefinition
     *
     * @return FormManagerInterface
     */
    public function registerForm(string $alias, $formDefinition): FormManagerInterface;

    /**
     * Réinitialisation du formulaire courant.
     *
     * @return static
     */
    public function resetCurrentForm(): FormManagerInterface;

    /**
     * Chemin absolu vers une ressource (fichier|répertoire).
     *
     * @param string|null $path Chemin relatif vers la ressource.
     *
     * @return string
     */
    public function resources(?string $path = null): string;

    /**
     * Définition du chemin absolu vers le répertoire des ressources.
     *
     * @return static
     * @var string $resourceBaseDir
     *
     */
    public function setResourcesBaseDir(string $resourceBaseDir): FormManagerInterface;

    /**
     * Définition de l'instance du formulaire courant.
     *
     * @param FormInterface $form
     *
     * @return static
     */
    public function setCurrentForm(FormInterface $form): FormManagerInterface;
}
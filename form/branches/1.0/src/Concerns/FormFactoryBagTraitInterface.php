<?php

declare(strict_types=1);

namespace Pollen\Form\Concerns;

use Pollen\Form\AddonDriverInterface;
use Pollen\Form\ButtonDriverInterface;
use Pollen\Form\Factory\AddonsFactoryInterface;
use Pollen\Form\Factory\ButtonsFactoryInterface;
use Pollen\Form\Factory\EventFactoryInterface;
use Pollen\Form\Factory\FormFieldsFactoryInterface;
use Pollen\Form\Factory\FieldGroupsFactoryInterface;
use Pollen\Form\Factory\HandleFactoryInterface;
use Pollen\Form\Factory\OptionsFactoryInterface;
use Pollen\Form\Factory\SessionFactoryInterface;
use Pollen\Form\Factory\ValidateFactoryInterface;
use Pollen\Form\FormFieldDriverInterface;
use Pollen\Form\FieldGroupDriverInterface;

interface FormFactoryBagTraitInterface
{
    /**
     * Récupération d'un pilote d'addon selon son alias.
     *
     * @param string $alias
     *
     * @return AddonDriverInterface|null
     */
    public function addon(string $alias): ?AddonDriverInterface;

    /**
     * Récupération du gestionnaire d'addons.
     *
     * @return AddonsFactoryInterface|AddonDriverInterface[]
     */
    public function addons(): AddonsFactoryInterface;

    /**
     * Récupération d'un pilote d'addon selon son alias.
     *
     * @param string $alias
     *
     * @return ButtonDriverInterface|null
     */
    public function button(string $alias): ?ButtonDriverInterface;

    /**
     * Récupération du gestionnaire de boutons.
     *
     * @return ButtonsFactoryInterface|ButtonDriverInterface[]
     */
    public function buttons(): ButtonsFactoryInterface;

    /**
     * Déclenchement d'un événement.
     *
     * @param string $alias Nom de qualification.
     * @param array $args Liste des arguments passé à l'événement
     *
     * @return void
     */
    public function event(string $alias, array $args = []): void;

    /**
     * Récupération du gestionnaire d'événenements.
     *
     * @return EventFactoryInterface
     */
    public function events(): EventFactoryInterface;

    /**
     * Récupération d'un champs selon son alias.
     *
     * @param string $slug
     *
     * @return FormFieldDriverInterface
     */
    public function formField(string $slug): FormFieldDriverInterface;

    /**
     * Récupération du gestionnaire de champs.
     *
     * @return FormFieldsFactoryInterface|FormFieldDriverInterface[]
     */
    public function formFields(): FormFieldsFactoryInterface;

    /**
     * Récupération du groupe selon son alias.
     *
     * @param string $alias
     *
     * @return FieldGroupDriverInterface
     */
    public function group(string $alias): ?FieldGroupDriverInterface;

    /**
     * Récupération du gestionnaire de groupes de champs.
     *
     * @return FieldGroupsFactoryInterface|FieldGroupDriverInterface[]
     */
    public function groups(): FieldGroupsFactoryInterface;

    /**
     * Récupération du gestionnaire de traitment de la requête de soumission du formualire.
     *
     * @return HandleFactoryInterface
     */
    public function handle(): HandleFactoryInterface;

    /**
     * Récupération d'option.
     *
     * @param string $key Indice de l'option
     * @param mixed|null $default Valeur de retoru par défaut
     *
     * @return mixed
     */
    public function option(string $key, $default = null);

    /**
     * Récupération du gestionnaire des options.
     *
     * @return OptionsFactoryInterface
     */
    public function options(): OptionsFactoryInterface;

    /**
     * Récupération du gestionnaire de session.
     *
     * @return SessionFactoryInterface
     */
    public function session(): SessionFactoryInterface;

    /**
     * Récupération du gestionnaire de validation de la requête de soumission du formulaire.
     *
     * @return ValidateFactoryInterface
     */
    public function validate(): ValidateFactoryInterface;

    /**
     * Définition du gestionnaire d'addons.
     *
     * @param AddonsFactoryInterface $addonsFactory
     *
     * @return FormFactoryBagTraitInterface
     */
    public function setAddonsFactory(AddonsFactoryInterface $addonsFactory): FormFactoryBagTraitInterface;

    /**
     * Définition du gestionnaire de boutons.
     *
     * @param ButtonsFactoryInterface $buttonsFactory
     *
     * @return FormFactoryBagTraitInterface
     */
    public function setButtonsFactory(ButtonsFactoryInterface $buttonsFactory): FormFactoryBagTraitInterface;

    /**
     * Définition du gestionnaire d'événements.
     *
     * @param EventFactoryInterface $eventsFactory
     *
     * @return FormFactoryBagTraitInterface
     */
    public function setEventFactory(EventFactoryInterface $eventsFactory): FormFactoryBagTraitInterface;

    /**
     * Définition du gestionnaire de champs.
     *
     * @param FormFieldsFactoryInterface $formFieldsFactory
     *
     * @return FormFactoryBagTraitInterface
     */
    public function setFormFieldsFactory(FormFieldsFactoryInterface $formFieldsFactory): FormFactoryBagTraitInterface;

    /**
     * Définition du gestionnaire de groupe de champs.
     *
     * @param FieldGroupsFactoryInterface $groupsFactory
     *
     * @return FormFactoryBagTraitInterface
     */
    public function setGroupsFactory(FieldGroupsFactoryInterface $groupsFactory): FormFactoryBagTraitInterface;

    /**
     * Définition du gestionnaire de traitement de la requête de soumission du formulaire.
     *
     * @param HandleFactoryInterface $handleFactory
     *
     * @return FormFactoryBagTraitInterface
     */
    public function setHandleFactory(HandleFactoryInterface $handleFactory): FormFactoryBagTraitInterface;

    /**
     * Définition du gestionnaire des options de formulaire.
     *
     * @param OptionsFactoryInterface $optionsFactory
     *
     * @return FormFactoryBagTraitInterface
     */
    public function setOptionsFactory(OptionsFactoryInterface $optionsFactory): FormFactoryBagTraitInterface;

    /**
     * Définition du gestionnaire de session.
     *
     * @param SessionFactoryInterface $sessionFactory
     *
     * @return FormFactoryBagTraitInterface
     */
    public function setSessionFactory(SessionFactoryInterface $sessionFactory): FormFactoryBagTraitInterface;

    /**
     * Définition du gestionnaire de validation de la requêter de soumission du formulaire.
     *
     * @param ValidateFactoryInterface $validateFactory
     *
     * @return FormFactoryBagTraitInterface
     */
    public function setValidateFactory(ValidateFactoryInterface $validateFactory): FormFactoryBagTraitInterface;
}
<?php

declare(strict_types=1);

namespace Pollen\Form\Concerns;

use Pollen\Form\AddonDriverInterface;
use Pollen\Form\ButtonDriverInterface;
use Pollen\Form\Factory\AddonsFactoryInterface;
use Pollen\Form\Factory\ButtonsFactoryInterface;
use Pollen\Form\Factory\EventsFactoryInterface;
use Pollen\Form\Factory\FieldsFactoryInterface;
use Pollen\Form\Factory\FieldGroupsFactoryInterface;
use Pollen\Form\Factory\HandleFactoryInterface;
use Pollen\Form\Factory\OptionsFactoryInterface;
use Pollen\Form\Factory\SessionFactoryInterface;
use Pollen\Form\Factory\ValidateFactoryInterface;
use Pollen\Form\FieldDriverInterface;
use Pollen\Form\FieldGroupDriverInterface;

trait FactoryBagTrait
{
    /**
     * Instance du gestionnaire d'addons.
     * @var AddonsFactoryInterface|null
     */
    private $addonsFactory;

    /**
     * Instance du gestionnaire de boutons.
     * @var ButtonsFactoryInterface|null
     */
    private $buttonsFactory;

    /**
     * Instance du gestionnaire d'évenenements.
     * @var EventsFactoryInterface|null
     */
    private $eventsFactory;

    /**
     * Instance du gestionnaire de groupes de champs.
     * @var FieldsFactoryInterface|null
     */
    private $fieldsFactory;

    /**
     * Instance du gestionnaire de groupes de champs.
     * @var FieldGroupsFactoryInterface|null
     */
    private $groupsFactory;

    /**
     * Instance du gestionnaire de traitement de la requête.
     * @var HandleFactoryInterface|null
     */
    private $handleFactory;

    /**
     * Instance du gestionnaire des options.
     * @var OptionsFactoryInterface|null
     */
    private $optionsFactory;

    /**
     * Instance du gestionnaire de session.
     * @var SessionFactoryInterface|null
     */
    private $sessionFactory;

    /**
     * Instance du gestionnaire de validation.
     * @var ValidateFactoryInterface|null
     */
    private $validateFactory;

    /**
     * Récupération d'un pilote d'addon selon son alias.
     *
     * @param string $alias
     *
     * @return AddonDriverInterface|null
     */
    public function addon(string $alias): ?AddonDriverInterface
    {
        return $this->addons()->get($alias);
    }

    /**
     * Récupération du gestionnaire d'addons.
     *
     * @return AddonsFactoryInterface|AddonDriverInterface[]
     */
    public function addons(): AddonsFactoryInterface
    {
        return $this->addonsFactory;
    }

    /**
     * Récupération d'un pilote d'addon selon son alias.
     *
     * @param string $alias
     *
     * @return ButtonDriverInterface|null
     */
    public function button(string $alias): ?ButtonDriverInterface
    {
        return $this->buttons()->get($alias);
    }

    /**
     * Récupération du gestionnaire de boutons.
     *
     * @return ButtonsFactoryInterface|ButtonDriverInterface[]
     */
    public function buttons(): ButtonsFactoryInterface
    {
        return $this->buttonsFactory;
    }

    /**
     * Déclenchement d'un événement.
     *
     * @param string $alias Nom de qualification.
     * @param array $args Liste des arguments passé à l'événement
     *
     * @return void
     */
    public function event(string $alias, array $args = []): void
    {
        $this->events()->trigger($alias, $args);
    }

    /**
     * Récupération du gestionnaire d'événenements.
     *
     * @return EventsFactoryInterface
     */
    public function events(): EventsFactoryInterface
    {
        return $this->eventsFactory;
    }

    /**
     * Récupération d'un champs selon son alias.
     *
     * @param string $slug
     *
     * @return FieldDriverInterface
     */
    public function field(string $slug): ?FieldDriverInterface
    {
        return $this->fields()->get($slug);
    }

    /**
     * Récupération du gestionnaire de champs.
     *
     * @return FieldsFactoryInterface|FieldDriverInterface[]
     */
    public function fields(): FieldsFactoryInterface
    {
        return $this->fieldsFactory;
    }

    /**
     * Récupération du groupe selon son alias.
     *
     * @param string $alias
     *
     * @return FieldGroupDriverInterface
     */
    public function group(string $alias): ?FieldGroupDriverInterface
    {
        return $this->groups()->get($alias);
    }

    /**
     * Récupération du gestionnaire de groupes de champs.
     *
     * @return FieldGroupsFactoryInterface|FieldGroupDriverInterface[]
     */
    public function groups(): FieldGroupsFactoryInterface
    {
        return $this->groupsFactory;
    }

    /**
     * Récupération du gestionnaire de traitment de la requête de soumission du formualire.
     *
     * @return HandleFactoryInterface
     */
    public function handle(): HandleFactoryInterface
    {
        return $this->handleFactory;
    }

    /**
     * Récupération d'option.
     *
     * @param string $key Indice de l'option
     * @param mixed|null $default Valeur de retoru par défaut
     *
     * @return mixed
     */
    public function option(string $key, $default = null)
    {
        return $this->options()->params($key, $default);
    }

    /**
     * Récupération du gestionnaire des options.
     *
     * @return OptionsFactoryInterface
     */
    public function options(): OptionsFactoryInterface
    {
        return $this->optionsFactory;
    }

    /**
     * Récupération du gestionnaire de session.
     *
     * @return SessionFactoryInterface
     */
    public function session(): SessionFactoryInterface
    {
        return $this->sessionFactory;
    }

    /**
     * Récupération du gestionnaire de validation de la requête de soumission du formulaire.
     *
     * @return ValidateFactoryInterface
     */
    public function validate(): ValidateFactoryInterface
    {
        return $this->validateFactory;
    }

    /**
     * Définition du gestionnaire d'addons.
     *
     * @param AddonsFactoryInterface $addonsFactory
     *
     * @return static
     */
    public function setAddonsFactory(AddonsFactoryInterface $addonsFactory): self
    {
        $this->addonsFactory = $addonsFactory;

        return $this;
    }

    /**
     * Définition du gestionnaire de boutons.
     *
     * @param ButtonsFactoryInterface $buttonsFactory
     *
     * @return static
     */
    public function setButtonsFactory(ButtonsFactoryInterface $buttonsFactory): self
    {
        $this->buttonsFactory = $buttonsFactory;

        return $this;
    }

    /**
     * Définition du gestionnaire d'événements.
     *
     * @param EventsFactoryInterface $eventsFactory
     *
     * @return static
     */
    public function setEventsFactory(EventsFactoryInterface $eventsFactory): self
    {
        $this->eventsFactory = $eventsFactory;

        return $this;
    }

    /**
     * Définition du gestionnaire de champs.
     *
     * @param FieldsFactoryInterface $fieldsFactory
     *
     * @return static
     */
    public function setFieldsFactory(FieldsFactoryInterface $fieldsFactory): self
    {
        $this->fieldsFactory = $fieldsFactory;

        return $this;
    }

    /**
     * Définition du gestionnaire de groupe de champs.
     *
     * @param FieldGroupsFactoryInterface $groupsFactory
     *
     * @return static
     */
    public function setGroupsFactory(FieldGroupsFactoryInterface $groupsFactory): self
    {
        $this->groupsFactory = $groupsFactory;

        return $this;
    }

    /**
     * Définition du gestionnaire de traitement de la requête de soumission du formulaire.
     *
     * @param HandleFactoryInterface $handleFactory
     *
     * @return static
     */
    public function setHandleFactory(HandleFactoryInterface $handleFactory): self
    {
        $this->handleFactory = $handleFactory;

        return $this;
    }

    /**
     * Définition du gestionnaire des options de formulaire.
     *
     * @param OptionsFactoryInterface $optionsFactory
     *
     * @return static
     */
    public function setOptionsFactory(OptionsFactoryInterface $optionsFactory): self
    {
        $this->optionsFactory = $optionsFactory;

        return $this;
    }

    /**
     * Définition du gestionnaire de session.
     *
     * @param SessionFactoryInterface $sessionFactory
     *
     * @return static
     */
    public function setSessionFactory(SessionFactoryInterface $sessionFactory): self
    {
        $this->sessionFactory = $sessionFactory;

        return $this;
    }

    /**
     * Définition du gestionnaire de validation de la requêter de soumission du formulaire.
     *
     * @param ValidateFactoryInterface $validateFactory
     *
     * @return static
     */
    public function setValidateFactory(ValidateFactoryInterface $validateFactory): self
    {
        $this->validateFactory = $validateFactory;

        return $this;
    }
}
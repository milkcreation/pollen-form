<?php

declare(strict_types=1);

namespace Pollen\Form\Factory;

use Pollen\Event\EventDispatcherInterface;
use Pollen\Event\TriggeredListenerInterface;
use Pollen\Form\Concerns\FormAwareTraitInterface;
use Pollen\Support\Concerns\BootableTraitInterface;

interface EventsFactoryInterface extends BootableTraitInterface, FormAwareTraitInterface
{
    /**
     * Chargement.
     *
     * @return static
     */
    public function boot(): EventsFactoryInterface;

    /**
     * Déclaration d'un événement.
     *
     * @param string $name Identifiant de qualification de l'événement.
     * @param string|callable|TriggeredListenerInterface $listener Fonction anonyme ou Classe de traitement de l'événement.
     * @param int $priority Priorité de traitement.
     *
     * @return static
     */
    public function on(string $name, $listener, int $priority = 0): EventsFactoryInterface;

    /**
     * Déclenchement d'un événement.
     *
     * @param string $name Nom de qualification de l'événement.
     * @param array $args Variable passées en argument à la fonction d'écoute.
     *
     * @return void
     */
    public function trigger(string $name, array $args = []): void;

    /**
     * Définition de l'instance du répartiteur d'événements.
     *
     * @param EventDispatcherInterface $eventDispatcher
     *
     * @return EventsFactoryInterface
     */
    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher): EventsFactoryInterface;
}
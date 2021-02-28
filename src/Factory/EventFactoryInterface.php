<?php

declare(strict_types=1);

namespace Pollen\Form\Factory;

use Pollen\Event\TriggeredListenerInterface;
use Pollen\Form\Concerns\FormAwareTraitInterface;
use Pollen\Support\Concerns\BootableTraitInterface;
use Pollen\Support\Proxy\EventProxyInterface;

interface EventFactoryInterface extends BootableTraitInterface, FormAwareTraitInterface, EventProxyInterface
{
    /**
     * Chargement.
     *
     * @return static
     */
    public function boot(): EventFactoryInterface;

    /**
     * Déclaration d'un événement.
     *
     * @param string $name Identifiant de qualification de l'événement.
     * @param string|callable|TriggeredListenerInterface $listener Fonction anonyme ou Classe de traitement de l'événement.
     * @param int $priority Priorité de traitement.
     *
     * @return static
     */
    public function on(string $name, $listener, int $priority = 0): EventFactoryInterface;

    /**
     * Déclenchement d'un événement.
     *
     * @param string $name Nom de qualification de l'événement.
     * @param array $args Variable passées en argument à la fonction d'écoute.
     *
     * @return void
     */
    public function trigger(string $name, array $args = []): void;
}
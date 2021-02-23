<?php

declare(strict_types=1);

namespace Pollen\Form\Factory;

use Pollen\Event\EventDispatcher;
use Pollen\Event\EventDispatcherInterface;
use Pollen\Form\FormInterface;
use Pollen\Form\Concerns\FormAwareTrait;
use Pollen\Support\Concerns\BootableTrait;
use RuntimeException;

class EventsFactory implements EventsFactoryInterface
{
    use BootableTrait;
    use FormAwareTrait;

    /**
     * @param EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @inheritDoc
     */
    public function boot(): EventsFactoryInterface
    {
        if (!$this->isBooted()) {
            if (!$this->form() instanceof FormInterface) {
                throw new RuntimeException('Form EventsFactory requires a valid related Form instance');
            }

            $events = (array)$this->form()->params('events', []);

            foreach ($events as $name => $event) {
                if (is_array($event) && isset($event['listener'])) {
                    $listener = $event['call'];
                    $priority = $event['priority'] ?? 0;
                } else {
                    $listener = $event;
                    $priority = 0;
                }
                $this->on($name, $listener, $priority);
            }

            $this->setBooted();

            $this->on('events.booted', [&$this]);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getEventDispatcher(): EventDispatcherInterface
    {
        if ($this->eventDispatcher === null) {
            $this->eventDispatcher = new EventDispatcher();
        }

        return $this->eventDispatcher;
    }

    /**
     * @inheritDoc
     */
    public function on($name, $listener, $priority = 0): EventsFactoryInterface
    {
        $this->eventDispatcher->on("form.factory.events.{$this->form()->getAlias()}.{$name}", $listener, $priority);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function trigger($name, $args = []): void
    {
        $name = "form.factory.events.{$this->form()->getAlias()}.{$name}";

        $this->eventDispatcher->trigger($name, $args);
    }

    /**
     * @inheritDoc
     */
    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher): EventsFactoryInterface
    {
        $this->eventDispatcher = $eventDispatcher;

        return $this;
    }
}
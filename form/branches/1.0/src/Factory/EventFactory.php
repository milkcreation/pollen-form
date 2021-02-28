<?php

declare(strict_types=1);

namespace Pollen\Form\Factory;

use Pollen\Form\FormInterface;
use Pollen\Form\Concerns\FormAwareTrait;
use Pollen\Support\Concerns\BootableTrait;
use Pollen\Support\Proxy\EventProxy;
use RuntimeException;

class EventFactory implements EventFactoryInterface
{
    use BootableTrait;
    use FormAwareTrait;
    use EventProxy;

    /**
     * @inheritDoc
     */
    public function boot(): EventFactoryInterface
    {
        if (!$this->isBooted()) {
            if (!$this->form() instanceof FormInterface) {
                throw new RuntimeException('Form EventFactory requires a valid related Form instance');
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
    public function on($name, $listener, $priority = 0): EventFactoryInterface
    {
        $this->event()->on("form.factory.events.{$this->form()->getAlias()}.{$name}", $listener, $priority);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function trigger($name, $args = []): void
    {
        $name = "form.factory.events.{$this->form()->getAlias()}.{$name}";

        $this->event()->trigger($name, $args);
    }
}
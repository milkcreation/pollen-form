<?php

declare(strict_types=1);

namespace Pollen\Form\Factory;

use ArrayIterator;
use Illuminate\Support\Collection;
use Pollen\Form\FormFieldDriverInterface;
use Pollen\Form\FieldGroupDriver;
use Pollen\Form\FieldGroupDriverInterface;
use Pollen\Form\FormInterface;
use Pollen\Form\Concerns\FormAwareTrait;
use Pollen\Support\Concerns\BootableTrait;
use RuntimeException;

class FieldGroupsFactory implements FieldGroupsFactoryInterface
{
    use BootableTrait;
    use FormAwareTrait;

    /**
     * Valeur incrémentale de l'indice de qualification.
     * @var int
     */
    protected $increment = 0;

    /**
     * Liste des groupe déclarés.
     * @var FieldGroupDriverInterface[]
     */
    protected $groupDrivers = [];

    /**
     * @inheritDoc
     */
    public function all(): array
    {
        return $this->groupDrivers;
    }

    /**
     * @inheritDoc
     */
    public function boot(): FieldGroupsFactoryInterface
    {
        if (!$this->isBooted()) {
            if (!$this->form() instanceof FormInterface) {
                throw new RuntimeException('Form FieldGroupsFactory requires a valid related Form instance');
            }

            $this->form()->event('groups.booting');

            $max = $this->collect()->max(function (FieldGroupDriverInterface $group) {
                return $group->getPosition();
            });

            $pad = 0;
            $this->collect()->each(function (FieldGroupDriverInterface $group) use (&$pad, $max) {
                $group->boot();

                $group->params('position', $group->getPosition() ?: ++$pad + $max);

                if ($fields = $group->getFormFields()) {
                    $max = $fields->max(function (FormFieldDriverInterface $field) {
                        return $field->getPosition();
                    });
                    $pad = 0;

                    $fields->each(function (FormFieldDriverInterface $field) use (&$pad, $max) {
                        $group = $field->getGroup();
                        $number = 10000 * (($group ? $group->getPosition() : 0) + 1);
                        $position = $field->getPosition() ?: ++$pad + $max;

                        return $field->setPosition(absint($number + $position));
                    });
                }
            });

            $this->setBooted();

            $this->form()->event('groups.booted');
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function collect(?array $items = null): iterable
    {
        return new Collection($items ?? $this->groupDrivers);
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return count($this->groupDrivers);
    }

    /**
     * @inheritDoc
     */
    public function get(string $alias): ?FieldGroupDriverInterface
    {
        return $this->groupDrivers[$alias] ?? null;
    }

    /**
     * @inheritdoc
     */
    public function getIncrement(): int
    {
        return $this->increment++;
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        return new ArrayIterator($this->groupDrivers);
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($offset): bool
    {
        return array_key_exists($offset, $$this->groupDrivers);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset): ?FieldGroupDriverInterface
    {
        return $this->fieldDrivers[$offset] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value): void
    {
        if ($offset === null) {
            $this->groupDrivers[] = $value;
        } else {
            $this->groupDrivers[$offset] = $value;
        }
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset): void
    {
        unset($this->groupDrivers[$offset]);
    }

    /**
     * @inheritDoc
     */
    public function setDriver(string $alias, $driverDefinition = []): FieldGroupsFactoryInterface
    {
        if (!$driverDefinition instanceof FieldGroupDriverInterface) {
            $driver = new FieldGroupDriver();
        } else {
            $driver = $driverDefinition;
        }

        $this->groupDrivers[$alias] = $driver->setAlias($alias)->setGroupManager($this);

        return $this;
    }
}
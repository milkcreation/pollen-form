<?php

declare(strict_types=1);

namespace Pollen\Form\Factory;

use ArrayIterator;
use Illuminate\Support\Collection;
use Pollen\Form\AddonDriverInterface;
use Pollen\Form\FormInterface;
use Pollen\Form\Concerns\FormAwareTrait;
use Pollen\Support\Concerns\BootableTrait;
use RuntimeException;

class AddonsFactory implements AddonsFactoryInterface
{
    use BootableTrait;
    use FormAwareTrait;

    /**
     * Liste pilotes d'addons déclarés.
     * @var AddonDriverInterface[]|array
     */
    protected $addonDrivers = [];

    /**
     * @inheritDoc
     */
    public function all(): array
    {
        return $this->addonDrivers;
    }

    /**
     * @inheritDoc
     */
    public function boot(): AddonsFactoryInterface
    {
        if (!$this->isBooted()) {
            if (!$this->form() instanceof FormInterface) {
                throw new RuntimeException('Form AddonsFactory requires a valid related Form instance');
            }

            $this->form()->event('addons.booting', [&$this]);

            $addons = (array)$this->form()->params('addons', []);

            foreach ($addons as $alias => $params) {
                if (is_numeric($alias)) {
                    if (is_string($params)) {
                        $alias = $params;
                        $params = [];
                    } else {
                        continue;
                    }
                }

                if ($params !== false) {
                    $this->addonDrivers[$alias] = $this->form()->formManager()->getAddonDriver($alias);
                    $this->addonDrivers[$alias]->setForm($this->form())->setParams($params)->boot();
                }
            }

            $this->setBooted();

            $this->form()->event('addons.booted', [&$this]);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function collect(?array $items = null): iterable
    {
        return new Collection($items ?? $this->addonDrivers);
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return count($this->addonDrivers);
    }

    /**
     * @inheritDoc
     */
    public function get(string $alias): ?AddonDriverInterface
    {
        return $this->addonDrivers[$alias] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        return new ArrayIterator($this->addonDrivers);
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($offset): bool
    {
        return array_key_exists($offset, $this->addonDrivers);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset): ?AddonDriverInterface
    {
        return $this->fieldDrivers[$offset] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value): void
    {
        if ($offset === null) {
            $this->addonDrivers[] = $value;
        } else {
            $this->addonDrivers[$offset] = $value;
        }
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset): void
    {
        unset($this->addonDrivers[$offset]);
    }
}
<?php

declare(strict_types=1);

namespace Pollen\Form\Factory;

use ArrayIterator;
use LogicException;
use Illuminate\Support\Collection;
use Pollen\Form\FormFieldDriverInterface;
use Pollen\Form\FormInterface;
use Pollen\Form\Concerns\FormAwareTrait;
use Pollen\Support\Concerns\BootableTrait;
use RuntimeException;

class FormFieldsFactory implements FormFieldsFactoryInterface
{
    use BootableTrait;
    use FormAwareTrait;

    /**
     * Liste des éléments associés au formulaire.
     * @var FormFieldDriverInterface[]
     */
    protected $fieldDrivers = [];

    /**
     * @inheritDoc
     */
    public function all(): array
    {
        return $this->fieldDrivers;
    }

    /**
     * @inheritDoc
     */
    public function boot(): FormFieldsFactoryInterface
    {
        if (!$this->isBooted()) {
            if (!$this->form() instanceof FormInterface) {
                throw new RuntimeException('Form FieldFactory requires a valid related Form instance');
            }

            $this->form()->event('fields.booting', [&$this]);

            $fields = (array)$this->form()->params('fields', []);
            $withGroup = (bool)(new Collection($fields))->first(function(array $field) {
                $group = $field['group'] ?? null;
                return $group  !== null;
            });

            foreach ($fields as $slug => $params) {
                if ($slug !== null) {
                    if (!$alias = $params['type'] ?? null) {
                        throw new LogicException(
                            sprintf('Field [%s] must have type in FormField declaration', $slug)
                        );
                    }

                    $this->fieldDrivers[$slug] = clone $this->form()->formManager()->getFormFieldDriver($alias);
                    $this->fieldDrivers[$slug]->setSlug($slug)->setForm($this->form())->setParams($params);
                    $this->fieldDrivers[$slug]->boot();

                    if ($withGroup && !$this->fieldDrivers[$slug]->getGroup()) {
                        $this->form()->groups()->setDriver((string)$this->fieldDrivers[$slug]->params('group'), []);
                    }
                }
            }

            $this->setBooted();

            $this->form()->event('fields.booted', [&$this]);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function collect(?array $items = null): iterable
    {
        return new Collection($items ?? $this->fieldDrivers);
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return count($this->fieldDrivers);
    }

    /**
     * @inheritDoc
     */
    public function get(string $alias): ?FormFieldDriverInterface
    {
        return $this->fieldDrivers[$alias] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        return new ArrayIterator($this->fieldDrivers);
    }

    /**
     * @inheritDoc
     */
    public function fromGroup(string $groupAlias): ?iterable
    {
        return $this->collect()->filter(function (FormFieldDriverInterface $field) use ($groupAlias) {
            return ($group = $field->getGroup()) && $group->getAlias() === $groupAlias;
        });
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($offset): bool
    {
        return array_key_exists($offset, $this->fieldDrivers);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset): ?FormFieldDriverInterface
    {
        return $this->fieldDrivers[$offset] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value): void
    {
        if ($offset === null) {
            $this->fieldDrivers[] = $value;
        } else {
            $this->fieldDrivers[$offset] = $value;
        }
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset): void
    {
        unset($this->fieldDrivers[$offset]);
    }

    /**
     * @inheritDoc
     */
    public function preRender(): FormFieldsFactoryInterface
    {
        foreach($this->all() as $fieldDriver) {
            $fieldDriver->preRender();
        }

        return $this;
    }
}
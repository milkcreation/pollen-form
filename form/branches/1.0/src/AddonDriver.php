<?php

declare(strict_types=1);

namespace Pollen\Form;

use LogicException;
use Pollen\Form\Concerns\FormAwareTrait;
use Pollen\Support\Concerns\BootableTrait;
use Pollen\Support\Concerns\BuildableTrait;
use Pollen\Support\Concerns\ParamsBagAwareTrait;

class AddonDriver implements AddonDriverInterface
{
    use BootableTrait;
    use BuildableTrait;
    use FormAwareTrait;
    use ParamsBagAwareTrait;

    /**
     * Alias de qualification.
     * @var string
     */
    protected $alias;

    /**
     * @inheritDoc
     */
    public function boot(): AddonDriverInterface
    {
        if (!$this->isBooted()) {
            if (!$this->form() instanceof FormInterface) {
                throw new LogicException('Invalid related FormFactory');
            }

            $this->parseParams();

            $this->setBooted();
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function build(): AddonDriverInterface
    {
        if (!$this->isBuilt()) {
            if ($this->alias === null) {
                throw new LogicException('Missing alias');
            }

            $this->setBuilt();
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function defaultFormOptions(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function defaultFieldOptions(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getAlias(): string
    {
        return $this->alias;
    }

    /**
     * @inheritDoc
     */
    public function setAlias(string $alias): AddonDriverInterface
    {
        $this->alias = $alias;

        return $this;
    }
}
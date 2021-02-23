<?php

declare(strict_types=1);

namespace Pollen\Form;

use LogicException;
use Pollen\Form\Concerns\FormAwareTrait;
use Pollen\Support\Concerns\BootableTrait;
use Pollen\Support\Concerns\BuildableTrait;
use Pollen\Support\Concerns\ParamsBagTrait;

class ButtonDriver implements ButtonDriverInterface
{
    use BootableTrait;
    use BuildableTrait;
    use FormAwareTrait;
    use ParamsBagTrait;

    /**
     * Alias de qualification.
     * @var string
     */
    protected $alias;

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->render();
    }

    /**
     * @inheritDoc
     */
    public function boot(): ButtonDriverInterface
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
    public function build(): ButtonDriverInterface
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
    public function defaultParams(): array
    {
        return [
            'after'           => '',
            'attrs'           => [],
            'before'          => '',
            'label'           => '',
            'position'        => 0,
            'type'            => '',
            'wrapper'         => true
        ];
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
    public function getPosition(): int
    {
        return (int)$this->params('position', 0);
    }

    /**
     * @inheritDoc
     */
    public function hasWrapper(): bool
    {
        return !empty($this->params('wrapper'));
    }

    /**
     * @inheritDoc
     */
    public function setAlias(string $alias): ButtonDriverInterface
    {
        if ($this->alias === null) {
            $this->alias = $alias;
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function render(): string
    {
        if ($wrapper = $this->params('wrapper')) {
            $wrapper = (is_array($wrapper)) ? $wrapper : [];
            $this->params(['wrapper' => array_merge(['tag' => 'div', 'attrs' => []], $wrapper)]);

            if (!$this->params()->has('wrapper.attrs.id')) {
                $this->params(['wrapper.attrs.id' => "FormButton--{$this->getAlias()}_{$this->form()->getIndex()}"]);
            }

            if (!$this->params('wrapper.attrs.id')) {
                $this->params()->pull('wrapper.attrs.id');
            }

            $default_class = "FormButton FormButton--{$this->getAlias()}";
            if (!$this->params()->has('wrapper.attrs.class')) {
                $this->params(['wrapper.attrs.class' => $default_class]);
            } else {
                $this->params([
                    'wrapper.attrs.class' => sprintf($this->params('wrapper.attrs.class', ''), $default_class)
                ]);
            }

            if (!$this->params('wrapper.attrs.class')) {
                $this->params()->pull('wrapper.attrs.class');
            }
        }

        return Field::get('button', $this->params()->all())->render();
    }
}
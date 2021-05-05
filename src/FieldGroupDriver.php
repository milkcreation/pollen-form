<?php

declare(strict_types=1);

namespace Pollen\Form;

use LogicException;
use Pollen\Form\Concerns\FormAwareTrait;
use Pollen\Form\Factory\FieldGroupsFactoryInterface;
use Pollen\Support\Html;
use Pollen\Support\Concerns\BootableTrait;
use Pollen\Support\Concerns\ParamsBagAwareTrait;

class FieldGroupDriver implements FieldGroupDriverInterface
{
    use BootableTrait;
    use FormAwareTrait;
    use ParamsBagAwareTrait;

    /**
     * Identifiant d'indexation.
     * @var int
     */
    private $index = 0;

    /**
     * Instance du gestionnaire des groupes de champ.
     * @var FieldGroupsFactoryInterface
     */
    protected $groupsManager;

    /**
     * Alias de qualification.
     * @var string
     */
    protected $alias = '';

    /**
     * @inheritDoc
     */
    public function boot(): FieldGroupDriverInterface
    {
        if (!$this->isBooted()) {
            if (!$this->groupsManager() instanceof FieldGroupsFactoryInterface) {
                throw new LogicException('Missing valid GroupManager');
            }

            $this->setForm($this->groupsManager->form());

            $this->form()->event('group.booting');

            $this->setParams((array)$this->form()->params('groups.'. $this->getAlias(), []));

            $this->parseParams();

            $this->setBooted();

            $this->form()->event('group.booted');
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function after(): string
    {
        return $this->params('after');
    }

    /**
     * @inheritdoc
     */
    public function before(): string
    {
        return $this->params('before');
    }

    /**
     * @inheritDoc
     */
    public function defaultParams(): array
    {
        return [
            'after'    => '',
            'before'   => '',
            'attrs'    => [],
            'position' => null
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
    public function getAttrs(bool $linearized = true)
    {
        $attrs = $this->params('attrs', []);

        return $linearized ? Html::attr($this->params('attrs', [])) : $attrs;
    }

    /**
     * @inheritDoc
     */
    public function getFormFields(): iterable
    {
        return $this->form()->formFields()->fromGroup($this->getAlias()) ?: [];
    }

    /**
     * @inheritDoc
     */
    public function getIndex(): int
    {
        return $this->index;
    }

    /**
     * @inheritDoc
     */
    public function getPosition(): int
    {
        return (int)$this->params('position');
    }

    /**
     * @inheritDoc
     */
    public function groupsManager(): FieldGroupsFactoryInterface
    {
        return $this->groupsManager;
    }

    /**
     * @inheritDoc
     */
    public function parseParams(): void
    {
        $params = $this->params();

        $class = 'FormFieldsGroup FormFieldsGroup--' . $this->getAlias();

        if (!$params->has('attrs.class')) {
            $params->set('attrs.class', $class);
        } else {
            $params->set('attrs.class', sprintf($params->get('attrs.class'), $class));
        }

        $position = $this->getPosition();
        if (is_null($position)) {
            $position = $this->index;
        }

        $params->set('position', $position);
    }

    /**
     * @inheritDoc
     */
    public function setAlias(string $alias): FieldGroupDriverInterface
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setGroupManager(FieldGroupsFactoryInterface $groupsManager): FieldGroupDriverInterface
    {
        $this->groupsManager = $groupsManager;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setIndex(int $index): FieldGroupDriverInterface
    {
        $this->index = $index;

        return $this;
    }
}
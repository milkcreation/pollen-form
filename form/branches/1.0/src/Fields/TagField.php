<?php

declare(strict_types=1);

namespace Pollen\Form\Fields;

use Pollen\Form\FormFieldDriver;

class TagField extends FormFieldDriver implements TagFieldInterface
{
    /**
     * Liste des propriétés de formulaire supportées.
     * @var array
     */
    protected $supports = ['wrapper'];

    /**
     * @inheritDoc
     */
    public function render(): string
    {
        $args = array_merge([
            'tag'     => 'div',
            'attrs'   => $this->params('attrs', []),
            'content' => $this->getValue(),
        ], $this->getExtras());

        return (string)$this->form()->partial('tag', $args);
    }
}
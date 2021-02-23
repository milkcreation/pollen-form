<?php
/**
 * @var tiFy\Contracts\Form\FormView $this
 * @var tiFy\Contracts\Form\FieldDriver $field
 */
echo ($field->params('label.position') === 'before')
    ? $this->fetch('field-label', compact('field')) . $field
    : $field. $this->fetch('field-label', compact('field'));
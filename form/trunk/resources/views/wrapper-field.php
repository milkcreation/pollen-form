<?php
/**
 * @var tiFy\Contracts\Form\FormView $this
 * @var tiFy\Contracts\Form\FieldDriver $field
 */
echo partial('tag', array_merge($field->params('wrapper', []), [
    'content' => $this->section('content')
]));
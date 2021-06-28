<?php
/**
 * @var Pollen\Form\FormTemplateInterface $this
 * @var Pollen\Form\FormFieldDriverInterface $field
 */
echo $this->partial('tag', array_merge($field->params('label.wrapper', []), [
    'content' => $this->section('content')
]));
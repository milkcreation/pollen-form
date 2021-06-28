<?php
/**
 * @var Pollen\Form\FormTemplateInterface $this
 * @var Pollen\Form\FormFieldDriverInterface $field
 */
echo $this->partial('tag', array_merge($field->params('wrapper', []), [
    'content' => $this->section('content')
]));
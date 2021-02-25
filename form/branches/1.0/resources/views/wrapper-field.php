<?php
/**
 * @var Pollen\Form\FormViewTemplateInterface $this
 * @var Pollen\Form\FieldDriverInterface $field
 */
echo $this->partial('tag', array_merge($field->params('wrapper', []), [
    'content' => $this->section('content')
]));
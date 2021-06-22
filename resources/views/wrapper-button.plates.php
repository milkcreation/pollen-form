<?php
/**
 * @var Pollen\Form\FormTemplate $this
 * @var Pollen\Form\ButtonDriverInterface $button
 */
echo $this->partial('tag', array_merge($button->params('wrapper', []), [
    'content' => $this->section('content')
]));
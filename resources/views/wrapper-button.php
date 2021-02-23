<?php
/**
 * @var tiFy\Contracts\Form\FormView $this
 * @var tiFy\Contracts\Form\ButtonDriver $button
 */
echo partial('tag', array_merge($button->params('wrapper', []), [
    'content' => $this->section('content')
]));
<?php
/**
 * @var Pollen\Form\FormTemplateInterface $this
 * @var Pollen\Form\FormFieldDriverInterface $field
 */
echo ($field->params('label.position') === 'before')
    ? $this->fetch('field-label', compact('field')) . $field
    : $field. $this->fetch('field-label', compact('field'));
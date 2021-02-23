<?php
/**
 * @var Pollen\Form\FormViewTemplateInterface $this
 * @var Pollen\Form\FieldDriverInterface $field
 */
echo ($field->params('label.position') === 'before')
    ? $this->fetch('field-label', compact('field')) . $field
    : $field. $this->fetch('field-label', compact('field'));
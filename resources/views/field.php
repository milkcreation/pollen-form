<?php
/**
 * @var Pollen\Form\FormViewTemplateInterface $this
 * @var Pollen\Form\FieldDriverInterface $field
 */
?>
<?php if ($field->hasWrapper()) : $this->layout('wrapper-field', $this->all()); endif; ?>
<?php echo $field->before(); ?>
<?php $this->insert('field-content', compact('field')); ?>
<?php echo $field->after();
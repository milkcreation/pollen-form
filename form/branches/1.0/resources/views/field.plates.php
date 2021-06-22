<?php
/**
 * @var Pollen\Form\FormTemplate $this
 * @var Pollen\Form\FormFieldDriverInterface $field
 */
?>
<?php if ($field->hasWrapper()) : $this->layout('wrapper-field', $this->all()); endif; ?>
<?php echo $field->before(); ?>
<?php $this->insert('field-content', compact('field')); ?>
<?php echo $field->after();
<?php
/**
 * @var tiFy\Contracts\Form\FormView $this
 * @var tiFy\Contracts\Form\FieldDriver $field
 */
?>
<?php if ($field->hasWrapper()) : $this->layout('wrapper-field', $this->all()); endif; ?>
<?php echo $field->before(); ?>
<?php $this->insert('field-content', compact('field')); ?>
<?php echo $field->after();
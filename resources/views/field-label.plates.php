<?php
/**
 * @var Pollen\Form\FormTemplate $this
 * @var Pollen\Form\FormFieldDriverInterface $field
 */
?>
<?php if ($field->hasLabel()) : ?>
    <?php if ($field->params('label.wrapper')) : $this->layout('wrapper-label', $this->all()); endif; ?>
    <?php echo $this->field('label', $field->params('label', [])); ?>
    <?php $this->insert('field-required', compact('field')); ?>
<?php endif;
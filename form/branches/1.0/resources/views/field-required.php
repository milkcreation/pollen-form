<?php
/**
 * @var Pollen\Form\FormViewTemplateInterface $this
 * @var Pollen\Form\FieldDriverInterface $field
 */
?>
<?php if ($required = $field->params('required.tagged')) : ?>
    <?php echo field('required', $required); ?>
<?php endif; ?>
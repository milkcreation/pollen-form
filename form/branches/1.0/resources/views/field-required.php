<?php
/**
 * @var Pollen\Form\FormViewLoaderInterface $this
 * @var Pollen\Form\FormFieldDriverInterface $field
 */
?>
<?php if ($required = $field->params('required.tagged')) : ?>
    <?php echo $this->field('required', $required); ?>
<?php endif; ?>
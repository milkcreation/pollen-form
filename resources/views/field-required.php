<?php
/**
 * @var tiFy\Contracts\Form\FormView $this
 * @var tiFy\Contracts\Form\FieldDriver $field
 */
?>
<?php if ($required = $field->params('required.tagged')) : ?>
    <?php echo field('required', $required); ?>
<?php endif; ?>
<?php
/**
 * @var tiFy\Contracts\Form\FormView $this
 * @var tiFy\Contracts\Form\ButtonDriver $button
 */
?>
<?php if ($button->hasWrapper()) : $this->layout('wrapper-button', $this->all()); endif; ?>

<?php echo $button->params('before'); ?>
<?php echo $button; ?>
<?php echo $button->params('after'); ?>
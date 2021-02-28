<?php
/**
 * @var Pollen\Form\FormViewLoaderInterface $this
 * @var Pollen\Form\ButtonDriverInterface $button
 */
?>
<?php if ($button->hasWrapper()) : $this->layout('wrapper-button', $this->all()); endif; ?>

<?php echo $button->params('before'); ?>
<?php echo $button; ?>
<?php echo $button->params('after'); ?>
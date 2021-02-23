<?php
/**
 * @var tiFy\Contracts\Form\FormView $this
 * @var tiFy\Contracts\Form\FieldGroupDriver $group
 */
?>
<?php echo $group->before(); ?>
<div <?php echo $group->getAttrs(); ?>>
    <?php foreach ($group->getFields() as $field) : ?>
        <?php $this->insert('field', compact('field')); ?>
    <?php endforeach; ?>
</div>
<?php echo $group->after();
<?php
/**
 * @var Pollen\Form\FormViewTemplateInterface $this
 * @var Pollen\Form\FieldGroupDriverInterface $group
 */
?>
<?php echo $group->before(); ?>
<div <?php echo $group->getAttrs(); ?>>
    <?php foreach ($group->getFields() as $field) : ?>
        <?php $this->insert('field', compact('field')); ?>
    <?php endforeach; ?>
</div>
<?php echo $group->after();
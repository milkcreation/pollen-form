<?php
/**
 * @var Pollen\Form\FormViewTemplateInterface $this
 * @var Pollen\Form\FieldGroupDriverInterface $group
 */
?>
<?php if ($groups = $this->get('groups')) : ?>
    <?php foreach ($groups as $name => $group) : ?>
        <?php $this->insert('group', compact('group')); ?>
    <?php endforeach; ?>
<?php endif;

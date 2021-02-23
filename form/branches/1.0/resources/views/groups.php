<?php
/**
 * @var tiFy\Contracts\Form\FormView $this
 * @var tiFy\Contracts\Form\FieldGroupDriver $group
 */
?>
<?php if ($groups = $this->get('groups')) : ?>
    <?php foreach ($groups as $name => $group) : ?>
        <?php $this->insert('group', compact('group')); ?>
    <?php endforeach; ?>
<?php endif;

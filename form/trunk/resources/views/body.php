<?php
/**
 * @var tiFy\Contracts\Form\FormView $this
 * @var tiFy\Contracts\Form\FieldsFactory $fields
 */
?>
<?php if ($fields->count()) : ?>
    <div class="FormFields">
        <?php $this->insert('groups', $this->all()); ?>
    </div>
<?php endif; ?>

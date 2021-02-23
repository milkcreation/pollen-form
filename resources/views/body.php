<?php
/**
 * @var Pollen\Form\FormViewTemplateInterface $this
 * @var Pollen\Form\Factory\FieldsFactoryInterface $fields
 */
?>
<?php if ($fields->count()) : ?>
    <div class="FormFields">
        <?php $this->insert('groups', $this->all()); ?>
    </div>
<?php endif; ?>

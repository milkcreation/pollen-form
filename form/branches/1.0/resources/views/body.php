<?php
/**
 * @var Pollen\Form\FormViewLoaderInterface $this
 * @var Pollen\Form\Factory\FormFieldsFactoryInterface $fields
 */
?>
<?php if ($fields->count()) : ?>
    <div class="FormFields">
        <?php $this->insert('groups', $this->all()); ?>
    </div>
<?php endif; ?>

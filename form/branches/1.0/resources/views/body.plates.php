<?php
/**
 * @var Pollen\Form\FormTemplate $this
 * @var Pollen\Form\Factory\FormFieldsFactoryInterface $fields
 */
?>
<?php if ($fields->count()) : ?>
    <div class="FormRows">
        <?php if ($this->form()->hasGroup()) : ?>
            <?php $this->insert('groups', $this->all()); ?>
        <?php else : ?>
            <?php foreach($this->form()->formFields() as $field) : ?>
                <?php $this->insert('field',compact('field')); ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
<?php endif; ?>

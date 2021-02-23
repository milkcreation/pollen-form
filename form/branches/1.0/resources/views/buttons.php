<?php
/**
 * @var Pollen\Form\FormViewTemplateInterface $this
 * @var Pollen\Form\ButtonDriverInterface[] $buttons
 */
?>
<?php if ($buttons = $this->get('buttons', [])) : ?>
    <div class="FormButtons">
        <?php foreach ($buttons as $button) : ?>
            <?php $this->insert('button', compact('button')); ?>
        <?php endforeach; ?>
    </div>
<?php endif;
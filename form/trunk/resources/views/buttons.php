<?php
/**
 * @var tiFy\Contracts\Form\FormView $this
 * @var tiFy\Contracts\Form\ButtonDriver[] $buttons
 */
?>
<?php if ($buttons = $this->get('buttons', [])) : ?>
    <div class="FormButtons">
        <?php foreach ($buttons as $button) : ?>
            <?php $this->insert('button', compact('button')); ?>
        <?php endforeach; ?>
    </div>
<?php endif;
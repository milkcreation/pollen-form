<?php
/**
 * @var Pollen\Form\FormTemplateInterface $this
 * @var string[] $messages
 */
?>
<?php if ($messages = $this->get('messages')) : ?>
<ol class="Notice-items FormNotice-items--warning">
    <?php foreach ($messages as $message) : ?>
        <li class="Notice-item FormNotice-item FormNotice-item--warning"><?php echo $message; ?></li>
    <?php endforeach; ?>
</ol>
<?php endif;
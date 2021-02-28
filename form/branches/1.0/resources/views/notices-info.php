<?php
/**
 * @var Pollen\Form\FormViewLoaderInterface $this
 * @var string[] $messages
 */
?>
<?php if ($messages = $this->get('messages')) : ?>
<ol class="Notice-items FormNotice-items FormNotice-items--info">
    <?php foreach ($messages as $message) : ?>
        <li class="Notice-item FormNotice-item FormNotice-item--info"><?php echo $message; ?></li>
    <?php endforeach; ?>
</ol>
<?php endif;
<?php
/**
 * @var Pollen\Form\FormTemplateInterface $this
 */

?>
<?php if ($this->form()->params('wrapper')) : ?>
    <?php $this->layout('wrapper-form', $this->all()); ?>
<?php endif; ?>

<?php echo $this->before(); ?>

<?php $this->insert('notices', $this->all()); ?>

    <form <?php echo $this->htmlAttrs($this->form()->params('attrs', [])); ?>>
        <?php echo $this->csrf(); ?>

        <?php if ($header = $this->fetch('header', $this->all())) : ?>
            <header class="FormHeader FormHeader--<?php echo $this->tagName(); ?>">
                <?php echo $header; ?>
            </header>
        <?php endif; ?>

        <?php if ($body = $this->fetch('body', $this->all())) : ?>
            <main class="FormBody FormBody--<?php echo $this->tagName(); ?>">
                <?php echo $body; ?>
            </main>
        <?php endif; ?>

        <?php if ($footer = $this->fetch('footer', $this->all())) : ?>
            <footer class="FormFooter FormFooter--<?php echo $this->tagName(); ?>">
                <?php echo $footer; ?>
            </footer>
        <?php endif; ?>
    </form>

<?php echo $this->after();
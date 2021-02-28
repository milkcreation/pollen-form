<?php
/**
 * @var Pollen\Form\FormViewLoaderInterface $this
 */
if ($errors = $this->get('notices.ERROR', [])) :
    echo $this->partial('notice', [
        'attrs'   => [
           'class' => '%s FormNotice FormNotice--error'
        ],
        'type'    => 'error',
        'content' => $this->fetch('notices-error', ['messages' => $errors])
    ]);
elseif (($success = $this->get('notices.SUCCESS', [])) || ($success = $this->get('notices.notice', []))) :
    echo $this->partial('notice', [
        'attrs'   => [
            'class' => '%s FormNotice FormNotice--success'
        ],
        'type'    => 'success',
        'content' => $this->fetch('notices-success', ['messages' => $success])
    ]);
elseif ($info = $this->get('notices.INFO', [])) :
    echo $this->partial('notice', [
        'attrs'   => [
            'class' => '%s FormNotice FormNotice--info'
        ],
        'type'    => 'info',
        'content' => $this->fetch('notices-info', ['messages' => $info])
    ]);
elseif ($warning = $this->get('notices.WARNING', [])) :
    echo $this->partial('notice', [
        'attrs'   => [
            'class' => '%s FormNotice FormNotice--warning'
        ],
        'type'    => 'warning',
        'content' => $this->fetch('notices-warning', ['messages' => $warning])
    ]);
endif;
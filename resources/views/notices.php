<?php
/**
 * @var tiFy\Contracts\Form\FormView $this
 */
if ($errors = $this->get('notices.error', [])) :
    echo partial('notice', [
        'attrs'   => [
           'class' => '%s FormNotice FormNotice--error'
        ],
        'type'    => 'error',
        'content' => $this->fetch('notices-error', ['messages' => $errors])
    ]);
elseif (($success = $this->get('notices.success', [])) || ($success = $this->get('notices.notice', []))) :
    echo partial('notice', [
        'attrs'   => [
            'class' => '%s FormNotice FormNotice--success'
        ],
        'type'    => 'success',
        'content' => $this->fetch('notices-success', ['messages' => $success])
    ]);
elseif ($info = $this->get('notices.info', [])) :
    echo partial('notice', [
        'attrs'   => [
            'class' => '%s FormNotice FormNotice--info'
        ],
        'type'    => 'info',
        'content' => $this->fetch('notices-info', ['messages' => $info])
    ]);
elseif ($warning = $this->get('notices.warning', [])) :
    echo partial('notice', [
        'attrs'   => [
            'class' => '%s FormNotice FormNotice--warning'
        ],
        'type'    => 'warning',
        'content' => $this->fetch('notices-warning', ['messages' => $warning])
    ]);
endif;
<?php

declare(strict_types=1);

namespace Pollen\Form\Buttons;

use Pollen\Form\ButtonDriver;

class SubmitButton extends ButtonDriver implements SubmitButtonInterface
{
    /**
     * @inheritDoc
     */
    public function defaultParams(): array
    {
        return array_merge(parent::defaultParams(), [
            'type'      => 'submit',
            'content'   => __('Envoyer', 'tify')
        ]);
    }
}
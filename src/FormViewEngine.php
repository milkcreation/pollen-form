<?php

declare(strict_types=1);

namespace Pollen\Form;

use Pollen\View\ViewEngine;
use Pollen\View\ViewTemplateInterface;

class FormViewEngine extends ViewEngine implements FormViewEngineInterface
{
    /**
     * Liste des méthodes de délégations permises.
     * @var array
     */
    protected $delegatedMixins = [
        'csrf',
        'isSuccessful',
        'tagName'
    ];

    /**
     * {@inheritDoc}
     *
     * @return FormViewTemplateInterface
     */
    public function make($name): ViewTemplateInterface
    {
        return new FormViewTemplate($this, $name);
    }
}
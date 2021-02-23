<?php

declare(strict_types=1);

namespace Pollen\Form;

use Pollen\View\ViewEngineInterface;
use Pollen\View\ViewTemplateInterface;

interface FormViewEngineInterface extends ViewEngineInterface
{
    /**
     * {@inheritDoc}
     *
     * @return FormViewTemplateInterface
     */
    public function make($name): ViewTemplateInterface;
}
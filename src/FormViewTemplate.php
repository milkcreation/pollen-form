<?php

declare(strict_types=1);

namespace Pollen\Form;

use Pollen\View\ViewTemplate;
use Closure;

/**
 * @method string csrf()
 * @method bool isSuccessful()
 * @method string tagName()
 */
class FormViewTemplate extends ViewTemplate implements FormViewTemplateInterface
{
    /**
     * @inheritDoc
     */
    public function after(): string
    {
        if ($content = $this->form()->params('after')) {
            if ($content instanceof Closure) {
                return $content();
            }

            if (is_string($content)) {
                return $content;
            }
        }
        return '';
    }

    /**
     * @inheritDoc
     */
    public function before(): string
    {
        if ($content = $this->form()->params('before')) {
            if ($content instanceof Closure) {
                return $content();
            }
            if (is_string($content)) {
                return $content;
            }
        }
        return '';
    }

    /**
     * @inheritDoc
     */
    public function form(): FormInterface
    {
        return $this->engine->params('form');
    }
}
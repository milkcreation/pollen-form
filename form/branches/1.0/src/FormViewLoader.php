<?php

declare(strict_types=1);

namespace Pollen\Form;

use Closure;
use Pollen\View\FieldAwareViewLoader;
use Pollen\View\PartialAwareViewLoader;
use Pollen\View\ViewLoader;
use RuntimeException;

/**
 * @method string csrf()
 * @method bool isSuccessful()
 * @method string tagName()
 */
class FormViewLoader extends ViewLoader implements FormViewLoaderInterface
{
    use FieldAwareViewLoader;
    use PartialAwareViewLoader;

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
        /** @var FormInterface|object|null $delegate */
        $delegate = $this->engine->getDelegate();
        if ($delegate instanceof FormInterface) {
            return $delegate;
        }
        throw new RuntimeException('FormViewLoader must have a delegation Form instance');
    }
}
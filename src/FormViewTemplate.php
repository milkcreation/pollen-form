<?php

declare(strict_types=1);

namespace Pollen\Form;

use Closure;
use Pollen\View\ViewTemplate;
use RuntimeException;

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
        /** @var FormInterface|object|null $delegate */
        $delegate = $this->engine->getDelegate();
        if ($delegate instanceof FormInterface) {
            return $delegate;
        }

        throw new RuntimeException('FormViewTemplate must have a delegation Form instance');
    }

    /**
     * @inheritDoc
     */
    public function field(string $alias, $idOrParams = null, array $params = []): string
    {
        $manager = $this->form()->fieldManager();

        return (string)$manager->get($alias, $idOrParams, $params);
    }

    /**
     * @inheritDoc
     */
    public function partial(string $alias, $idOrParams = null, array $params = []): string
    {
        $manager = $this->form()->partialManager();

        return (string)$manager->get($alias, $idOrParams, $params);
    }
}
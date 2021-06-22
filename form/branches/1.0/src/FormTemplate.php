<?php

declare(strict_types=1);

namespace Pollen\Form;

use Closure;
use Pollen\View\Engines\Plates\PlatesFieldAwareTemplateTrait;
use Pollen\View\Engines\Plates\PlatesPartialAwareTemplateTrait;
use Pollen\View\Engines\Plates\PlatesTemplate;
use RuntimeException;

/**
 * @method bool isSuccessful()
 * @method string tagName()
 */
class FormTemplate extends PlatesTemplate
{
    use PlatesFieldAwareTemplateTrait;
    use PlatesPartialAwareTemplateTrait;

    /**
     * Post-affichage.
     *
     * @return string
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
     * Pré-affichage.
     *
     * @return string
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
     * Récupération du champ de protection CSRF.
     *
     * @return string
     */
    public function csrf(): string
    {
        return $this->form()->csrfField();
    }

    /**
     * Récupération de l'instance du formulaire associé.
     *
     * @return FormInterface
     */
    public function form(): FormInterface
    {
        /** @var FormInterface|object|null $delegate */
        $delegate = $this->engine->getDelegate();
        if ($delegate instanceof FormInterface) {
            return $delegate;
        }
        throw new RuntimeException('FormTemplate must have a delegation Form instance');
    }
}
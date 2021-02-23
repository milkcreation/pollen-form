<?php

declare(strict_types=1);

namespace Pollen\Form;

use Pollen\View\ViewTemplateInterface;

/**
 * @method string csrf()
 * @method bool isSuccessful()
 * @method string tagName()
 */
interface FormViewTemplateInterface extends ViewTemplateInterface
{
    /**
     * Post-affichage.
     *
     * @return string
     */
    public function after(): string;

    /**
     * Pré-affichage.
     *
     * @return string
     */
    public function before(): string;

    /**
     * Récupération de l'instance du formulaire associé.
     *
     * @return FormInterface
     */
    public function form(): FormInterface;
}
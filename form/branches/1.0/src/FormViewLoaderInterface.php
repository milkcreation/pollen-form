<?php

declare(strict_types=1);

namespace Pollen\Form;

use Pollen\View\FieldAwareViewLoaderInterface;
use Pollen\View\PartialAwareViewLoaderInterface;
use Pollen\View\ViewLoaderInterface;

/**
 * @method string csrf()
 * @method bool isSuccessful()
 * @method string tagName()
 */
interface FormViewLoaderInterface extends
    FieldAwareViewLoaderInterface,
    PartialAwareViewLoaderInterface,
    ViewLoaderInterface
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
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

    /**
     * Rendu d'un champ.
     *
     * @param string|null $alias Alias de qualification.
     * @param mixed $idOrParams Identifiant de qualification|Liste des attributs de configuration.
     * @param array $params Liste des attributs de configuration.
     *
     * @return string
     */
    public function field(string $alias, $idOrParams = null, array $params = []): string;

    /**
     * Rendu d'une portion d'affichage.
     *
     * @param string|null $alias Alias de qualification.
     * @param mixed $idOrParams Identifiant de qualification|Liste des attributs de configuration.
     * @param array $params Liste des attributs de configuration.
     *
     * @return string
     */
    public function partial(string $alias, $idOrParams = null, array $params = []): string;
}
<?php

declare(strict_types=1);

namespace Pollen\Form;

use Pollen\ViewExtends\PlatesTemplateInterface;

/**
 * @method string after()
 * @method string before()
 * @method string csrf()
 * @method FormInterface form()
 * @method bool isSuccessful()
 * @method string tagName()
 */
interface FormTemplateInterface extends PlatesTemplateInterface
{
}
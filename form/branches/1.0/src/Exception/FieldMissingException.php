<?php

declare(strict_types=1);

namespace Pollen\Form\Exception;

use InvalidArgumentException;
use Throwable;

class FieldMissingException extends InvalidArgumentException implements FormException
{
    /**
     * @param string $fieldSlug
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $fieldSlug, string $message = "", int $code = 0, Throwable $previous = null)
    {
        if (empty($message)) {
            $message = sprintf('Field [%s] is missing.', $fieldSlug);
        }

        parent::__construct($message, $code, $previous);
    }
}
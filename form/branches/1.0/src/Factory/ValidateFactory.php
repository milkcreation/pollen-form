<?php

declare(strict_types=1);

namespace Pollen\Form\Factory;

use Exception;
use Pollen\Form\Concerns\FormAwareTrait;
use Pollen\Form\FormInterface;
use Pollen\Support\Concerns\BootableTrait;
use Pollen\Validation\Validator as v;
use RuntimeException;

class ValidateFactory implements ValidateFactoryInterface
{
    use BootableTrait;
    use FormAwareTrait;

    /**
     * Cartographie des alias de fonction de contrôle d'intégrité
     * @var array
     */
    protected $aliases = [];

    /**
     * @inheritDoc
     */
    public function boot(): ValidateFactoryInterface
    {
        if (!$this->isBooted()) {
            if (!$this->form() instanceof FormInterface) {
                throw new RuntimeException('Form ValidateFactory requires a valid related Form instance');
            }

            $this->form()->event('validate.booting', [&$this]);

            $this->setBooted();

            $this->form()->event('validate.booted', [&$this]);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function call($callback, $value, $args = []): bool
    {
        $_args = $args;
        array_unshift($args, $value);

        if (is_string($callback)) {
            try {
                if (preg_match('/^!(.*)/', $callback, $match)) {
                    $callback = $match[1];

                    return !empty($_args)
                        ? !v::$callback(...$_args)->validate($value) : !v::$callback()->validate($value);
                }
                return !empty($_args) ? v::$callback(...$_args)->validate($value) : v::$callback()->validate($value);
            } catch (Exception $e) {
                if (is_callable([$this, $callback])) {
                    return $this->{$callback}(...$args);
                }

                if (function_exists($callback)) {
                    return $callback(...$args);
                }
            }
        } elseif (is_callable($callback)) {
            return $callback(...$args);
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function default($value): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function compare($value, $tags, $raw = true): bool
    {
        return v::equals($this->form()->fields()->metatagsValue($tags, $raw))->validate($value);
    }
}
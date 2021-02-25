<?php

declare(strict_types=1);

namespace Pollen\Form\Factory;

use BadMethodCallException;
use Pollen\Form\Concerns\FormAwareTrait;
use Pollen\Form\FormInterface;
use Pollen\Support\Concerns\BootableTrait;
use Pollen\Support\Concerns\ParamsBagAwareTrait;
use RuntimeException;
use Throwable;

/**
 * @mixin \Pollen\Support\ParamsBag
 */
class OptionsFactory implements OptionsFactoryInterface
{
    use BootableTrait;
    use FormAwareTrait;
    use ParamsBagAwareTrait;

    /**
     * @inheritDoc
     */
    public function __call(string $method, array $arguments)
    {
        try {
            return $this->params()->{$method}(...$arguments);
        } catch (Throwable $e) {
            throw new BadMethodCallException(
                sprintf(
                    'OptionsFactory method call [%s] throws an exception: %s',
                    $method,
                    $e->getMessage()
                )
            );
        }
    }

    /**
     * @inheritDoc
     */
    public function boot(): OptionsFactoryInterface
    {
        if (!$this->isBooted()) {
            if (!$this->form() instanceof FormInterface) {
                throw new RuntimeException('Form OptionsFactory requires a valid related Form instance');
            }

            $this->form()->event('options.booting');

            $this->params((array)$this->form()->params('options', []));
            $this->parseParams();

            $this->form()->event('options.booted');

            $this->setBooted();
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function defaultParams(): array
    {
        return [
            /**
             * @var string|bool $anchor Ancre de défilement verticale de la page web à la soumission du formulaire.
             */
            'anchor'  => false,
            /**
             *
             */
            'error'   => [
                'title'       => '',
                'show'        => -1,
                'teaser'      => '...',
                'field'       => false,
                'dismissible' => false,
            ],
            /**
             *
             */
            'success' => [
                'message' => __(
                    'Votre demande a bien été prise en compte et sera traitée dès que possible.',
                    'tify'
                ),
            ],
        ];
    }
}
<?php

declare(strict_types=1);

namespace Pollen\Form\Factory;

use BadMethodCallException;
use Pollen\Form\Concerns\FormAwareTrait;
use Pollen\Form\FormInterface;
use Pollen\Support\Concerns\BootableTrait;
use Pollen\Support\Concerns\ParamsBagDelegateTrait;
use RuntimeException;
use Throwable;


class OptionsFactory implements OptionsFactoryInterface
{
    use BootableTrait;
    use FormAwareTrait;
    use ParamsBagDelegateTrait;

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
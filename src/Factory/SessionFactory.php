<?php

declare(strict_types=1);

namespace Pollen\Form\Factory;

use Pollen\Form\Concerns\FormAwareTrait;
use Pollen\Form\FormInterface;
use Pollen\Session\AttributeKeyBag;
use Pollen\Support\Concerns\BootableTrait;
use Pollen\Support\Proxy\SessionProxy;
use RuntimeException;

class SessionFactory extends AttributeKeyBag implements SessionFactoryInterface
{
    use BootableTrait;
    use FormAwareTrait;
    use SessionProxy;

    /**
     * @inheritDoc
     */
    public function boot(): SessionFactoryInterface
    {
        if (!$this->isBooted()) {
            if (!$this->form() instanceof FormInterface) {
                throw new RuntimeException('Form SessionFactory requires a valid related Form instance');
            }

            $this->form()->event('session.booting', [&$this]);

            $this->session()->addAttributeKeyBag($this->getKey(), $this);

            $this->setBooted();

            $this->form()->event('session.booted', [&$this]);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function flash($key = null, $default = null)
    {
        if ($key !== null) {
            $namespace = $this->getKey();

            if (is_string($key)) {
                return $this->session()->flash()->get($namespace . '.' . $key);
            }

            if (is_array($key)) {
                foreach ($key as $k => $v) {
                    unset($key[$k]);
                    $key[$namespace . '.' . $k] = $v;
                }
            }
        }

        return $this->session()->flash($key, $default);
    }
}
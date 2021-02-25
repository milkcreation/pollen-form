<?php

declare(strict_types=1);

namespace Pollen\Form\Factory;

use Pollen\Form\Concerns\FormAwareTrait;
use Pollen\Form\FormInterface;
use Pollen\Session\AttributeKeyBag;
use Pollen\Session\SessionManagerInterface;
use Pollen\Support\Concerns\BootableTrait;
use RuntimeException;

class SessionFactory extends AttributeKeyBag implements SessionFactoryInterface
{
    use BootableTrait;
    use FormAwareTrait;

    /**
     * Instance du gestionnaire de sessions.
     * @var $sessionManager
     */
    private $sessionManager;

    /**
     * @inheritDoc
     */
    public function boot(): SessionFactoryInterface
    {
        if (!$this->isBooted()) {
            if (!$this->form() instanceof FormInterface) {
                throw new RuntimeException('Form SessionFactory requires a valid related Form instance');
            }

            if (!$this->sessionManager instanceof SessionManagerInterface) {
                throw new RuntimeException('Form SessionFactory requires a valid SessionManager instance');
            }

            $this->form()->event('session.booting', [&$this]);

            $this->sessionManager->addAttributeKeyBag($this->getKey(), $this);

            $this->setBooted();

            $this->form()->event('session.booted', [&$this]);
        }

        return $this;
    }

    public function setSessionManager(SessionManagerInterface $sessionManager): SessionFactoryInterface
    {
        $this->sessionManager = $sessionManager;

        return $this;
    }
}
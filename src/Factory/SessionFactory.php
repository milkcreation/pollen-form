<?php

declare(strict_types=1);

namespace Pollen\Form\Factory;

use Exception, BadMethodCallException, LogicException;
use tiFy\Contracts\Form\SessionFactory as SessionFactoryContract;
use tiFy\Contracts\Form\FormFactory as FormFactoryContract;
use tiFy\Contracts\Session\Store as SessionStore;
use tiFy\Form\Concerns\FormAwareTrait;
use tiFy\Support\Proxy\Crypt;
use tiFy\Support\Proxy\Session;

/**
 * @mixin \tiFy\Session\Store
 */
class SessionFactory implements SessionFactoryInterface
{
    use FormAwareTrait;

    /**
     * Indicateur de chargement.
     * @var bool
     */
    private $booted = false;

    /**
     * Instance du gestionnaire de session associé.
     * @var SessionStore
     */
    private $store;

    /**
     * Jeton d'identification.
     * @var string|null
     */
    protected $token;

    /**
     * @inheritDoc
     */
    public function __call(string $name, array $arguments)
    {
        try {
            return $this->store()->$name(...$arguments);
        } catch (Exception $e) {
            throw new BadMethodCallException(sprintf(
                'SessionFactory throws an exception during the method call [%s] with message : %s',
                $name, $e->getMessage()
            ));
        }
    }

    /**
     * @inheritDoc
     */
    public function boot(): SessionFactoryContract
    {
        if ($this->booted === false) {
            if (!$this->form() instanceof FormFactoryContract) {
                throw new LogicException('Missing valid FormFactory');
            }

            $this->form()->event('session.boot', [&$this]);

            $this->booted = true;

            $this->form()->event('session.booted', [&$this]);
        }

        return $this;
    }

    /**
     * Génération du jeton de qualification.
     *
     * @return void
     */
    protected function generateToken(): void
    {
        $this->token = Crypt::encrypt(json_encode(['name' => $this->form()->getAlias(), 'id' => uniqid()]));
    }

    /**
     * @inheritDoc
     */
    public function getToken(): string
    {
        if (is_null($this->token)) {
            $this->generateToken();
        }
        return $this->token;
    }

    /**
     * Récupération de l'instance du gestionnaire de session associé.
     *
     * @return SessionStore
     */
    public function store(): SessionStore
    {
        if (is_null($this->store)) {
            $this->store = Session::registerStore("form.{$this->form()->getAlias()}");
        }
        return $this->store;
    }
}
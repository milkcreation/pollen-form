<?php

declare(strict_types=1);

namespace Pollen\Form\Factory;

use Pollen\Http\UrlManipulator;
use Pollen\Http\RedirectResponse;
use Pollen\Form\Concerns\FormAwareTrait;
use Pollen\Form\Exception\FieldValidateException;
use Pollen\Form\FormInterface;
use Pollen\Support\Concerns\BootableTrait;
use Pollen\Support\Concerns\ParamsBagTrait;
use RuntimeException;

class HandleFactory implements HandleFactoryInterface
{
    use BootableTrait;
    use FormAwareTrait;
    use ParamsBagTrait;

    /**
     * Url de redirection.
     * @var string
     */
    protected $redirectUrl;

    /**
     * Indicateur de soumission du formulaire.
     * @var bool|null
     */
    protected $submitted;

    /**
     * Clé d'indice de la protection CSRF.
     * @var string
     */
    protected $tokenKey = '_token';

    /**
     * @inheritDoc
     */
    public function boot(): HandleFactoryInterface
    {
        if (!$this->isBooted()) {
            if (!$this->form() instanceof FormInterface) {
                throw new RuntimeException('Form HandleFactory requires a valid related Form instance');
            }

            $this->form()->event('handle.booting', [&$this]);

            $this->form()->session()->forget(['notices', 'request']);
            $this->form()->messages()->flush();

            switch ($accessor = $this->form()->getMethod()) {
                case 'get':
                    $accessor = 'query';
                    break;
                case 'post':
                    $accessor = 'request';
                    break;
            }

            $this->params($this->form()->getHandleRequest()->{$accessor}->all());

            foreach ($this->form()->fields() as $field) {
                $value = $this->params($field->getName());

                if ($value !== null) {
                    $field->setValue($value);

                    if ($field->supports('session') && $this->form()->supports('session')) {
                        $this->form()->session()->put("request.{$field->getName()}", $value);
                    }
                }
            }

            $this->setBooted();

            $this->form()->event('handle.booted', [&$this]);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function fail(): HandleFactoryInterface
    {
        foreach ($this->form()->fields() as $field) {
            if (!$field->supports('transport')) {
                $field->resetValue();
            }
        }

        $this->form()->session()->forget('notices');

        foreach ($this->form()->messages()->all() as $type => $notices) {
            $this->form()->session()->put("notices.{$type}", $notices);
        }

        $this->form()->event('handle.failed', [&$this]);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRedirectUrl(): string
    {
        if ($this->redirectUrl === null) {
            $this->setRedirectUrl(
                $this->params('_http_referer', $this->form()->getHandleRequest()->headers->get('referer'))
            );
        }

        $this->form()->event('handle.redirect', [&$this->redirectUrl]);

        return $this->redirectUrl;
    }

    /**
     * @inheritDoc
     */
    public function getToken(): string
    {
        return $this->params($this->tokenKey, '');
    }

    /**
     * @inheritDoc
     */
    public function isSubmitted(): bool
    {
        if ($this->submitted === null) {
            $this->submitted = !!wp_verify_nonce($this->getToken(), 'Form' . $this->form()->getAlias())
                && $this->form()->getHandleRequest()->isMethod($this->form()->getMethod());
        }

        return $this->submitted;
    }

    /**
     * @inheritDoc
     */
    public function isValidated(): bool
    {
        if (!$this->form()->messages()->has('error')) {
            $this->form()->event('handle.validated', [&$this]);

            return !$this->form()->messages()->has('error');
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function response(): ?RedirectResponse
    {
        if (!$this->isValidated()) {
            return null;
        }

        $this->boot();

        $this->validate();

        if (!$this->isValidated()) {
            $this->fail();

            return null;
        }

        $this->success();

        return $this->redirect();
    }

    /**
     * @inheritDoc
     */
    public function redirect(): RedirectResponse
    {
        return new RedirectResponse($this->getRedirectUrl());
    }

    /**
     * @inheritDoc
     */
    public function success(): HandleFactoryInterface
    {
        $this->form()->session()->flush();
        $this->form()->setSuccessful()->session()->put('successful', true);

        $this->form()->messages()->success($this->form()->option('success.message', ''));

        $this->form()->event('handle.successful', [&$this]);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setRedirectUrl(string $url, bool $raw = false): HandleFactoryInterface
    {
        if (!$raw) {
            $uri = new UrlManipulator($url);

            if ($this->form()->getMethod() === 'get') {
                $without = ['_token'];
                foreach ($this->form()->fields() as $field) {
                    $without[] = $field->getName();
                }
                $uri = $uri->without($without);
            }

            $url = $uri->withFragment($this->form()->getAnchor())->render();
        }

        $this->redirectUrl = $url;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function validate(): HandleFactoryInterface
    {
        foreach ($this->form()->fields() as $name => $field) {
            try {
                $field->validate();
            } catch (FieldValidateException $e) {
                $field->error($e->getMessage());
            }
        }

        return $this;
    }
}

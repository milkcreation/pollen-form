<?php

declare(strict_types=1);

namespace Pollen\Form\Factory;

use InvalidArgumentException;
use Pollen\Http\UrlManipulator;
use Pollen\Http\RedirectResponse;
use Pollen\Form\Concerns\FormAwareTrait;
use Pollen\Form\Exception\FieldValidateException;
use Pollen\Form\FormInterface;
use Pollen\Support\Concerns\BootableTrait;
use Pollen\Support\ParamsBag;
use RuntimeException;

class HandleFactory implements HandleFactoryInterface
{
    use BootableTrait;
    use FormAwareTrait;

    /**
     * Instance des données de requête HTTP de traitement du formulaire.
     * @var ParamsBag
     */
    protected $datasBag;

    /**
     * Url de redirection en cas d'échec.
     * @var string
     */
    protected $failedRedirectUrl;

    /**
     * Url de redirection en cas de succès.
     * @var string
     */
    protected $succeedRedirectUrl;

    /**
     * Indicateur de soumission du formulaire.
     * @var bool|null
     */
    protected $submitted;

    /**
     * Clé d'indice de la protection CSRF.
     * @var string
     */
    protected $tokenKey;

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

            switch ($accessor = $this->form()->getMethod()) {
                case 'get':
                    $accessor = 'query';
                    break;
                case 'post':
                    $accessor = 'request';
                    break;
            }

            $this->datas($this->form()->getHandleRequest()->{$accessor}->all());

            foreach ($this->form()->formFields() as $field) {
                $value = $this->datas($field->getName());

                if ($field->supports('transport')) {
                    $this->form()->session()->set("request.{$field->getName()}", $value);
                } else {
                    $this->form()->session()->set("request.{$field->getName()}", null);
                }

                $field->setValueFromSession();
            }

            $this->setBooted();

            $this->form()->event('handle.booted', [&$this]);
        }

        return $this;
    }

    /**
     * Définition|Récupération|Instance des données de requête HTTP de traitement du formulaire.
     *
     * @param array|string|null $key
     * @param mixed $default
     *
     * @return string|int|array|mixed|ParamsBag
     *
     * @throws InvalidArgumentException
     */
    public function datas($key = null, $default = null)
    {
        if (!$this->datasBag instanceof ParamsBag) {
            $this->datasBag = new ParamsBag();
        }

        if (is_null($key)) {
            return $this->datasBag;
        }

        if (is_string($key)) {
            return $this->datasBag->get($key, $default);
        }

        if (is_array($key)) {
            $this->datasBag->set($key);
            return $this->datasBag;
        }

        throw new InvalidArgumentException('Invalid Form Handle DatasBag passed method arguments');
    }

    /**
     * @inheritDoc
     */
    public function fail(): HandleFactoryInterface
    {
        foreach ($this->form()->formFields() as $field) {
            if (!$field->supports('transport')) {
                $field->resetValue();
            }
        }

        $this->form()->event('handle.failed', [&$this]);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getFailedRedirectUrl(): string
    {
        if ($this->failedRedirectUrl === null) {
            $this->setFailedRedirectUrl($this->getRefererUrl());
        }

        $this->form()->event('handle.failed.redirect_url', [&$this->failedRedirectUrl]);

        return $this->failedRedirectUrl;
    }

    /**
     * Récupération de l'url de provenance de soumission de formulaire.
     *
     * @return string
     */
    protected function getRefererUrl(): string
    {
        return $this->datas('_http_referer', $this->form()->getHandleRequest()->headers->get('referer'));
    }

    /**
     * @inheritDoc
     */
    public function getSucceedRedirectUrl(): string
    {
        if ($this->succeedRedirectUrl === null) {
            $this->setSucceedRedirectUrl($this->getRefererUrl());
        }

        $this->form()->event('handle.succeed.redirect_url', [&$this->succeedRedirectUrl]);

        return $this->succeedRedirectUrl;
    }

    /**
     * @inheritDoc
     */
    public function isSubmitted(): bool
    {
        $this->boot();

        if ($this->submitted === null) {
            if (!$this->submitted = $this->form()->getHandleRequest()->isMethod($this->form()->getMethod())) {
                //$this->form()->error('Form could not submitted : HTTP method is not allowed.');
                $this->fail();
            } elseif ($tokenValue = $this->tokenValue()) {
                $this->submitted = $this->form()->session()->verifyToken($tokenValue);

                if (!$this->submitted) {
                    $this->form()->error('Form could not submitted : CSRF protection is invalid.');
                    $this->fail();
                }
            } else {
                $this->submitted = true;
            }
        }

        return $this->submitted;
    }

    /**
     * @inheritDoc
     */
    public function isValidated(): bool
    {
        if (!$this->form()->hasError()) {
            $this->form()->event('handle.validated', [&$this]);

            return !$this->form()->hasError();
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function proceed(): RedirectResponse
    {
        if ($this->isSubmitted()) {
            $this->validate();

            if ($this->isValidated()) {
                $this->success();
            } else {
                $this->fail();
            }
        }

        return $this->redirectResponse();
    }

    /**
     * @inheritDoc
     */
    public function redirectResponse(): RedirectResponse
    {
        $response = $this->form->isSuccessful()
            ? new RedirectResponse($this->getSucceedRedirectUrl())
            : new RedirectResponse($this->getFailedRedirectUrl());

        return $response->prepare($this->form()->getHandleRequest());
    }

    /**
     * @inheritDoc
     */
    public function success(): HandleFactoryInterface
    {
        $this->form()->session()->clear();
        $this->form()->setSuccessful()->session()->flash(['successful' => true]);

        if ($mess = $this->form()->option('success', '')) {
            $this->form()->addNotice($mess, 'success');
        }

        $this->form()->event('handle.successful', [&$this]);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setFailedRedirectUrl(string $url, bool $raw = false): HandleFactoryInterface
    {
        $this->failedRedirectUrl = ($raw === false) ? $this->urlGenerator($url) : $url;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setSucceedRedirectUrl(string $url, bool $raw = false): HandleFactoryInterface
    {
        $this->succeedRedirectUrl = ($raw === false) ? $this->urlGenerator($url) : $url;

        return $this;
    }

    /**
     * Indice de la clé de protection CSRF.
     *
     * @return string
     */
    protected function tokenKey(): string
    {
        if ($this->tokenKey === null) {
            $this->tokenKey = $this->form()->csrfKey();
        }

        return $this->tokenKey;
    }

    /**
     * Valeur de la protection CSRF.
     *
     * @return string|null
     */
    protected function tokenValue(): ?string
    {
        if (!$tokenKey = $this->tokenKey()) {
            return null;
        }

        return $this->datas($tokenKey);
    }

    /**
     * Génération d'url
     * {@internal Suppression des arguments de token de champs lorsque la méthode de soumission est GET.}
     * {@internal Ajout de l'ancre lorsque celle ci est définie.}
     *
     * @param string $url
     *
     * @return string
     */
    protected function urlGenerator(string $url): string
    {
        $uri = new UrlManipulator($url);

        if ($this->form()->getMethod() === 'get') {
            $without = [];

            if ($tokenKey = $this->tokenKey()) {
                $without[] = $tokenKey;
            }

            foreach ($this->form()->formFields() as $field) {
                $without[] = $field->getName();
            }
            $uri = $uri->without($without);
        }

        return $uri->withFragment($this->form()->getAnchor())->render();
    }

    /**
     * @inheritDoc
     */
    public function validate(): HandleFactoryInterface
    {
        foreach ($this->form()->formFields() as $name => $field) {
            try {
                $field->validate($this->datas($name));
            } catch (FieldValidateException $e) {
                $field->error($e->getMessage());
            }
        }

        return $this;
    }
}

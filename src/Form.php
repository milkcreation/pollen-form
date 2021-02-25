<?php

declare(strict_types=1);

namespace Pollen\Form;

use InvalidArgumentException;
use Pollen\Field\FieldManagerInterface;
use Pollen\Http\Request;
use Pollen\Http\RequestInterface;
use Pollen\Form\Concerns\FactoryBagTrait;
use Pollen\Form\Factory\AddonsFactory;
use Pollen\Form\Factory\ButtonsFactory;
use Pollen\Form\Factory\EventsFactory;
use Pollen\Form\Factory\FieldsFactory;
use Pollen\Form\Factory\FieldGroupsFactory;
use Pollen\Form\Factory\HandleFactory;
use Pollen\Form\Factory\OptionsFactory;
use Pollen\Form\Factory\SessionFactory;
use Pollen\Form\Factory\ValidateFactory;
use Pollen\Partial\PartialManagerInterface;
use Pollen\Support\Concerns\BootableTrait;
use Pollen\Support\Concerns\BuildableTrait;
use Pollen\Support\Concerns\MessagesBagAwareTrait;
use Pollen\Support\Concerns\ParamsBagAwareTrait;
use Pollen\Support\MessagesBag;
use Pollen\Translation\Concerns\LabelsBagAwareTrait;
use RuntimeException;

class Form implements FormInterface
{
    use BootableTrait;
    use BuildableTrait;
    use FactoryBagTrait;
    use LabelsBagAwareTrait;
    use MessagesBagAwareTrait;
    use ParamsBagAwareTrait;

    /**
     * Instance du gestionnaire de formulaire.
     * @var FormManagerInterface
     */
    private $formManager;

    /**
     * Indicateur d'initialisation de rendu.
     * @var array
     */
    private $renderBuild = [
        'attrs'   => false,
        'fields'  => false,
        'id'      => false,
        'notices' => false,
    ];

    /**
     * Alias de qualification.
     * @var string
     */
    protected $alias = '';

    /**
     * Indice de qualification.
     * @var int|null
     */
    protected $index;

    /**
     * Instance de la requête de traitement .
     * @var RequestInterface|null
     */
    protected $handleRequest;

    /**
     * Indicateur de succès de soumission du formulaire.
     * @var boolean
     */
    protected $successful = false;

    /**
     * Nom de qualification du formulaire dans les attributs de balises HTML.
     * @var string|null
     */
    protected $tagName;

    /**
     * Instance du moteur des gabarits d'affichage.
     * @var FormViewEngineInterface
     */
    protected $viewEngine;

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->render();
    }

    /**
     * @inheritDoc
     */
    public function boot(): FormInterface
    {
        if (!$this->isBooted()) {
            $this->event('form.booting', [&$this]);

            $this->parseParams();

            $services = [
                'events',
                'addons',
                'fields',
                'groups',
                'buttons',
                'handle',
                'options',
                'session',
                'validate',
            ];

            foreach ($services as $service) {
                $service .=  'Factory';

                $this->{$service}->boot();
            }

            $this->setSuccessful((bool)$this->session()->pull('successful', false));

            $this->setBooted();

            $this->event('form.booted', [&$this]);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function build(): FormInterface
    {
        if (!$this->isBuilt()) {
            if (!$this->formManager instanceof FormManagerInterface) {
                throw new RuntimeException('Form must running through a related FormManager');
            }

            if ($this->addonsFactory === null) {
                $this->setAddonsFactory(new AddonsFactory());
            }
            $this->addons()->setForm($this);

            if ($this->buttonsFactory === null) {
                $this->setButtonsFactory(new ButtonsFactory());
            }
            $this->buttons()->setForm($this);

            if ($this->eventsFactory === null) {
                $this->setEventsFactory(
                    (new EventsFactory())->setEventDispatcher($this->formManager->eventDispatcher())
                );
            }
            $this->events()->setForm($this);

            if ($this->fieldsFactory === null) {
                $this->setFieldsFactory(new FieldsFactory());
            }
            $this->fields()->setForm($this);

            if ($this->groupsFactory === null) {
                $this->setGroupsFactory(new FieldGroupsFactory());
            }
            $this->groups()->setForm($this);

            if ($this->handleFactory === null) {
                $this->setHandleFactory(new HandleFactory());
            }
            $this->handle()->setForm($this);

            if ($this->optionsFactory === null) {
                $this->setOptionsFactory(new OptionsFactory());
            }
            $this->options()->setForm($this);

            if ($this->sessionFactory === null) {
                $this->setSessionFactory(
                    (new SessionFactory(md5('Form' . $this->getAlias())))
                        ->setSessionManager($this->formManager->sessionManager())
                );
            }
            $this->session()->setForm($this);

            if ($this->validateFactory === null) {
                $this->setValidateFactory(new ValidateFactory());
            }
            $this->validate()->setForm($this);

            $this->setBuilt();
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function csrf(): string
    {
        return wp_create_nonce('Form' . $this->getAlias());
    }

    /**
     * @inheritDoc
     */
    public function defaultLabels(): array
    {
        return [
            'gender'   => $this->params('labels.gender', false),
            'plural'   => $this->params('labels.plural', $this->getTitle()),
            'singular' => $this->params('labels.singular', $this->getTitle()),
        ];
    }

    /**
     * @inheritDoc
     */
    public function defaultParams(): array
    {
        return [
            /**
             * @var string $action Propriété 'action' de la balise <form/>.
             */
            'action'   => '',
            /**
             * @var array $addons Liste des attributs des addons actifs.
             */
            'addons'   => [],
            /**
             * @var string $after Post-affichage, après la balise <form/>.
             */
            'after'    => '',
            /**
             * @var array $attrs Liste des attributs complémentaires de la balise <form/>.
             */
            'attrs'    => [],
            /**
             * @var string $before Pré-affichage, avant la balise <form/>.
             */
            'before'   => '',
            /**
             * @var array $buttons Liste des attributs des boutons actifs.
             */
            'buttons'  => [],
            /**
             * @var string $enctype Propriété 'enctype' de la balise <form/>.
             */
            'enctype'  => '',
            /**
             * @var array $events Liste des événements de court-circuitage.
             */
            'events'   => [],
            /**
             * @var array $fields Liste des attributs de champs.
             */
            'fields'   => [],
            /**
             * @var string $method Propriété 'method' de la balise <form/>.
             */
            'method'   => 'post',
            /**
             * @var array $options Liste des options du formulaire.
             */
            'options'  => [],
            /**
             * @var string[] $supports Propriété de support.
             */
            'supports' => ['session'],
            /**
             * @var string $title Intitulé de qualification du formulaire.
             */
            'title'    => $this->getAlias(),
            /**
             * @var array $viewer Attributs de configuration du gestionnaire de gabarits d'affichage.
             */
            'viewer'   => [],
            /**
             * @var array $wrapper Attributs de configuration de l'encapsulation du formulaire.
             */
            'wrapper'  => [],
        ];
    }

    /**
     * @inheritDoc
     */
    public function error(string $message, array $datas = []): string
    {
        return $this->messages($message, MessagesBag::ERROR, $datas);
    }

    /**
     * @inheritDoc
     */
    public function fieldManager(): FieldManagerInterface
    {
        return $this->formManager()->fieldManager();
    }

    /**
     * @inheritDoc
     */
    public function formManager(): FormManagerInterface
    {
        return $this->formManager;
    }

    /**
     * @inheritDoc
     */
    public function getAction(): string
    {
        return (string)$this->params('action');
    }

    /**
     * @inheritDoc
     */
    public function getAlias(): string
    {
        return $this->alias;
    }

    /**
     * @inheritDoc
     */
    public function getAnchor(): string
    {
        if ($anchor = $this->option('anchor')) {
            if (!is_string($anchor)) {
                if ($this->renderBuildWrapper() && ($exists = $this->params('wrapper.attrs.id'))) {
                    $anchor = $exists;
                } elseif ($this->renderBuildId() && ($exists = $this->params('attrs.id'))) {
                    $anchor = $exists;
                } else {
                    $anchor = '';
                }
            }

            if ($anchor) {
                return ltrim($anchor, '#');
            }
        }

        return '';
    }

    /**
     * @inheritDoc
     */
    public function getHandleRequest(): RequestInterface
    {
        if ($this->handleRequest === null) {
            $this->handleRequest = $this->formManager()->containerHas(RequestInterface::class)
                ? $this->formManager()->containerGet(RequestInterface::class)
                : Request::createFromGlobals();
        }

        return $this->handleRequest;
    }

    /**
     * @inheritDoc
     */
    public function getIndex(): int
    {
        if ($this->index === null) {
            $this->index = $this->formManager()->getFormIndex($this);
        }
        return $this->index;
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        $method = strtolower($this->params('method'));

        return in_array($method, ['get', 'post']) ? $method : 'post';
    }

    /**
     * @inheritDoc
     */
    public function getSupports(): array
    {
        return (array)$this->params('supports', []);
    }

    /**
     * @inheritDoc
     */
    public function getTitle(): string
    {
        return (string)$this->params('title');
    }

    /**
     * @inheritDoc
     */
    public function hasError(): bool
    {
        return $this->messages()->exists(MessagesBag::ERROR);
    }

    /**
     * @inheritDoc
     */
    public function isSubmitted(): bool
    {
        return $this->handle()->isSubmitted();
    }

    /**
     * @inheritDoc
     */
    public function isSuccessful(): bool
    {
        return $this->successful;
    }

    /**
     * @inheritDoc
     */
    public function parseParams(): FormInterface
    {
        return $this->parseLabels();
    }

    /**
     * @inheritDoc
     */
    public function onSetCurrent(): void
    {
        $this->event('form.set.current', [&$this]);
    }

    /**
     * @inheritDoc
     */
    public function onResetCurrent(): void
    {
        $this->event('form.reset.current', [&$this]);
    }

    /**
     * @inheritDoc
     */
    public function partialManager(): PartialManagerInterface
    {
        return $this->formManager()->partialManager();
    }

    /**
     * @inheritDoc
     */
    public function render(): string
    {
        $this->renderBuild();

        $groups = $this->groups();
        $fields = $this->fields()->preRender();
        $buttons = $this->buttons();
        $notices = $this->messages()->fetchMessages(
            [
                MessagesBag::ERROR,
                MessagesBag::INFO,
                MessagesBag::SUCCESS,
                MessagesBag::WARNING,
            ]
        );

        return $this->view('index', compact('buttons', 'fields', 'groups', 'notices'));
    }

    /**
     * @inheritDoc
     */
    public function renderBuild(): FormInterface
    {
        return $this
            ->renderBuildId()
            ->renderBuildWrapper()
            ->renderBuildAttrs()
            ->renderBuildNotices();
    }

    /**
     * @inheritDoc
     */
    public function renderBuildAttrs(): FormInterface
    {
        if ($this->renderBuild['attrs'] === false) {
            $param = $this->params();

            $default_class = "FormContent FormContent--{$this->tagName()}";
            if (!$param->has('attrs.class')) {
                $param->set('attrs.class', $default_class);
            } else {
                $param->set('attrs.class', sprintf($param->get('attrs.class'), $default_class));
            }
            if (!$param->get('attrs.class')) {
                $param->pull('attrs.class');
            }

            $param->set('attrs.action', $this->getAction());

            $param->set('attrs.method', $this->getMethod());
            if ($enctype = $param->get('enctype')) {
                $param->set('attrs.enctype', $enctype);
            }

            $this->renderBuild['attrs'] = true;
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function renderBuildId(): FormInterface
    {
        if ($this->renderBuild['id'] === false) {
            $param = $this->params();

            if (!$param->has('attrs.id')) {
                $param->set('attrs.id', "FormContent--{$this->tagName()}");
            }
            if (!$param->get('attrs.id')) {
                $param->pull('attrs.id');
            }

            $this->renderBuild['id'] = true;
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function renderBuildNotices(): FormInterface
    {
        if ($this->renderBuild['notices'] === false) {
            if ($this->messages()->count()) {
                $this->session()->remove('notices');
            } elseif ($notices = $this->session()->pull('notices')) {
                foreach ($notices as $type => $items) {
                    foreach ($items as $item) {
                        $this->messages()->log($type, $item['message'] ?? '', $item['datas'] ?? []);
                    }
                }
            }
            if ($this->isSuccessful()) {
                if (!$this->messages()->exists(MessagesBag::SUCCESS)) {
                    $this->messages()->success($this->option('success.message', ''));
                }
                $this->session()->clear();
            } else {
                $this->session()->remove('notices');
            }

            /**
             * @todo
             * Asset::setInlineJs(
             * 'window.addEventListener("load", (event) => {' .
             * 'if(window.location.href.split("#")[1] === "' . $this->getAnchor() . '"){' .
             * 'window.history.pushState("", document.title, window.location.pathname + window.location.search);' .
             * '}});', true);
             */
            $this->renderBuild['successful'] = true;
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function renderBuildWrapper(): FormInterface
    {
        if (($this->renderBuild['wrapper'] ?? false) !== true) {
            $param = $this->params();

            $wrapper = $param->get('wrapper');

            if ($wrapper !== false) {
                $param->set(
                    'wrapper',
                    array_merge(
                        [
                            'tag' => 'div',
                        ],
                        is_array($wrapper) ? $wrapper : []
                    )
                );

                if (!$param->has('wrapper.attrs.id')) {
                    $param->set('wrapper.attrs.id', 'Form--' . $this->tagName());
                }

                if (!$param->has('wrapper.attrs.class')) {
                    $param->set('wrapper.attrs.class', 'Form');
                }
            }

            $this->renderBuild['wrapper'] = true;
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setAlias(string $alias): FormInterface
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setFormManager(FormManagerInterface $formManager): FormInterface
    {
        $this->formManager = $formManager;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setHandleRequest(RequestInterface $handleRequest): FormInterface
    {
        $this->handleRequest = $handleRequest;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setSuccessful(bool $status = true): FormInterface
    {
        $this->successful = $status;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function supports(string $support): bool
    {
        return in_array($support, $this->getSupports(), true);
    }

    /**
     * @inheritDoc
     */
    public function tagName(): string
    {
        return $this->tagName = is_null($this->tagName)
            ? lcfirst(str_replace(' ', '', ucwords(str_replace(['-', '_', '.'], ' ', $this->getAlias()))))
            : $this->tagName;
    }

    /**
     * @inheritDoc
     */
    public function view(?string $view = null, array $data = [])
    {
        if (is_null($this->viewEngine)) {
            $directory = null;
            $overrideDir = null;
            $default = $this->formManager()->config('default.viewer', []);

            if (isset($default['directory'])) {
                $default['directory'] = rtrim($default['directory'], '/') . '/';
                if (file_exists($default['directory'])) {
                    $directory = $default['directory'];
                }
            }

            if (isset($default['override_dir'])) {
                $default['override_dir'] = rtrim($default['override_dir'], '/') . '/';
                if (file_exists($default['override_dir'])) {
                    $overrideDir = $default['override_dir'];
                }
            }

            if ($directory === null) {
                $directory = $this->formManager()->resources('/views');
                if (!file_exists($directory)) {
                    throw new InvalidArgumentException(
                        sprintf('Field [%s] must have an accessible view directory', $this->getAlias())
                    );
                }
            }

            $this->viewEngine = $this->formManager()->containerHas(FormViewEngine::class)
                ? $this->formManager()->containerGet(FormViewEngine::class) : new FormViewEngine();

            $this->viewEngine->setDirectory($directory)->setDelegate($this);

            if ($overrideDir !== null) {
                $this->viewEngine->addFolder('_override_dir', $overrideDir, true);
            }
        }

        if (func_num_args() === 0) {
            return $this->viewEngine;
        }

        return $this->viewEngine->render($view, $data);
    }
}
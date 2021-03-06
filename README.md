# Pollen Form Component

[![Latest Version](https://img.shields.io/badge/release-1.0.0-blue?style=for-the-badge)](https://www.presstify.com/pollen-solutions/form/)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-green?style=for-the-badge)](LICENSE.md)
[![PHP Supported Versions](https://img.shields.io/badge/PHP->=7.4-8892BF?style=for-the-badge&logo=php)](https://www.php.net/supported-versions.php)

Pollen **Form** Component provide tools to generate, process and reuse HTML forms.

## Installation

```bash
composer require pollen-solutions/form
```

## Basic Usage

### Parameters definition

```php
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Pollen\Form\FormManager;

$forms = new FormManager();

$form = $forms->buildForm(
    [
        // alias (required)
        'alias'  => 'auth',
        // Form fields
        'fields' => [
            'login' => [
                'type' => 'text',
            ],
            'pass'  => [
                'type' => 'password',
            ],
        ],
    ]
)->get();

if ($response = $form->handle()->proceed()) {
    (new SapiEmitter())->emit($response->psr());
    exit;
}

echo $form; 
```

### Instance definition

```php
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Pollen\Form\Form;
use Pollen\Form\FormManager;

$forms = new FormManager();

class AuthForm extends Form
{
    protected $alias = 'auth';

    public function defaultParams(): array
    {
        return array_merge(parent::defaultParams(), [
            'fields' => [
                'login' => [
                    'type' => 'text',
                ],
                'pass'  => [
                    'type' => 'password',
                ],
            ],
        ]);
    }
}

$form = $forms->buildForm(new AuthForm())->get();

if ($response = $form->handle()->proceed()) {
    (new SapiEmitter())->emit($response->psr());
    exit;
}

echo $form;
```

### Dependency Injection definition

```php
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Pollen\Container\Container;
use Pollen\Form\Form;
use Pollen\Form\FormManager;

$container = new Container();

$forms = new FormManager([], $container);

class AuthForm extends Form
{
    protected $alias = 'auth';

    public function defaultParams(): array
    {
        return array_merge(parent::defaultParams(), [
            'fields' => [
                'login' => [
                    'type' => 'text',
                ],
                'pass'  => [
                    'type' => 'password',
                ],
            ],
        ]);
    }
}

$container->add(AuthForm::class);

$form = $forms->buildForm(AuthForm::class)->get();

if ($response = $form->handle()->proceed()) {
    (new SapiEmitter())->emit($response->psr());
    exit;
}

echo $form;
```

## Configuration

### Form

```php
[
    /**
     * @var string $action Propri??t?? 'action' de la balise <form/>.
     */
    'action'   => '',
    /**
     * @var array $addons Liste des attributs des addons actifs.
     */
    'addons'   => [],
    /**
     * @var string $after Post-affichage, apr??s la balise <form/>.
     */
    'after'    => '',
    /**
     * @var array $attrs Liste des attributs compl??mentaires de la balise <form/>.
     */
    'attrs'    => [],
    /**
     * @var string $before Pr??-affichage, avant la balise <form/>.
     */
    'before'   => '',
    /**
     * @var array $buttons Liste des attributs des boutons actifs.
     */
    'buttons'  => [],
    /**
     * @var string $enctype Propri??t?? 'enctype' de la balise <form/>.
     */
    'enctype'  => '',
    /**
     * @var array $events Liste des ??v??nements de court-circuitage.
     */
    'events'   => [],
    /**
     * @var array $fields Liste des attributs de champs.
     */
    'fields'   => [],
    /**
     * @var string $method Propri??t?? 'method' de la balise <form/>.
     */
    'method'   => 'post',
    /**
     * @var array $options Liste des options du formulaire.
     */
    'options'  => [],
    /**
     * @var string[] $supports Propri??t?? de support.
     */
    'supports' => [],
    /**
     * @var string $title Intitul?? de qualification du formulaire.
     */
    'title'    => '',
    /**
     * @var array $viewer Attributs de configuration du gestionnaire de gabarits d'affichage.
     */
    'viewer'   => [],
    /**
     * @var array $wrapper Attributs de configuration de l'encapsulation du formulaire.
     */
    'wrapper'  => []
];
```

### Field

```php
[
    /**
     * @var string[]|array $addons Liste des attributs de configuration associ??s aux addons.
     */
    'addons'      => [],
    /**
     * @var string $after Contenu HTML affich?? apr??s le champ.
     */
    'after'       => '',
    /**
     * @var array $attrs Liste des attributs de la balise HTML, hors name et value.
     */
    'attrs'       => [],
    /**
     * @var string $before Contenu HTML affich?? avant le champ.
     */
    'before'      => '',
    /**
     * @var array $choices Liste de choix des valeurs multiples.
     */
    'choices'     => [],
    /**
     * @var array $extras Liste des attributs de configuration compl??mentaires.
     */
    'extras'      => [],
    /**
     * @var string|null $group Alias du groupe d'appartenance.
     */
    'group'       => null,
    /**
     * @var bool|string|array $label Affichage de l'intitul?? de champ. false si masqu??|true charge les attributs
     * par d??faut|array permet de d??finir des attributs personnalis??s.
     */
    'label'       => true,
    /**
     * @var string $name Indice de qualification de la variable de requ??te.
     */
    'name'        => $this->getSlug(),
    /**
     * @var int $position Ordre d'affichage g??n??ral ou dans le groupe s'il est d??fini.
     */
    'position'    => 0,
    /**
     * @var bool|string|array $required {
     * Configuration de champs requis. false si d??sactiv??|true charge les attributs par d??faut|array
     * @type bool|string|array $tagged Affichage de l'indicateur de champ requis. false si masqu??|true charge
     * les attributs par d??faut|string valeur de l'indicateur|array permet de d??finir des attributs personnalis??s.
     * @type bool $check Activation du test d'existence natif.
     * @type mixed $value_none Valeur ?? comparer pour le test d'existence.
     * @type string|callable $call Fonction de validation|alias de qualification.
     * @type array $args Liste des variables pass??es en argument dans la fonction de validation.
     * @type string $message Message de notification de retour en cas d'erreur.
     * }
     */
    'required'    => false,
    /**
     * @var array $supports D??finition des propri??t??s de support. label|wrapper|request|tabindex|transport.
     */
    'supports'    => [],
    /**
     * @var string $title Intitul?? de qualification. Valeur par d??faut. ex. label.
     */
    'title'       => $this->getSlug(),
    /**
     * @var bool|null $transport Court-circuitage de la propri??t?? de support du transport des donn??es ??
     * l'issue de la soumission.
     */
    'transport'   => null,
    /**
     * @var string $type Type de champ.
     */
    'type'        => 'html',
    /**
     * @var array $validations {
     * Liste des fonctions de validation d'int??grit?? du champ lors de la soumission.
     * @type string|callable $call Fonction de validation|alias de qualification.
     * @type array $args Liste des variables pass??es en arguments dans la fonction de validation.
     * @type string $message Message de notification d'erreur.
     * }
     */
    'validations' => [],
    /**
     * @var mixed $value Valeur courante de la variable de requ??te.
     */
    'value'       => '',
    /**
     * @var bool|string|array $wrapper Affichage de l'encapsuleur de champ.
     * false si masqu??|true charge les attributs par d??faut|array permet de d??finir des attributs personnalis??s.
     */
    'wrapper'     => null,
];

```

## Stepwise decomposition

```php
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Pollen\Form\FormManager;
use Pollen\Form\Exception\FieldValidateException;
use Pollen\Http\Request;

// Step 1 : Instantiate the Form Manager
$forms = new FormManager();

// Step 2 : Register a Form
$forms->registerForm(
    'auth',
    [
        'fields' => [
            'login' => [
                'type'     => 'text',
                'required' => true,
            ],
            'pass'  => [
                'type'        => 'password',
                'required'    => true,
                'validations' => 'password',
            ],
        ],
    ]
);

// Step 3 : Get and Boot the Form. After booting the form becomes immutable.
$form = $forms->get('auth')->boot();

// Step 4 : Form validation
$request = Request::createFromGlobals();
$form->setHandleRequest($request);

if ($form->isSubmitted()) {
    $fields = $form->formFields()->all();

    try {
        $fields['login']->validate();
    } catch (FieldValidateException $e) {
        $fields['login']->error(__('Please enter a username.', 'theme'));
    }

    try {
        $fields['pass']->validate();
    } catch (FieldValidateException $e) {
        if ($e->isRequired()) {
            $fields['pass']->error(__('Please enter a password.', 'theme'));
        } elseif ($e->is('password')) {
            $fields['pass']->error(__('Password format is invalid.', 'theme'));
        }
    }

    if (!$form->handle()->isValidated()) {
        $form->handle()->fail();
    } else {
        $form->handle()->success();
    }
}

// Step 5 : Catching HTTP Response
$response = $form->handle()->redirectResponse();

// Step 6 : Form validated submission redirect
if ($form->isSuccessful()) {
    // ... Specific handling
    (new SapiEmitter())->emit($response->psr());
    exit;
}

// Step 6 :
// Option # 1 : Form display after redirect (Best practice)
(new SapiEmitter())->emit($response->psr());
exit;
// Option # 2 : Form output through the POST request (Web Standard practice)
echo $form;
```
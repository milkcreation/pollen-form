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
     * @var array $addons Liste des attributs de configuration associés aux addons.
     */
    'addons'      => [],
    /**
     * @var string $after Contenu HTML affiché après le champ.
     */
    'after'       => '',
    /**
     * @var array $attrs Liste des attributs de la balise HTML, hors name et value.
     */
    'attrs'       => [],
    /**
     * @var string $before Contenu HTML affiché avant le champ.
     */
    'before'      => '',
    /**
     * @var array $choices Liste de choix des valeurs multiples.
     */
    'choices'     => [],
    /**
     * @var array $extras Liste des attributs de configuration complémentaires.
     */
    'extras'      => [],
    /**
     * @var string $group Alias du groupe d'appartenance.
     */
    'group'       => '',
    /**
     * @var bool|string|array $label Affichage de l'intitulé de champ. false si masqué|true charge les attributs
     * par défaut|array permet de définir des attributs personnalisés.
     */
    'label'       => true,
    /**
     * @var string $name Indice de qualification de la variable de requête.
     */
    'name'        => '',
    /**
     * @var int $position Ordre d'affichage général ou dans le groupe s'il est défini.
     */
    'position'    => 0,
    /**
     * @var boolean|string|array $required {
     * Configuration de champs requis. false si désactivé|true charge les attributs par défaut|array
     * @type boolean|string|array $tagged Affichage de l'indicateur de champ requis. false si masqué|true charge
     * les attributs par défaut|string valeur de l'indicateur|array permet de définir des attributs personnalisés.
     * @type boolean $check Activation du test d'existance natif.
     * @type mixed $value_none Valeur à comparer pour le test d'existance.
     * @type string|callable $call Fonction de validation ou alias de qualification.
     * @type array $args Liste des variables passées en argument dans la fonction de validation.
     * @type boolean $raw Activation du format brut de la valeur.
     * @type string $message Message de notification de retour en cas d'erreur.
     * }
     */
    'required'    => false,
    /**
     * @var null|boolean $session Court-circuitage de la propriété de support du stockage en session des données à
     * l'issue de la soumission.
     */
    'session'     => true,
    /**
     * @var array $supports Définition des propriétés de support. label|wrapper|request|tabindex|transport.
     */
    'supports'    => [],
    /**
     * @var string $title Intitulé de qualification. Valeur par défaut. ex. label.
     */
    'title'       => '',
    /**
     * @var boolean|null $transport Court-circuitage de la propriété de support du transport des données à
     * l'issue de la soumission.
     */
    'transport'   => null,
    /**
     * @var string $type Type de champ.
     */
    'type'        => 'html',
    /**
     * @var string|string[]|array[] $validations {
     * Liste des fonctions de validation d'intégrité du champ lors de la soumission.
     * @type string|callable $call Fonction de validation ou alias de qualification.
     * @type array $args Liste des variables passées en arguments dans la fonction de validation.
     * @type string $message Message de notification d'erreur.
     * @type boolean $raw Activation du format brut de la valeur.
     * }
     */
    'validations' => [],
    /**
     * @var mixed $value Valeur courante de la variable de requête.
     */
    'value'       => '',
    /**
     * @var bool|string|array $wrapper Affichage de l'encapuleur de champ. false si masqué|true charge les attributs
     * par défaut|array permet de définir des attributs personnalisés.
     */
    'wrapper'     => null
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
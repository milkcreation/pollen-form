<?php

declare(strict_types=1);

namespace Pollen\Form;

use Pollen\Container\BaseServiceProvider;

class FormServiceProvider extends BaseServiceProvider
{
    /**
     * @var string[]
     */
    protected $provides = [
        FormManagerInterface::class,
        FormViewEngineInterface::class
    ];

    /**
     * @inheritDoc
     */
    public function register(): void
    {
        $this->getContainer()->share(FormManagerInterface::class, function () {
            return new FormManager([], $this->getContainer());
        });

        //$this->registerButtonDrivers();
        //$this->registerFieldDrivers();
        //$this->registerFormFactories();
        $this->registerViewEngine();
    }


    /**
     * @return void

    public function registerButtonDrivers(): void
    {
        $this->getContainer()->add(SubmitButton::class, function (): SubmitButtonInterface {
            return new SubmitButtonDriver();
        });
    }      */

    /**
     * @return void

    public function registerFieldDrivers(): void
    {
        $this->getContainer()->add(FieldDriverContract::class, function (): FieldDriverContract {
            return new FieldDriver();
        });

        $this->getContainer()->add(HtmlFieldDriverContract::class, function (): HtmlFieldDriverContract {
            return new HtmlFieldDriver();
        });

        $this->getContainer()->add(TagFieldDriverContract::class, function (): TagFieldDriverContract {
            return new TagFieldDriver();
        });
    }  */

    /**
     * @return void

    public function registerFormFactories(): void
    {
        $this->getContainer()->add(FormFactoryContract::class, function (): FormFactoryContract {
            return new BaseFormFactory();
        });

        $this->getContainer()->add(AddonsFactoryContract::class, function (): AddonsFactoryContract {
            return new AddonsFactory();
        });

        $this->getContainer()->add(ButtonsFactoryContract::class, function (): ButtonsFactoryContract {
            return new ButtonsFactory();
        });

        $this->getContainer()->add(EventsFactoryContract::class, function (): EventsFactoryContract {
            return new EventsFactory();
        });

        $this->getContainer()->add(FieldsFactoryContract::class, function (): FieldsFactoryContract {
            return new FieldsFactory();
        });

        $this->getContainer()->add(FieldGroupsFactoryContract::class, function (): FieldGroupsFactoryContract {
            return new FieldGroupsFactory();
        });

        $this->getContainer()->add(OptionsFactoryContract::class, function (): OptionsFactoryContract {
            return new OptionsFactory();
        });

        $this->getContainer()->add(HandleFactoryContract::class, function (): HandleFactoryContract {
            return new HandleFactory();
        });

        $this->getContainer()->add(SessionFactoryContract::class, function (): SessionFactoryContract {
            return new SessionFactory();
        });

        $this->getContainer()->add(ValidateFactoryContract::class, function (): ValidateFactoryContract {
            return new ValidateFactory();
        });
    }   */

    /**
     * @return void
     */
    public function registerViewEngine(): void
    {
        $this->getContainer()->add(
            FormViewEngineInterface::class,
            function () {
                return new FormViewEngine();
            }
        );
    }
}
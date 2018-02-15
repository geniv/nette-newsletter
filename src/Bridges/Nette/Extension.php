<?php declare(strict_types=1);

namespace Newsletter\Bridges\Nette;

use GeneralForm\GeneralForm;
use Nette\DI\CompilerExtension;
use Newsletter\FormContainer;
use Newsletter\NewsletterForm;


/**
 * Class Extension
 *
 * @author  geniv
 * @package Newsletter\Bridges\Nette
 */
class Extension extends CompilerExtension
{
    /** @var array default values */
    private $defaults = [
        'autowired'     => true,
        'tablePrefix'   => null,
        'formContainer' => FormContainer::class,
        'events'        => [],
    ];


    /**
     * Load configuration.
     */
    public function loadConfiguration()
    {
        $builder = $this->getContainerBuilder();
        $config = $this->validateConfig($this->defaults);

        $formContainer = GeneralForm::getFormContainerDefinition($this);
        $events = GeneralForm::getEventContainerDefinition($this);

        $builder->addDefinition($this->prefix('default'))
            ->setFactory(NewsletterForm::class, [$config['tablePrefix'], $formContainer, $events])
            ->setAutowired($config['autowired']);
    }
}

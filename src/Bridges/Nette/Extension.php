<?php declare(strict_types=1);

namespace Newsletter\Bridges\Nette;

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
        'autowired'     => null,
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

        // define form container
        $formContainer = $builder->addDefinition($this->prefix('form'))
            ->setFactory($config['formContainer']);

        // define events container
        $events = [];
        foreach ($config['events'] as $event) {
            $events[] = $builder->addDefinition($this->prefix(md5($event)))->setFactory($event);
        }

        $builder->addDefinition($this->prefix('default'))
            ->setFactory(NewsletterForm::class, [$config['tablePrefix'], $formContainer, $events]);

        // if define autowired then set value
        if (isset($config['autowired'])) {
            $builder->getDefinition($this->prefix('default'))
                ->setAutowired($config['autowired']);

            $builder->getDefinition($this->prefix('form'))
                ->setAutowired($config['autowired']);
        }
    }
}

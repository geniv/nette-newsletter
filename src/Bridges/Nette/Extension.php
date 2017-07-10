<?php

namespace Newsletter\Bridges\Nette;

use Nette\DI\CompilerExtension;
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
        'tablePrefix' => null,
    ];


    /**
     * Load configuration.
     */
    public function loadConfiguration()
    {
        $builder = $this->getContainerBuilder();
        $config = $this->validateConfig($this->defaults);

        $builder->addDefinition($this->prefix('default'))
            ->setClass(NewsletterForm::class, [$config]);
    }
}

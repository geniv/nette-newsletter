<?php

namespace Newsletter;

use Nette\Application\UI\Form;
use Nette\Localization\ITranslator;
use Translator\Translator;
use Locale\Locale;
use Dibi\Connection;
use Nette\Application\UI\Control;


/**
 * Class NewsletterForm
 *
 * @author  geniv
 * @package NewsletterForm
 */
class NewsletterForm extends Control
{
    // define constant table names
    const
        TABLE_NAME = 'newsletter';

    /** @var Connection database connection from DI */
    protected $connection;
    /** @var int id locale */
    private $idLocale;
    /** @var string table names */
    private $tableNewsletter;
    /** @var string template path */
    private $templatePath;
    /** @var Translator class */
    private $translator;
    /** @var callback method */
    public $onSuccess;


    /**
     * NewsletterForm constructor.
     *
     * @param array            $parameters
     * @param Connection       $connection
     * @param Locale           $locale
     * @param ITranslator|null $translator
     */
    public function __construct(array $parameters, Connection $connection, Locale $locale, ITranslator $translator = null)
    {
        parent::__construct();

        // define table names
        $this->tableNewsletter = $parameters['tablePrefix'] . self::TABLE_NAME;

        $this->connection = $connection;
        $this->idLocale = $locale->getId();
        $this->translator = $translator;
        $this->templatePath = __DIR__ . '/NewsletterForm.latte';    // implicit path
    }


    /**
     * Set template path.
     *
     * @param string $path
     * @return $this
     */
    public function setTemplatePath($path)
    {
        $this->templatePath = $path;
        return $this;
    }


    /**
     * Create component newsletter form with success callback.
     *
     * @param $name
     * @return Form
     */
    protected function createComponentForm($name)
    {
        $form = new Form($this, $name);
        $form->setTranslator($this->translator);
        $form->addText('email', 'newsletter-form-email')
            ->setRequired('newsletter-form-email-required')
            ->addRule(Form::EMAIL, 'newsletter-form-email-rule-email')
            ->setAttribute('autocomplete', 'off');
        $form->addSubmit('send', 'newsletter-form-send');

        $form->onSuccess[] = function (Form $form, array $values) {
            $arr = [
                'id_locale' => $this->idLocale,
                'email'     => $values['email'],
                'added%sql' => 'NOW()',
                'ip'        => $_SERVER['REMOTE_ADDR'],
            ];

            $ret = $this->connection->insert($this->tableNewsletter, $arr)->execute();
            if ($ret > 0) {
                $this->onSuccess($values);
            }
        };
        return $form;
    }


    /**
     * Render default.
     */
    public function render()
    {
        $template = $this->getTemplate();
        $template->setTranslator($this->translator);
        $template->setFile($this->templatePath);
        $template->render();
    }
}

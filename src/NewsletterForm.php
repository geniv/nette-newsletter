<?php declare(strict_types=1);

namespace Newsletter;

use GeneralForm\EventContainer;
use GeneralForm\IEventContainer;
use GeneralForm\IFormContainer;
use GeneralForm\ITemplatePath;
use Nette\Application\UI\Form;
use Nette\Localization\ITranslator;
use Locale\ILocale;
use Dibi\Connection;
use Nette\Application\UI\Control;


/**
 * Class NewsletterForm
 *
 * @author  geniv
 * @package Newsletter
 */
class NewsletterForm extends Control implements ITemplatePath
{
    // define constant table names
    const
        TABLE_NAME = 'newsletter';

    /** @var string */
    private $tableNewsletter;
    /** @var IFormContainer */
    private $formContainer;
    /** @var IEventContainer */
    private $eventContainer;
    /** @var Connection */
    protected $connection;
    /** @var int */
    private $idLocale;
    /** @var ITranslator */
    private $translator;
    /** @var string */
    private $templatePath;
    /** @var callback */
    public $onSuccess, $onException;


    /**
     * NewsletterForm constructor.
     *
     * @param string           $tablePrefix
     * @param IFormContainer   $formContainer
     * @param array            $events
     * @param Connection       $connection
     * @param ILocale          $locale
     * @param ITranslator|null $translator
     */
    public function __construct(string $tablePrefix, IFormContainer $formContainer, array $events, Connection $connection, ILocale $locale, ITranslator $translator = null)
    {
        parent::__construct();

        // define table names
        $this->tableNewsletter = $tablePrefix . self::TABLE_NAME;
        $this->formContainer = $formContainer;
        $this->eventContainer = new EventContainer($this, $events);
        $this->connection = $connection;
        $this->idLocale = $locale->getId();
        $this->translator = $translator;

        $this->templatePath = __DIR__ . '/NewsletterForm.latte';    // implicit path
    }


    /**
     * Set template path.
     *
     * @param string $path
     */
    public function setTemplatePath(string $path)
    {
        $this->templatePath = $path;
    }


    /**
     * Create component form.
     *
     * @param $name
     * @return Form
     */
    protected function createComponentForm(string $name): Form
    {
        $form = new Form($this, $name);
        $form->setTranslator($this->translator);
        $this->formContainer->getForm($form);

        $form->onSuccess[] = function (Form $form, array $values) {
            try {
                $this->eventContainer->setValues($values);
                $this->eventContainer->notify();

                $this->onSuccess($values);
            } catch (ContactException $e) {
                $this->onException($e);
            }


//            $arr = [
//                'id_locale' => $this->idLocale,
//                'email'     => $values['email'],
//                'added%sql' => 'NOW()',
//                'ip'        => $_SERVER['REMOTE_ADDR'],
//            ];
//
//            $ret = $this->connection->insert($this->tableNewsletter, $arr)->execute();
//            if ($ret > 0) {
//                $this->onSuccess($values);
//            }
        };
        return $form;
    }


    /**
     * Render.
     */
    public function render()
    {
        $template = $this->getTemplate();

        $template->setTranslator($this->translator);
        $template->setFile($this->templatePath);
        $template->render();
    }
}

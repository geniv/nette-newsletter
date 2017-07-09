<?php

namespace Newsletter;

use Nette\Localization\ITranslator;


/**
 * Class Newsletter
 *
 * @author  geniv
 * @package Newsletter
 */
class Newsletter extends Control
{
    private $database, $tableNewsletter, $language;
//FIXME prepsat!!!
    /** @var string template path */
    private $templatePath;
    /** @var Translator class */
    private $translator;
    /** @var callback method */
    public $onSuccess, $onError;


    /**
     * Newsletter constructor.
     *
     * @param \Nette\ComponentModel\IContainer $tableNewsletter
     * @param \Dibi\Connection                 $database
     * @param BaseLanguageService              $language
     */
    public function __construct(array $parameters, \Dibi\Connection $database, \LanguageService\LanguageService $language, ITranslator $translator = null)
    {
        parent::__construct();
        $this->database = $database;
        $this->tableNewsletter = $tableNewsletter;
        $this->language = $language;
        $this->translator = $translator;
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
     * komponenta formulare
     *
     * @param $name
     * @return \Nette\Application\UI\Form
     */
    protected function createComponentForm($name)
    {
        $form = new Nette\Application\UI\Form($this, $name);
        $form->setTranslator($this->translator);
        $form->addText('email', 'Váš E-mail')
            ->setRequired('Pole emailu musí být vyplněno.')
            ->addRule(Nette\Forms\Form::EMAIL, 'Musí být zadaný validní email.')
            ->setAttribute('autocomplete', 'off');
        $form->addSubmit('send', 'Odeslat');
        $form->onSuccess[] = [$this, 'processOnSuccessForm'];
        return $form;
    }


    /**
     * zpracovani formulare
     *
     * @param \Nette\Application\UI\Form $form
     * @param array                      $values
     */
    public function processOnSuccessForm(Nette\Application\UI\Form $form, array $values)
    {
        $arr = [
            'Language' => $this->language->getCode(),
            'Email'    => $values['email'],
            'Added'    => new \DateTime,
            'Ip'       => $_SERVER['REMOTE_ADDR'],
        ];

        $ret = $this->database->insert($this->tableNewsletter, $arr)
            ->execute(Dibi::IDENTIFIER);
        if ($ret > 0) {
            $this->parent->flashMessage('Váš email byl uložen.', 'success');
            $this->parent->redirect('//this');
        }
    }


    /**
     * render komponenty
     */
    public function render()
    {
        $template = $this->getTemplate();

        $template->addFilter(null, 'LatteFilter::common');
        $template->setTranslator($this->translator);
        $template->setFile(__DIR__ . '/Newsletter.latte');
        $template->render();
    }
}

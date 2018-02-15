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
    /** @var IFormContainer */
    private $formContainer;
    /** @var IEventContainer */
    private $eventContainer;
    /** @var ITranslator */
    private $translator;
    /** @var string */
    private $templatePath;
    /** @var callback */
    public $onSuccess, $onException;


    /**
     * NewsletterForm constructor.
     *
     * @param IFormContainer   $formContainer
     * @param array            $events
     * @param ITranslator|null $translator
     */
    public function __construct(IFormContainer $formContainer, array $events, ITranslator $translator = null)
    {
        parent::__construct();

        $this->formContainer = $formContainer;
        $this->eventContainer = new EventContainer($this, $events);
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
                $this->eventContainer->notify($values);

                $this->onSuccess($values);
            } catch (NewsletterException $e) {
                $this->onException($e);
            }
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

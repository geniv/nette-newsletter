<?php declare(strict_types=1);

namespace Newsletter;

use GeneralForm\IFormContainer;
use Nette\Application\UI\Form;
use Nette\SmartObject;


/**
 * Class FormContainer
 *
 * @author  geniv
 * @package Newsletter
 */
class FormContainer implements IFormContainer
{
    use SmartObject;


    /**
     * Get form.
     *
     * @param Form $form
     */
    public function getForm(Form $form)
    {
        $form->addText('email', 'newsletter-form-email')
            ->setRequired('newsletter-form-email-required')
            ->addRule(Form::EMAIL, 'newsletter-form-email-rule-email')
            ->setAttribute('autocomplete', 'off');
        $form->addSubmit('send', 'newsletter-form-send');
    }
}

Newsletter
==========

Installation
------------
```sh
$ composer require geniv/nette-newsletter
```
or
```json
"geniv/nette-newsletter": ">=1.0.0"
```

require:
```json
"php": ">=5.6.0",
"nette/nette": ">=2.4.0",
"dibi/dibi": ">=3.0.0",
"geniv/nette-locale": ">=1.0.0",
"geniv/nette-general-form": ">=1.0.0"
```

Include in application
----------------------
neon configure:
```neon
# newsletter
newsletter:
    tablePrefix: %tablePrefix%
#   formContainer: FormContainer
    events:
        - Contact\Events\EmailEvent
        - AjaxFlashMessageEvent
```

neon configure extension:
```neon
extensions:
    newsletter: Newsletter\Bridges\Nette\Extension
```

usage:
```php
protected function createComponentNewsletterForm(NewsletterForm $newsletterForm)
{
    //$mailerLiteForm->setTemplatePath(__DIR__ . '/templates/NewsletterForm.latte');
    $newsletterForm->onSuccess[] = function (array $values) {
        $this->flashMessage('Email has been save!', 'success');
        $this->redirect('this');
    };
    return $newsletterForm;
}
```

usage:
```latte
{control newsletterForm}
```

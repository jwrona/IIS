<?php

use Nette\Application\UI\Form;

/**
 * Sign in/out presenters.
 */
class SignPresenter extends BasePresenter {

    /**
     * Sign-in form factory.
     * @return Nette\Application\UI\Form
     */
    protected function createComponentSignInForm() {
        $form = new Form;
        $form->addText('username', 'Login:', 30, 20)
		->setRequired('Nebyl zadan login.');
        $form->addPassword('password', 'Heslo:', 30)
		->setRequired('Nebylozadano heslo.');
        $form->addSubmit('login', 'Přihlásit se');
        $form->onSuccess[] = $this->signInFormSubmitted;
        return $form;
    }

    public function signInFormSubmitted(Form $form) {
        $values = $form->getValues();

	try {
		$this->getUser()->login($values->username, $values->password);
		$this->getUser()->setExpiration('+ 10 minutes', 'TRUE');
	} catch (Nette\Security\AuthenticationException $e) {
		$form->addError($e->getMessage());
		return;
	}
	$this->redirect('Homepage:');
    }
}

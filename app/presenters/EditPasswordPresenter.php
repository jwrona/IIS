<?php

use Nette\Application\UI\Form;
use Nette\Security as NS;

/**
 */
class EditPasswordPresenter extends BasePresenter {

    /** @var Todo\Authenticator */
    private $authenticator;
    private $zamestnanecRepository;

    protected function startup() {
        parent::startup();
        $this->checkLoggedIn();
        $this->authenticator = $this->context->authenticator;
	$this->zamestnanecRepository = $this->context->zamestnanecRepository;
    }

    protected function createComponentPasswordForm() {
        $form = new Form();
        $form->addPassword('oldPassword', 'Staré heslo:', 30)
                ->addRule(Form::FILLED, 'Je nutné zadat staré heslo.');
        $form->addPassword('newPassword', 'Nové heslo:', 30)
                ->addRule(Form::MIN_LENGTH, 'Nové heslo musí mít alespoň %d znaků.', 6);
        $form->addPassword('confirmPassword', 'Potvrzení hesla:', 30)
                ->addRule(Form::FILLED, 'Nové heslo je nutné zadat ještě jednou pro potvrzení.')
                ->addRule(Form::EQUAL, 'Zadná hesla se musejí shodovat.', $form['newPassword']);
        $form->addSubmit('set', 'Změnit heslo');
        $form->onSuccess[] = $this->passwordFormSubmitted;
        return $form;
    }

    public function passwordFormSubmitted(Form $form) {
        $values = $form->getValues();
        $user = $this->getUser();
        try {
            $this->authenticator->authenticate(array($user->getIdentity()->username, $values->oldPassword));
            $this->zamestnanecRepository->setPassword($user->getId(), $values->newPassword);
            $this->flashMessage('Heslo bylo změněno.', 'success');
            $this->redirect('Homepage:');
        } catch (NS\AuthenticationException $e) {
            $form->addError($e->getMessage());
            return;
        }
    }
}

<?php

use Nette\Application\UI\Form;
use Nette\Security as NS;

/**
 */
class ZamestnanecPresenter extends BasePresenter {

    /** @var Todo\UserRepository */
    protected $zamestnanecRepository;
    protected $uvazekRepository;
    protected $zamestnanci;

    /** @var Todo\Authenticator */
    private $authenticator;

    protected function startup() {
        parent::startup();
        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect('Sign:in');
        }
        $this->zamestnanecRepository = $this->context->zamestnanecRepository;
        $this->uvazekRepository = $this->context->uvazekRepository;
        $this->authenticator = $this->context->authenticator;
    }

    public function renderAll() {
        $this->template->zamestnanci = $this->zamestnanecRepository->findAll();
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
            $form->addError('Zadané heslo není správné.');
        }
    }

    protected function createComponentUserDetailForm() {
        $form = new Form();
        $form->addText('jmeno', 'Jméno', 50, 50)->setValue($this->user->getIdentity()->jmeno);
        $form->addText('prijmeni', 'Příjmení', 50, 50)->setValue($this->user->getIdentity()->prijmeni);
        $form->addSelect('uvazek', 'Úvazek', $this->uvazekRepository->najdiUvazky($this->getUser()->getId()));
        $form->addSubmit('set', 'Potvrdit');
        echo $this->getUser()->getId();
        //$form->onSuccess[] = $this->passwordFormSubmitted;
        return $form;
    }

}
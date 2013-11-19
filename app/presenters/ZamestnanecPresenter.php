<?php

use Nette\Application\UI\Form;
use Nette\Security as NS;

/**
 */
class ZamestnanecPresenter extends BasePresenter {

    /** @var Todo\UserRepository */
    protected $zamestnanecRepository;
    protected $uvazekRepository;

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
        $this->template->lekari = $this->zamestnanecRepository->findDoctors();
        $this->template->sestry = $this->zamestnanecRepository->findNurses();
        $this->template->administratori = $this->zamestnanecRepository->findAdministrators();
    }

    public function renderDetail($IDzamestnance) {
        $this->template->zamestnanec = $this->zamestnanecRepository->findByIDzamestnance($IDzamestnance);
        $this->template->uvazky = $this->uvazekRepository->findByIDzamestnance($IDzamestnance);
    }

    public function renderEdit($IDzamestnance) {
        $this->template->zamestnanec = $this->zamestnanecRepository->findByIDzamestnance($IDzamestnance);
        $this->template->uvazky = $this->uvazekRepository->findByIDzamestnance($IDzamestnance);
    }
    
    public function actionDelete($IDzamestnance){
        $this->flashMessage('Uživatel má být vymazán.', 'success');
        $this->setView('all');
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

    protected function createComponentUserEditForm() {
        $form = new Form();
        $form->addText('jmeno', 'Jméno', 50, 50);
        $form->addText('prijmeni', 'Příjmení', 50, 50);
        $form->addText('username', 'Username', 50, 50);
        $form->addSubmit('set', 'Uložit');
        $form->onSuccess[] = $this->userEditSubmitted;
        return $form;
    }

    public function userEditSubmitted(Form $form) {
        $this->flashMessage('Údaje o uživateli byly uloženy.', 'success');
        $this->redirect('Zamestnanec:all');
    }

}
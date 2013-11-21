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

        if (!$this->getUser()->isinRole('administrator')) {
            $this->redirect('Err:access');
        }

        $this->zamestnanecRepository = $this->context->zamestnanecRepository;
        $this->uvazekRepository = $this->context->uvazekRepository;
        $this->authenticator = $this->context->authenticator;
    }

    public function renderDefault() {
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
        $userEditForm = $this['userEditForm'];
        $userEditForm->setDefaults(array(
            'IDzamestnance' => $this->template->zamestnanec->IDzamestnance,
            'jmeno' => $this->template->zamestnanec->jmeno,
            'prijmeni' => $this->template->zamestnanec->prijmeni,
            'username' => $this->template->zamestnanec->username
        ));
    }

    public function actionDelete($IDzamestnance) {
        $this->zamestnanecRepository->deleteZamestnanec($IDzamestnance);
        $this->uvazekRepository->deleteZamestnanec($IDzamestnance);
        $this->flashMessage('Uživatel byl vymazán.', 'success');
        $this->setView('default');
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

    protected function createComponentUserEditForm() {
        $form = new Form();
        $form->addHidden('IDzamestnance');
        $form->addText('jmeno', 'Jméno', 50, 50)->addRule(Form::FILLED, 'Je potřeba uvést jméno.');
        $form->addText('prijmeni', 'Příjmení', 50, 50)->addRule(Form::FILLED, 'Je potřeba uvést příjmení.');
        $form->addText('username', 'Username', 50, 50)->addRule(Form::FILLED, 'Je potřeba uvést přihlašovací jméno.');
        $form->addSubmit('set', 'Uložit');
        $form->onSuccess[] = $this->userEditSubmitted;
        return $form;
    }

    public function userEditSubmitted(Form $form) {
        $values = $form->getValues();
        $this->zamestnanecRepository->updateZamestnanec($values->IDzamestnance, $values->jmeno, $values->prijmeni, $values->username);
        $this->flashMessage('Údaje o uživateli byly uloženy.', 'success');
        $this->redirect('Zamestnanec:default');
    }

    protected function createComponentUserAddForm() {
        $form = new Form();
        $form->addHidden('password', '$2a$07$hn9edyker6dj0gxi4dqu0utddnn77xn6y1vDEtVX4gO998t2SwTvW');
        $form->addText('jmeno', 'Jméno', 50, 50)->addRule(Form::FILLED, 'Je potřeba uvést jméno.');
        $form->addText('prijmeni', 'Příjmení', 50, 50)->addRule(Form::FILLED, 'Je potřeba uvést příjmení.');
        $form->addText('username', 'Username', 50, 50)->addRule(Form::FILLED, 'Je potřeba uvést přihlašovací jméno.');
        $form->addSelect('role', 'Zaměstnání', array('sestra' => 'sestra', 'lekar' => 'lékař', 'administrator' => 'administrátor'));
        $form->addSubmit('set', 'Uložit');
        $form->onSuccess[] = $this->userAddSubmitted;
        return $form;
    }

    public function userAddSubmitted(Form $form) {
        $values = $form->getValues();
        $this->zamestnanecRepository->addZamestnanec($values->jmeno, $values->prijmeni, $values->username, $values->password, $values->role);
        $this->flashMessage('Údaje o uživateli byly uloženy.', 'success');
        $this->redirect('Zamestnanec:default');
    }

}

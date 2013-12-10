<?php

use Nette\Application\UI;
use Nette\Diagnostics\Debugger;

Debugger::enable(); // aktivujeme Laděnku

/**
 * Homepage presenter.
 */
class PacientPresenter extends BasePresenter {

    /** @var Todo\UserRepository */
    protected $pacientRepository;
    protected $oddeleniRepository;

    protected function startup() {
        parent::startup();
        $this->checkLoggedIn();

        $this->pacientRepository = $this->context->pacientRepository;
        $this->oddeleniRepository = $this->context->oddeleniRepository;

        $string = $this->link('this');
        $pattern = '/([^\?])\?.*/i';
        $replacement = '$1';
        $urlForMenu = preg_replace($pattern, $replacement, $string);
        $this->menu->selectByUrl($urlForMenu);
    }

    public function renderDefault() {
        $this->redirect('all');
    }

    /**
     * Hospitalizovani
     */
    public function renderHospitalizovani($zkratkaOdd) {
        if ($zkratkaOdd != NULL) {
            $this->template->pacienti = $this->pacientRepository->findByOddeleni($zkratkaOdd);
        } else {
            $this->template->pacienti = NULL;
        }
    }

    protected function createComponentSelectPacientForm() {
        $form = new UI\Form;
        $oddeleni = $this->oddeleniRepository->findAll()->fetchPairs('zkratkaOdd', 'nazev');

        $form->addSelect('oddeleni', 'Oddělení:', $oddeleni)
                ->setPrompt("Zvolte oddělení")   // je možné předat text i prvek HTML
                ->setAttribute('onchange', 'submit()');

        $form->onSuccess[] = callback($this, 'selectPacientFormSubmitted');
        return $form;
    }

    public function selectPacientFormSubmitted(UI\Form $form) {
        $values = $form->getValues();
        $this->redirect('this', $values->oddeleni);
    }

    /**
     * Nehospitalizovani
     */
    public function renderNehospitalizovani($searchPhrase = "all") {
        if ($searchPhrase == "all")
            $pacienti = $this->pacientRepository->findAllNehospitalizovani();
        else if ($searchPhrase != NULL)
            $pacienti = $this->pacientRepository->findInNehospitalizovani($searchPhrase);
        else
            $pacienti = NULL;

        $this->template->pacienti = $pacienti;
    }

    /**
     * Vsichni
     */
    public function renderAll($searchPhrase = "all") {
        if ($searchPhrase == "all")
            $this->template->pacienti = $this->pacientRepository->findAll();
        else if ($searchPhrase != NULL)
            $this->template->pacienti = $this->pacientRepository->searchInTable($searchPhrase);
        else
            $this->template->pacienti = NULL;
    }

    protected function createComponentSearchForm() {
        $form = new UI\Form;
        $form->addText('search', 'Hledat', 40);
        $form->addSubmit('send', 'Hledat');
        $form->onSuccess[] = callback($this, 'searchFormSubmitted');
        return $form;
    }

    public function searchFormSubmitted(UI\Form $form) {
        $values = $form->getValues();
        if ($values->search != NULL)
            $this->redirect('this', $values->search);
        else
            $this->redirect('this');
    }

    /**
     * Pridani noveho
     */
    public function renderAdd() {
        
    }

    protected function createComponentAddForm() {
        $form = new UI\Form;
        $form->addText('jmeno', 'Jméno', 50, 50)
                ->setRequired('Je potřeba uvést jméno.');
        $form->addText('prijmeni', 'Příjmení', 50, 50)
                ->setRequired('Je potřeba uvést příjmení.');
        $form->addText('rc', 'Rodné číslo', 12, 10)
                ->setRequired('Je potřeba uvést rodné číslo.')
                ->addRule(UI\Form::INTEGER, 'Zadejte prosím rodné číslo ve tvaru RRMMDDXXXX.');

        $form->addSubmit('send', 'Přidat');
        $form->onSuccess[] = callback($this, 'addSubmitted');

        return $form;
    }

    public function addSubmitted(UI\Form $form) {
        $values = $form->getValues();
        try {
            $this->pacientRepository->addPacient($values->jmeno, $values->prijmeni, $values->rc);
        } catch (Exception $exc) {
            $this->flashMessage('Chyba - Pacient nebyl přidán. Pravděpodobně již existuje pacient s tímto rodným číslem.', 'error');
            return;
        }
        $this->flashMessage('Pacient byl úspěšně přidán.', 'success');
        $this->redirect('all');
    }

    /**
     * Zobrazeni detailu
     */
    public function renderDetail($rodneCislo) {
        if ($rodneCislo != NULL) {
            $this->template->pacient = $this->pacientRepository->findByRodneCislo($rodneCislo);
            $this->template->hospitalizovan = $this->pacientRepository->findHospitalizovanNyni($rodneCislo);
            $this->template->pocetHospitalizaci = $this->pacientRepository->findPocetHospitalizaci($rodneCislo);
        }
    }

    /**
     * Editace pacienta
     */
    public function renderEdit($rodneCislo) {
        $this->template->pacient = $this->pacientRepository->findByRodneCislo($rodneCislo);
    }

    protected function createComponentEditForm() {
        $pacient = $this->pacientRepository->findByRodneCislo($this->getParam('rodneCislo'));
        $form = new UI\Form;
        $form->addText('jmeno', 'Jméno', 50, 50)
                ->setRequired('Je potřeba uvést jméno.')
                ->setDefaultValue($pacient->jmeno);
        $form->addText('prijmeni', 'Příjmení', 50, 50)
                ->setRequired('Je potřeba uvést příjmení.')
                ->setDefaultValue($pacient->prijmeni);
        $form->addHidden('rc')->setDefaultValue($pacient->rodneCislo);

        $form->addSubmit('send', 'Uložit změny');
        $form->onSuccess[] = callback($this, 'editSubmitted');

        return $form;
    }

    public function editSubmitted(UI\Form $form) {
        $values = $form->getValues();
        $this->pacientRepository->editPacient($values->jmeno, $values->prijmeni, $values->rc);
        $this->flashMessage('Pacient byl úspěšně změněn.', 'success');
        $this->redirect('all');
    }

    /**
     * Smazání pacienta
     */
    public function actionDelete($rodneCislo) {
        $this->pacientRepository->deletePacient($rodneCislo);
        $this->flashMessage('Pacient byl vymazán.', 'success');
        $this->redirect('all');
    }

    /**
     * Hospitalizace pacienta
     */
    public function actionHospitalizovat($rodneCislo) {
        $this->redirect('all', $rodneCislo);
    }

    /**
     * Vyšetření pacienta
     */
    public function actionAddVysetreni($rodneCislo) {
        $this->redirect('all', $rodneCislo);
    }

}

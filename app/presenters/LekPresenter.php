<?php

use Nette\Application\UI\Form;
use Nette\Security as NS;

class LekPresenter extends BasePresenter {

    private $lekRepository;

    protected function startup() {
        parent::startup();
        $this->checkLoggedIn();

        if (!$this->getUser()->isinRole('lekar') && !$this->getUser()->isinRole('administrator')) {
            $this->redirect('Err:access');
        }

        $this->lekRepository = $this->context->lekRepository;
    }

    public function renderDefault() {
        $this->template->leky = $this->lekRepository->findAllLeky();
    }

    public function renderSearch($nazev) {
        $this->template->leky = $this->lekRepository->findLekyByName($nazev);
        $this->template->nazev = $nazev;
    }

    protected function createComponentSearchLekForm() {
        $form = new Form();
        $form->addText('nazev', 'Název', 50, 50);
        $form->addSubmit('set', 'Vyhledat');
        $form->onSuccess[] = $this->SearchLekFormSubmitted;
        return $form;
    }

    public function SearchLekFormSubmitted(Form $form) {
        $values = $form->getValues();
        $this->redirect('Lek:search', $values->nazev);
    }

    protected function createComponentViewAllButton() {
        $form = new Form();
        $form->addSubmit('set', 'Zobrazit vše');
        $form->onSuccess[] = $this->ViewAllButtonSubmitted;
        return $form;
    }

    public function ViewAllButtonSubmitted(Form $form) {
        $values = $form->getValues();
        $this->redirect('Lek:');
    }

}


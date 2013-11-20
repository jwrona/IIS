<?php

use Nette\Application\UI\Form;
use Nette\Security as NS;

/**
 */
class OddeleniPresenter extends BasePresenter {

    protected $oddeleniRepository;

    protected function startup() {
        parent::startup();
        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect('Sign:in');
        }

        $this->oddeleniRepository = $this->context->oddeleniRepository;
    }

    public function renderAll() {
        $this->template->oddeleni = $this->oddeleniRepository->findAllOddeleni();
    }
    
        protected function createComponentOddeleniAddForm() {
        $form = new Form();
        $form->addText('zkratkaOdd', 'Zkratka', 3, 3)->addRule(Form::FILLED, 'Je třeba zadat unikátní zkratku oddělení.');
        $form->addText('nazev', 'Název', 50, 50)->addRule(Form::FILLED, 'Je třeba zadat název oddělení.');
        $form->addSubmit('set', 'Uložit');
        $form->onSuccess[] = $this->oddeleniAddSubmitted;
        return $form;
    }

    public function oddeleniAddSubmitted(Form $form) {
        $values = $form->getValues();
        $this->oddeleniRepository->addOddeleni($values->zkratkaOdd, $values->nazev);
        $this->flashMessage('Oddělení bylo přidáno.', 'success');
        $this->redirect('Oddeleni:all');
    }
}
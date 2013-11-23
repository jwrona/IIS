<?php

use Nette\Application\UI\Form;
use Nette\Security as NS;

class LekPresenter extends BasePresenter {

    private $podaniLekuRepository;
    private $lekRepository;
    private $pacientRepository;

    protected function startup() {
        parent::startup();
        $this->checkLoggedIn();

        if (!$this->getUser()->isinRole('lekar') && !$this->getUser()->isinRole('administrator')) {
            $this->redirect('Err:access');
        }

        $this->podaniLekuRepository = $this->context->podaniLekuRepository;
        $this->lekRepository = $this->context->lekRepository;
        $this->pacientRepository = $this->context->pacientRepository;
    }

    public function renderDefault($searchPhrase = "all") {
        if ($searchPhrase == "all") {
            $this->template->leky = $this->lekRepository->findAll();
        } else if ($searchPhrase != NULL) {
            $this->template->leky = $this->lekRepository->searchInTable($searchPhrase);
        } else {
            $this->template->leky = NULL;
        }
    }

    protected function createComponentSearchForm() {
        $form = new Form;
        $form->addText('search', 'Hledat', 40);
        $form->addSubmit('send', 'Hledat');
        $form->onSuccess[] = callback($this, 'searchFormSubmitted');
        return $form;
    }

    public function searchFormSubmitted(Form $form) {
        $values = $form->getValues();
        if ($values->search != NULL) {
            $this->redirect('this', $values->search);
        } else {
            $this->redirect('this');
        }
    }

    public function renderPrescribe($searchPhrase = "all", $rodneCislo) {
        $this->template->rodneCislo = $rodneCislo;

        $prescribeSearchForm = $this['prescribeSearchForm'];
        $prescribeSearchForm->setDefaults(array(
            'rodneCislo' => $rodneCislo));

        if ($searchPhrase == "all") {
            $this->template->leky = $this->lekRepository->findAll();
        } else if ($searchPhrase != NULL) {
            $this->template->leky = $this->lekRepository->searchInTable($searchPhrase);
        } else {
            $this->template->leky = NULL;
        }
    }

    protected function createComponentPrescribeSearchForm() {
        $form = new Form;
        $form->addHidden('rodneCislo');
        $form->addText('search', 'Hledat', 40);
        $form->addSubmit('send', 'Hledat');
        $form->onSuccess[] = callback($this, 'prescribeSearchFormSubmitted');
        return $form;
    }

    public function prescribeSearchFormSubmitted(Form $form) {
        $values = $form->getValues();
        if ($values->search != NULL) {
            $this->redirect('this', $values->search, $values->rodneCislo);
        } else {
            $this->redirect('this', 'all', $values->rodneCislo);
        }
    }

    public function renderAdd($rodneCislo, $IDleku) {
        //$this->template->pacient = $this->pacientRepository->findByRodneCislo($rodneCislo);
        $this->template->IDleku = $IDleku;

        $addLekForm = $this['addLekForm'];
        $addLekForm->setDefaults(array(
            'rodneCislo' => $rodneCislo,
            'IDleku' => $IDleku));
    }

    protected function createComponentAddLekForm() {
        $form = new Form;
        $form->addHidden('IDleku');
        $form->addHidden('rodneCislo');
        $form->addText('zacatekPodani', 'Od')->addRule(Form::FILLED, 'Je nutné vyplnit datum.')
                ->addRule(Form::PATTERN, 'Datum ve tvaru rrrr-mm-dd', '[0-9][0-9][0-9][0-9]-{1}[0-1][0-2]-{1}[0-3][0-9]');
        $form->addText('konecPodani', 'Do')->addRule(Form::FILLED, 'Je nutné vyplnit datum.')
                ->addRule(Form::PATTERN, 'Datum ve tvaru rrrr-mm-dd', '[0-9][0-9][0-9][0-9]-{1}[0-1][0-2]-{1}[0-3][0-9]');
        $form->addText('mnozstvi', 'Množství')->addRule(Form::PATTERN, 'Celé číslo', '[0-9]*');
        $form->addText('opakovaniDenne', 'Opakování za den')->addRule(Form::PATTERN, 'Celé číslo', '[0-9]*');
        $form->addText('zpusobPodani', 'Způsob podání');
        $form->addSubmit('set', 'Předepsat');
        $form->onSuccess[] = $this->addLekFormSubmitted;
        return $form;
    }

    public function addLekFormSubmitted(Form $form) {
        $values = $form->getValues();
        $this->podaniLekuRepository->addPodaniLeku($values->IDleku, 
                                            $values->rodneCislo, 
                                            $values->zacatekPodani, 
                                            $values->konecPodani, 
                                            $values->mnozstvi,
                                            $values->opakovaniDenne, 
                                            $values->zpusobPodani);
        $this->flashMessage('Lék byl předepsán.', 'success');
        $this->redirect('Hospitalizace:default');
    }

}


<?php

use Nette\Application\UI\Form;

class HospitalizacePresenter extends BasePresenter {

    private $hospitalizaceRepository;
    protected $oddeleniRepository;

    protected function startup() {
        parent::startup();

        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect('Sign:in');
        }

        $this->hospitalizaceRepository = $this->context->hospitalizaceRepository;
        $this->oddeleniRepository = $this->context->oddeleniRepository;
    }

    public function renderDefault() {
        $this->template->hospitalizace = $this->hospitalizaceRepository->findByIDlekare($this->getUser()->getIdentity()->getId());
    }

    public function renderDetail($IDhospitalizace) {
        $this->template->leky = $this->hospitalizaceRepository->findLeky($IDhospitalizace);
        $this->template->vysetreni = $this->hospitalizaceRepository->findVysetreni($IDhospitalizace);
        $this->template->pacient = $this->hospitalizaceRepository->findPacient($IDhospitalizace);
        $this->template->lekar = $this->hospitalizaceRepository->findLekar($IDhospitalizace);
    }

    public function renderSearch($zkratkaOdd) {
        if ($zkratkaOdd == NULL) {
            $this->template->hospitalizace = $this->hospitalizaceRepository->findByIDlekare($this->getUser()->getIdentity()->getId());
        } else {
            $this->template->hospitalizace = $this->hospitalizaceRepository->findByIDlekareZkratkaOdd(
                                                                             $this->getUser()->getIdentity()->getId(),
                                                                             $zkratkaOdd);
        }
    }
    
    public function renderAdd($rodneCislo) {
        //$this->template->hospitalizace = $this->hospitalizaceRepository->findByIDlekare($this->getUser()->getIdentity()->getId());
    }

    protected function createComponentSearchHospitalizaceForm() {
        $form = new Form();
        $form->addSelect('oddeleni', 'Oddělení', $this->oddeleniRepository->findPairsZkratkaOddNazevIDzamestnance($this->getUser()->getIdentity()->getId()));
        $form->addSubmit('set', 'Zobrazit');
        $form->onSuccess[] = $this->SearchHospitalizaceFormSubmitted;
        return $form;
    }

    public function SearchHospitalizaceFormSubmitted(Form $form) {
        $values = $form->getValues();
        $this->redirect('Hospitalizace:search', $values->oddeleni);
    }

    protected function createComponentViewAllButton() {
        $form = new Form();
        $form->addSubmit('set', 'Zobrazit vše');
        $form->onSuccess[] = $this->ViewAllButtonSubmitted;
        return $form;
    }

    public function ViewAllButtonSubmitted(Form $form) {
        $values = $form->getValues();
        $this->redirect('Hospitalizace:');
    }

}
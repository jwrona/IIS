<?php

use Nette\Application\UI;

class HospitalizacePresenter extends BasePresenter {

    private $hospitalizaceRepository;
    protected $oddeleniRepository;

    protected function startup() {
        parent::startup();
        $this->checkLoggedIn();

        $this->hospitalizaceRepository = $this->context->hospitalizaceRepository;
        $this->oddeleniRepository = $this->context->oddeleniRepository;
    }

    public function renderDefault($zkratkaOdd) {
        if ($zkratkaOdd != NULL) {
            $this->template->hospitalizace = $this->hospitalizaceRepository->findByIDlekareZkratkaOdd(
                                                                             $this->getUser()->getIdentity()->getId(),
                                                                             $zkratkaOdd);
        } else {
            $this->template->hospitalizace = $this->hospitalizaceRepository->findByIDlekare($this->getUser()->getIdentity()->getId());
        }
    }

    public function renderDetail($IDhospitalizace) {
        $this->template->leky = $this->hospitalizaceRepository->findLeky($IDhospitalizace);
        $this->template->vysetreni = $this->hospitalizaceRepository->findVysetreni($IDhospitalizace);
        $this->template->pacient = $this->hospitalizaceRepository->findPacient($IDhospitalizace);
        $this->template->lekar = $this->hospitalizaceRepository->findLekar($IDhospitalizace);
    }

    public function renderAdd($rodneCislo) {
        //$this->template->hospitalizace = $this->hospitalizaceRepository->findByIDlekare($this->getUser()->getIdentity()->getId());
    }

    protected function createComponentSelectHospitalizaceForm() {
        $form = new UI\Form;
        $oddeleni = $this->oddeleniRepository->findPairsZkratkaOddNazevIDzamestnance($this->getUser()->getIdentity()->getId());

        $form->addSelect('oddeleni', 'Oddělení:', $oddeleni)
                ->setPrompt("Zvolte oddělení")   // je možné předat text i prvek HTML
                ->setAttribute('onchange', 'submit()');

        $form->onSuccess[] = callback($this, 'selectHospitalizaceFormSubmitted');
        return $form;
    }

    public function selectHospitalizaceFormSubmitted(UI\Form $form) {
        $values = $form->getValues();
        $this->redirect('this', $values->oddeleni);
    }

}
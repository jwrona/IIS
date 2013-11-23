<?php

use Nette\Application\UI\Form;

class VysetreniPresenter extends BasePresenter {

    protected $vysetreniRepository;
    protected $oddeleniRepository;

    protected function startup() {
        parent::startup();
        $this->checkLoggedIn();

        $this->vysetreniRepository = $this->context->vysetreniRepository;
        $this->oddeleniRepository = $this->context->oddeleniRepository;
    }

    public function renderAdd($rodneCislo) {
        $addVysetreniForm = $this['addVysetreniForm'];
        $addVysetreniForm->setDefaults(array(
            'IDlekare' => $this->getUser()->getIdentity()->getId(),
            'rodneCislo' => $rodneCislo
        ));
    }

    protected function createComponentAddVysetreniForm() {
        $form = new Form();
        $form->addHidden('IDlekare');
        $form->addHidden('rodneCislo');        
        $form->addSelect('oddeleni', 'Oddělení', $this->oddeleniRepository->findPairsZkratkaOddNazev());
        $form->addText('CasProvedeni', 'Datum')->addRule(Form::FILLED, 'Je nutné vyplnit datum.');
        $form->addText('vysledek', 'Výsledek');
        $form->addSubmit('set', 'Uložit');
        $form->onSuccess[] = $this->AddVysetreniFormSubmitted;
        return $form;
    }

    public function AddVysetreniFormSubmitted(Form $form) {
        $values = $form->getValues();
        $this->vysetreniRepository->AddVysetreni($values->IDlekare, $values->rodneCislo, $values->oddeleni, $values->CasProvedeni, $values->vysledek);
        $this->redirect('Homepage:');
    }

}

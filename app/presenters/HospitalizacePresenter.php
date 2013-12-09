<?php

use Nette\Application\UI\Form;

class HospitalizacePresenter extends BasePresenter {

    private $hospitalizaceRepository;
    protected $oddeleniRepository;
    protected $pacientRepository;

    protected function startup() {
        parent::startup();
        $this->checkLoggedIn();

        $this->hospitalizaceRepository = $this->context->hospitalizaceRepository;
        $this->oddeleniRepository = $this->context->oddeleniRepository;
        $this->pacientRepository = $this->context->pacientRepository;
    }

    public function renderDefault($zkratkaOdd) {
        if ($zkratkaOdd != NULL) {
            if ($this->getUser()->isinRole('lekar')) {
                $this->template->hospitalizace = $this->hospitalizaceRepository->findByIDlekareZkratkaOdd(
                        $this->getUser()->getIdentity()->getId(), $zkratkaOdd);
            } elseif ($this->getUser()->isinRole('sestra')) {
                $this->template->hospitalizace = $this->hospitalizaceRepository->findByZkratkaOdd($zkratkaOdd);
            } else {
                $this->template->hospitalizace = $this->hospitalizaceRepository->findByZkratkaOdd($zkratkaOdd);
            }
        } else {
            $this->template->hospitalizace = NULL;
        }
    }

    public function renderDetail($IDhospitalizace) {
        $this->template->leky = $this->hospitalizaceRepository->findLeky($IDhospitalizace);
        $this->template->vysetreni = $this->hospitalizaceRepository->findVysetreni($IDhospitalizace);
        $this->template->pacient = $this->hospitalizaceRepository->findPacient($IDhospitalizace);
        $this->template->lekar = $this->hospitalizaceRepository->findLekar($IDhospitalizace);
    }

    public function renderAdd($rodneCislo) {
        $this->template->pacient = $this->pacientRepository->findByRodneCislo($rodneCislo);
        //$this->template->hospitalizace = $this->hospitalizaceRepository->findByIDlekare($this->getUser()->getIdentity()->getId());
        $addHospitalizaceForm = $this['addHospitalizaceForm'];
        $addHospitalizaceForm->setDefaults(array(
            'rodneCislo' => $rodneCislo
        ));
    }

    protected function createComponentSelectHospitalizaceForm() {
        $form = new Form();

        if ($this->getUser()->isinRole('lekar')) {
            $oddeleni = $this->oddeleniRepository->findPairsZkratkaOddNazevIDzamestnance($this->getUser()->getIdentity()->getId());
        }
        if ($this->getUser()->isinRole('sestra')) {
            $oddeleni = $this->oddeleniRepository->findPairsZkratkaOddNazevIDsestry($this->getUser()->getIdentity()->getId());
        }
        if ($this->getUser()->isinRole('administrator')) {
            $oddeleni = $this->oddeleniRepository->findPairsZkratkaOddNazev();
        }

        $form->addSelect('oddeleni', 'Oddělení:', $oddeleni)
                ->setPrompt("Zvolte oddělení")   // je možné předat text i prvek HTML
                ->setAttribute('onchange', 'submit()');

        $form->onSuccess[] = callback($this, 'selectHospitalizaceFormSubmitted');
        return $form;
    }

    public function selectHospitalizaceFormSubmitted(Form $form) {
        $values = $form->getValues();
        $this->redirect('this', $values->oddeleni);
    }

    protected function createComponentAddHospitalizaceForm() {
        $form = new Form();

        if ($this->getUser()->isinRole('lekar')) {
            $oddeleni = $this->oddeleniRepository->findPairsZkratkaOddNazevIDzamestnance($this->getUser()->getIdentity()->getId());
        }
        $form->addHidden('rodneCislo');
        $form->addSelect('zkratkaOdd', 'Oddělení', $oddeleni)
                ->setPrompt("Zvolte oddělení");
        $form->addText('datumPrijeti', 'Datum přijetí')->addRule(Form::FILLED, 'Je nutné vyplnit datum.')
                ->addRule(Form::PATTERN, 'Datum ve tvaru rrrr-mm-dd', '[0-9][0-9][0-9][0-9]-{1}[0-1][0-2]-{1}[0-3][0-9]');
        $form->addSubmit('set', 'Hospitalizovat');
        $form->onSuccess[] = callback($this, 'addHospitalizaceFormSubmitted');
        return $form;
    }

    public function addHospitalizaceFormSubmitted(Form $form) {
        $value = $form->getValues();
        $this->hospitalizaceRepository->addHospitalizace($value->rodneCislo, $value->zkratkaOdd, $value->datumPrijeti, $this->getUser()->getIdentity()->getId());
        $this->redirect('Hospitalizace:');
    }

}
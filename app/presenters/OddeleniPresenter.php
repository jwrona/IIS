<?php

use Nette\Application\UI\Form;
use Nette\Security as NS;

/**
 */
class OddeleniPresenter extends BasePresenter {

    protected $oddeleniRepository;

    protected function startup() {
        parent::startup();
        $this->checkLoggedIn();

        if (!$this->getUser()->isinRole('administrator')) {
            $this->redirect('Err:access');
        }

        $this->oddeleniRepository = $this->context->oddeleniRepository;
    }

    public function renderDefault() {
        $this->template->oddeleni = $this->oddeleniRepository->findAllOddeleni();
    }

    public function renderEdit($zkratkaOdd) {
        $this->template->oddeleni = $this->oddeleniRepository->findOddeleni($zkratkaOdd);
        $oddeleniEditForm = $this['oddeleniEditForm'];
        $oddeleniEditForm->setDefaults(array(
            'zkratkaOdd' => $zkratkaOdd,
            'nazev' => $this->template->oddeleni->nazev));
    }

    public function actionDelete($zkratkaOdd) {
        $this->oddeleniRepository->deleteOddeleni($zkratkaOdd);
        $this->flashMessage('Oddělení bylo vymazáno.', 'success');
        $this->redirect('Oddeleni:');
    }

    protected function createComponentOddeleniAddForm() {
        $form = new Form();
        $form->addText('zkratkaOdd', 'Zkratka', 3, 3)->addRule(Form::FILLED, 'Je třeba zadat unikátní zkratku oddělení.')
                ->addRule(Form::PATTERN, 'Zkratka oddělení: tři písmena', '[A-Z|a-z]{3}');
        $form->addText('nazev', 'Název', 50, 50)->addRule(Form::FILLED, 'Je třeba zadat název oddělení.');
        $form->addSubmit('set', 'Uložit');
        $form->onSuccess[] = $this->oddeleniAddSubmitted;
        return $form;
    }

    public function oddeleniAddSubmitted(Form $form) {
        $values = $form->getValues();
        try {
            $this->oddeleniRepository->addOddeleni($values->zkratkaOdd, $values->nazev);
        } catch (Exception $exc) {
            $this->flashMessage('Chyba - Oddělení nebylo přidáno. Oddělení s touto zkratkou pravděpodobně již existuje.', 'error');
            return;
        }
        $this->flashMessage('Oddělení bylo přidáno.', 'success');
        $this->redirect('Oddeleni:');
    }

    protected function createComponentOddeleniEditForm() {
        $form = new Form();
        $form->addHidden('zkratkaOdd');
        $form->addText('nazev', 'Název', 50, 50)->addRule(Form::FILLED, 'Je třeba zadat název oddělení.');
        $form->addSubmit('set', 'Uložit');
        $form->onSuccess[] = $this->oddeleniEditSubmitted;
        return $form;
    }

    public function oddeleniEditSubmitted(Form $form) {
        $values = $form->getValues();
        $this->oddeleniRepository->updateOddeleni($values->zkratkaOdd, $values->nazev);
        $this->flashMessage('Oddělení bylo zmeneno.', 'success');
        $this->redirect('Oddeleni:');
    }

}

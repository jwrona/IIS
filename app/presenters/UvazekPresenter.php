<?php

use Nette\Application\UI\Form;
use Nette\Security as NS;

/**
 */
class UvazekPresenter extends BasePresenter {

    /** @var Todo\UserRepository */
    protected $uvazekRepository;

    protected function startup() {
        parent::startup();
        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect('Sign:in');
        }
        $this->uvazekRepository = $this->context->uvazekRepository;
    }

    public function renderEdit($IDzamestnance, $zkratkaOdd) {
        $this->template->uvazek = $this->uvazekRepository->findByIDzamestnanceZkratkaOdd($IDzamestnance, $zkratkaOdd);
        $uvazekEditForm = $this['uvazekEditForm'];
        $uvazekEditForm->setDefaults(array(
            'IDzamestnance' => $this->template->uvazek->IDlekare,
            'oddeleni' => $this->template->uvazek->zkratkaOdd,
            'typ' => $this->template->uvazek->roleUvazku,
            'telefon' => $this->template->uvazek->telefon
        ));
    }
    
    public function renderAdd($IDzamestnance) {
        $this->template->IDzamestnance = $IDzamestnance;
        $uvazekAddForm = $this['uvazekAddForm'];
        $uvazekAddForm->setDefaults(array(
            'IDzamestnance' => $IDzamestnance));
    }

    public function actionDelete($IDzamestnance, $zkratkaOdd) {
        $this->uvazekRepository->deleteUvazek($IDzamestnance, $zkratkaOdd);
        $this->flashMessage('Úvazek byl vymazán.', 'success');
        $this->redirect('Zamestnanec:edit', $IDzamestnance);
    }

    protected function createComponentUvazekEditForm() {
        $form = new Form();
        $form->addHidden('IDzamestnance');
        $form->addText('oddeleni', 'Oddělení', 50, 50)->addRule(Form::FILLED, 'Je potřeba uvést zkratku oddělení.');
        $form->addText('typ', 'Typ', 50, 50)->addRule(Form::FILLED, 'Je potřeba typ úvazku.');
        $form->addText('telefon', 'telefon', 9, 9);
        $form->addSubmit('set', 'Uložit');
        $form->onSuccess[] = $this->uvazekEditSubmitted;
        return $form;
    }

    public function uvazekEditSubmitted(Form $form) {
        $values = $form->getValues();
        $this->uvazekRepository->updateUvazek($values->IDzamestnance, $values->oddeleni, $values->typ, $values->telefon);
        $this->flashMessage('Údaje o úvazku byly změněny.', 'success');
        $this->redirect('Zamestnanec:edit', $values->IDzamestnance);
    }

    protected function createComponentUvazekAddForm() {
        $form = new Form();
        $form->addHidden('IDzamestnance');
        $form->addText('oddeleni', 'Oddělení', 50, 50)->addRule(Form::FILLED, 'Je potřeba uvést zkratku oddělení.');
        $form->addText('typ', 'Typ', 50, 50)->addRule(Form::FILLED, 'Je potřeba typ úvazku.');
        $form->addText('telefon', 'telefon', 9, 9);
        $form->addSubmit('set', 'Uložit');
        $form->onSuccess[] = $this->uvazekAddSubmitted;
        return $form;
    }

    public function uvazekAddSubmitted(Form $form) {
        $values = $form->getValues();
        $this->uvazekRepository->addUvazek($values->IDzamestnance, $values->oddeleni, $values->typ, $values->telefon);
        $this->flashMessage('Úvazek byl lékaři přidán.', 'success');
        $this->redirect('Zamestnanec:edit', $values->IDzamestnance);
    }

}
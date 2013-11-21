<?php


use Nette\Application\UI;

/**
 * Homepage presenter.
 */
class PacientPresenter extends BasePresenter {
    /** @var Todo\UserRepository */
    protected $pacientRepository;
    protected $oddeleniRepository;

    protected function startup() {
        parent::startup();
        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect('Sign:in');
        }
        $this->pacientRepository = $this->context->pacientRepository;
        $this->oddeleniRepository = $this->context->oddeleniRepository;
    }

    public function renderDefault()
    {
        $this->redirect('Pacient:all');
    }

    public function renderAll() {

        $this->template->pacienti = $this->pacientRepository->findAll();
    }

    protected function createComponentSelectPacientForm() {
        $form = new UI\Form;
	$oddeleni = $this->oddeleniRepository->findAll()->fetchPairs('zkratkaOdd', 'nazev');
	$form->addSelect('oddeleni', 'Oddělení:', $oddeleni)//->setPrompt("neco");   // je možné předat text i prvek HTML
             ->setAttribute('onchange', 'submit()');
        $form->onSuccess[] = callback($this, 'selectPacientSubmitted');
        return $form;
    }

    public function selectPacientSubmitted(UI\Form $form) {
        $this->flashMessage('HORRRRAY', 'success');
	$this->redirect('this');
    }
}

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

	$string = $this->link('this');
	$pattern = '/([^\?])\?.*/i';
	$replacement = '$1';
	$urlForMenu = preg_replace($pattern, $replacement, $string);
        $this->menu->selectByUrl($urlForMenu);
    }

/*
    public function actionDefault($id) {
        $this->flashMessage($id);
        //$this->setView('all');
    }

    public function actionAll($id) {
        $this->flashMessage($id);
    }

    public function actionNobody($id) {
        $this->flashMessage($id);
    }
*/
    public function renderDefault()
    {
        //$this->redirect('all', 'abc');
    }

    public function renderAll($zkratkaOdd)
    {
	if ($zkratkaOdd != NULL)
        {
            $this->template->pacienti = $this->pacientRepository->findByOddeleni($zkratkaOdd);
        }
	else
        {
            $this->template->pacienti = NULL;
        }
    }

    protected function createComponentSelectPacientForm() {
        $form = new UI\Form;
	$oddeleni = $this->oddeleniRepository->findAll()->fetchPairs('zkratkaOdd', 'nazev');

	$form->addSelect('oddeleni', 'Oddělení:', $oddeleni)
                 ->setPrompt("Zvolte oddělení")   // je možné předat text i prvek HTML
                 ->setAttribute('onchange', 'submit()');

        $form->onSuccess[] = callback($this, 'selectPacientFormSubmitted');
        return $form;
    }

    public function selectPacientFormSubmitted(UI\Form $form) {
	$values = $form->getValues();
	$this->redirect('Pacient:all', $values->oddeleni);
    }
}

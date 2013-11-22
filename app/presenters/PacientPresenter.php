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
	$this->checkLoggedIn();

        $this->pacientRepository = $this->context->pacientRepository;
        $this->oddeleniRepository = $this->context->oddeleniRepository;

	$string = $this->link('this');
	$pattern = '/([^\?])\?.*/i';
	$replacement = '$1';
	$urlForMenu = preg_replace($pattern, $replacement, $string);
        $this->menu->selectByUrl($urlForMenu);
    }

    public function renderDefault()
    {
        //$this->redirect('all', 'abc');
    }

    /**
     * Hospitalizovani
     */
    public function renderHospitalizovani($zkratkaOdd)
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
	$this->redirect('this', $values->oddeleni);
    }


    /**
     * Nehospitalizovani
     */
    public function renderNehospitalizovani($searchPhrase = "all")
    {
	if ($searchPhrase == "all")
            $this->template->pacienti = $this->pacientRepository->findAllNehospitalizovani();
	else if ($searchPhrase != NULL)
            $this->template->pacienti = $this->pacientRepository->findInNehospitalizovani($searchPhrase);
	else
            $this->template->pacienti = NULL;
    }

    /**
     * Vsichni
     */
    public function renderAll($searchPhrase = "all")
    {
	if ($searchPhrase == "all")
            $this->template->pacienti = $this->pacientRepository->findAll();
	else if ($searchPhrase != NULL)
            $this->template->pacienti = $this->pacientRepository->searchInTable($searchPhrase);
	else
            $this->template->pacienti = NULL;
    }

    protected function createComponentSearchForm() {
        $form = new UI\Form;
	$form->addText('search', 'Hledat', 40);
        $form->addSubmit('send', 'Hledat');
        $form->onSuccess[] = callback($this, 'searchFormSubmitted');
        return $form;
    }

    public function searchFormSubmitted(UI\Form $form) {
	$values = $form->getValues();
	if ($values->search != NULL)
	    $this->redirect('this', $values->search);
	else
	    $this->redirect('this');
    }

    /**
     * Pridani noveho
     */
    public function renderAdd()
    {
    }

    protected function createComponentAddForm() {
        $form = new UI\Form;
        $form->addText('jmeno', 'Jméno', 50, 50)
                 ->setRequired('Je potřeba uvést jméno.');
        $form->addText('prijmeni', 'Příjmení', 50, 50)
                 ->setRequired('Je potřeba uvést příjmení.');
        $form->addText('rc', 'Rodné číslo', 12, 10)
                 ->setRequired('Je potřeba uvést rodné číslo.')
		 ->addRule(UI\Form::INTEGER, 'Zadejte prosím rodné číslo ve tvaru RRMMDDXXXX.');

        $form->addSubmit('send', 'Přidat');
        $form->onSuccess[] = callback($this, 'addSubmitted');

        return $form;
    }

    public function addSubmitted(UI\Form $form) {
	$values = $form->getValues();
        $this->pacientRepository->addPacient($values->jmeno, $values->prijmeni, $values->rc);
        $this->flashMessage('Pacient byl úspěšně přidán.', 'success');
	$this->redirect('this');
    }
}

<?php

/**
 * Homepage presenter.
 */
class PacientPresenter extends BasePresenter {
    /** @var Todo\UserRepository */
    protected $pacientRepository;

    protected function startup() {
        parent::startup();
        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect('Sign:in');
        }
        $this->pacientRepository = $this->context->pacientRepository;
    }

    public function renderDefault()
    {
        $this->redirect('Pacient:all');
    }

    public function renderAll() {
        $this->template->pacienti = $this->pacientRepository->findAll();
    }
}

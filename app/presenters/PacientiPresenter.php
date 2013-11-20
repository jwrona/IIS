<?php

/**
 * Homepage presenter.
 */
class PacientiPresenter extends BasePresenter {
    /** @var Todo\UserRepository */
    protected $pacientRepository;

    protected function startup() {
        parent::startup();
        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect('Sign:in');
        }
        $this->pacientRepository = $this->context->pacientRepository;
    }

    public function renderDefault() {
        $this->template->pacienti = $this->pacientRepository->findAll();
    }
}

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

    public function renderAll() {
        $this->template->pacienti = $this->pacientRepository->findAll();
    }

    public function createComponentMenu() {
        $menu = new Murdej\Menu;
        return $menu;
    }
}

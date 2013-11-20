<?php

use Nette\Application\UI\Form;
use Nette\Security as NS;

/**
 */
class OddeleniPresenter extends BasePresenter {

    protected $oddeleniRepository;

    protected function startup() {
        parent::startup();
        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect('Sign:in');
        }

        $this->oddeleniRepository = $this->context->oddeleniRepository;
    }

}
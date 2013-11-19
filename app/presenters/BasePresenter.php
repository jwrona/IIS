<?php

use Nette\Application\UI\Form;

/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter {

    /** @var Todo\ListRepository */
    protected $zamestnanecRepository;

    public function handleSignOut() {
        $this->getUser()->logout();
        $this->redirect('Sign:in');
    }

}

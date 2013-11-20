<?php

use Nette\Application\UI\Formi,
    Nette\Security\User,
    Nette\Security;

/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter {

    public function handleSignOut() {
        $this->getUser()->logout();
        $this->flashMessage('Odhlaseni probehlo uspesne.', 'success');
        $this->redirect('Sign:in');
    }
}

<?php

use Nette\Application\UI\Formi,
    Nette\Security\User,
    Nette\Security;

/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter {

    private $user;

    protected function startup() {
        parent::startup();
        $this->user = $this->getUser();
    }

    protected function checkLoggedIn() {
        if (!$this->getUser()->isLoggedIn()) {
            if ($this->user->logoutReason === Nette\Security\IUserStorage::INACTIVITY) {
                $this->flashMessage('Byl jste odhlášen z důvodu neaktivity. Posím přihlašte se znovu.');
            }
            $this->redirect('Sign:in');
        }
    }

    public function handleSignOut() {
        $this->user->logout();
        $this->flashMessage('Odhlaseni probehlo uspesne.', 'success');
        $this->redirect('Sign:in');
    }

    public function createComponentMenu() {
        $sideMenu = new Murdej\Menu;

        $pac0 = new Murdej\MenuNode;
        $pac0->name = "Pacienti";
        $pac0->link = 'Pacient:default';
        $pac0->id = 'pac0';
        $sideMenu->rootNode->add($pac0);
        $pac01 = new Murdej\MenuNode;
        $pac01->name = "Všichni";
        $pac01->link = 'Pacient:all';
        $pac01->id = 'pac01';
        $pac0->add($pac01);

        $pac02 = new Murdej\MenuNode;
        $pac02->name = "Hospitalizovaní";
        $pac02->link = 'Pacient:hospitalizovani';
        $pac02->id = 'pac02';
        $pac0->add($pac02);

        $pac03 = new Murdej\MenuNode;
        $pac03->name = "Nehospitalizovaní";
        $pac03->link = 'Pacient:nehospitalizovani';
        $pac03->id = 'pac03';
        $pac0->add($pac03);
        if ($this->user->isInRole('lekar') | $this->user->isInRole('administrator')) {
            $pac04 = new Murdej\MenuNode;
            $pac04->name = "Přidat";
            $pac04->link = 'Pacient:add';
            $pac04->id = 'pac04';
            $pac0->add($pac04);
        }
        $hos0 = new Murdej\MenuNode;
        $hos0->name = "Hospitalizace";
        $hos0->link = 'Hospitalizace:default';
        $hos0->id = 'hos0';
        $sideMenu->rootNode->add($hos0);

        if ($this->user->isInRole('lekar') | $this->user->isInRole('administrator')) {
            $lek0 = new Murdej\MenuNode;
            $lek0->name = "Databáze léků";
            $lek0->link = 'Lek:default';
            $lek0->id = 'lek0';
            $sideMenu->rootNode->add($lek0);
        }

        if ($this->user->isInRole('administrator')) {
            $zam0 = new Murdej\MenuNode;
            $zam0->name = "Zaměstnanci";
            $zam0->link = 'Zamestnanec:default';
            $zam0->id = 'zam0';
            $sideMenu->rootNode->add($zam0);

            $odd0 = new Murdej\MenuNode;
            $odd0->name = "Oddělení";
            $odd0->link = 'Oddeleni:';
            $odd0->id = 'odd0';
            $sideMenu->rootNode->add($odd0);
        }
        return $sideMenu;
    }

    public function getMenu() {
        return $this->getComponent('menu');
    }

}

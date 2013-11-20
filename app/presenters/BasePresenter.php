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

    public function createComponentMenu() {
        $sideMenu = new Murdej\Menu;

        $pac0 = new Murdej\MenuNode;
        $pac0->name = "Pacienti";
        $pac0->link = 'Pacienti:default';
        $pac0->id = 'pac0';
        $sideMenu->rootNode->add($pac0);

        $hos0 = new Murdej\MenuNode;
        $hos0->name = "Hospitalizace";
        $hos0->link = 'Hospitalizace:default';
        $hos0->id = 'hos0';
        $sideMenu->rootNode->add($hos0);

        $lek0 = new Murdej\MenuNode;
        $lek0->name = "Databáze léků";
        $lek0->link = 'Leky:default';
        $lek0->id = 'lek0';
        $sideMenu->rootNode->add($lek0);

        $zam0 = new Murdej\MenuNode;
        $zam0->name = "Zaměstnanci";
        $zam0->link = 'Zamestnanec:default';
        $zam0->id = 'zam0';
        $sideMenu->rootNode->add($zam0);

        //$menuItem->add($menuItem2);
        return $sideMenu;
    }

    public function getMenu() {
        return $this->getComponent('menu');
    }
}

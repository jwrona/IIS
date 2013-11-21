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
	    $pac01 = new Murdej\MenuNode;
	    $pac01->name = "Vsichni";
            $pac01->link = 'Pacienti:all';
            $pac01->id = 'pac01';
            $pac0->add($pac01);

	    $pac02 = new Murdej\MenuNode;
	    $pac02->name = "Zadni";
            $pac02->link = 'Pacienti:nobody';
            $pac02->id = 'pac02';
            $pac0->add($pac02);

        $hos0 = new Murdej\MenuNode;
        $hos0->name = "Hospitalizace";
        $hos0->link = 'Hospitalizace:default';
        $hos0->id = 'hos0';
        $sideMenu->rootNode->add($hos0);

        $lek0 = new Murdej\MenuNode;
        $lek0->name = "Databáze léků";
        $lek0->link = 'Lek:default';
        $lek0->id = 'lek0';
        $sideMenu->rootNode->add($lek0);

        $zam0 = new Murdej\MenuNode;
        $zam0->name = "Zaměstnanci";
        $zam0->link = 'Zamestnanec:default';
        $zam0->id = 'zam0';
        $sideMenu->rootNode->add($zam0);

        return $sideMenu;
    }

    public function getMenu() {
        return $this->getComponent('menu');
    }

    public function actionDefault($id = null) {
        $this->menu->selectByUrl($this->link('this'));
    }

    public function actionAll($id = null) {
        $this->menu->selectByUrl($this->link('this'));
    }

    public function actionNobody($id = null) {
        $this->menu->selectByUrl($this->link('this'));
    }
}

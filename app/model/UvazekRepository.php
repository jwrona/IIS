<?php

namespace Todo;

use Nette;

class UvazekRepository extends Repository {

    public function findByName($username) {
        return $this->findAll()->where('username', $username)->fetch();
    }

    public function najdiUvazky($IDlekare) {
        return $this->findAll()->where('IDlekare', $IDlekare)->fetchPairs('IDlekare', 'zkratkaOdd');
        //return $this->findAll()->findBy(array('IDlekare' => $IDlekare))->fetchPairs('IDlekare', 'zkratkaOdd');
    }

    public function deleteZamestnanec($IDlekare) {
        $this->findAll()->where('IDlekare', $IDlekare)->delete();
    }

    public function findByIDzamestnance($IDlekare) {
        return $this->findAll()->where('IDlekare', $IDlekare);
    }

}
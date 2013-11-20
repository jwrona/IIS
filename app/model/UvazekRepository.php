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

    public function deleteUvazek($IDlekare, $zkratkaOdd) {
        $this->findAll()->where('IDlekare', $IDlekare)->where('zkratkaOdd', $zkratkaOdd)->delete();
    }

    public function findByIDzamestnance($IDlekare) {
        return $this->findAll()->where('IDlekare', $IDlekare);
    }
    
//    public function findByIDzamestnance($IDlekare) {
//        return $this->getTable()->where('oddeleni.zkratkaOdd = ', $value)->where('IDlekare', $IDlekare);
//    }

    public function findByIDzamestnanceZkratkaOdd($IDlekare, $zkratkaOdd) {
        return $this->findAll()->where('IDlekare', $IDlekare)->where('zkratkaOdd', $zkratkaOdd)->fetch();
    }

    public function updateUvazek($IDlekare, $zkratkaOdd, $roleUvazku, $telefon) { // TODO opravit - nejede
        $this->findAll()->where('IDlekare', $IDlekare)->where('zkratkaOdd', $zkratkaOdd)->update(
                array('zkratkaOdd' => $zkratkaOdd,
                    'roleUvazku' => $roleUvazku,
                    'telefon' => $telefon));
    }

    public function addUvazek($IDlekare, $zkratkaOdd, $roleUvazku, $telefon) {
        $this->getTable()->insert(
                array(
                    'IDlekare' => $IDlekare,
                    'zkratkaOdd' => $zkratkaOdd,
                    'roleUvazku' => $roleUvazku,
                    'telefon' => $telefon));
    }

}
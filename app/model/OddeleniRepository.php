<?php

namespace Todo;

use Nette;
use Nette\Database\Connection;

class OddeleniRepository extends Repository {

    public function findPairsZkratkaOddNazevIDzamestnance($IDlekare) {
        return $this->connection->query(
                        'SELECT uvazek.zkratkaOdd, oddeleni.nazev 
                                 FROM oddeleni, uvazek
                                 WHERE ' . $IDlekare . ' = uvazek.IDlekare AND uvazek.zkratkaOdd = oddeleni.zkratkaOdd'
                )->fetchPairs('zkratkaOdd', 'nazev');
    }

    public function findPairsZkratkaOddNazev() {
        return $this->getTable()->fetchPairs('zkratkaOdd', 'nazev');
    }

    public function findAllOddeleni() {
        return $this->findAll();
    }

    public function findOddeleni($zkratkaOdd) {
        return $this->findAll()->where('zkratkaOdd', $zkratkaOdd)->fetch();
    }

    public function addOddeleni($zkratkaOdd, $nazev) {
        $this->getTable()->insert(array(
            'zkratkaOdd' => $zkratkaOdd,
            'nazev' => $nazev));
    }

    public function updateOddeleni($zkratkaOdd, $nazev) {
        $this->findAll()->where('zkratkaOdd', $zkratkaOdd)->update(array('nazev' => $nazev));
    }

    public function deleteOddeleni($zkratkaOdd) {
        //$this->findAll()->where('zkratkaOdd', $zkratkaOdd)->update('erased', 1);
    }

}

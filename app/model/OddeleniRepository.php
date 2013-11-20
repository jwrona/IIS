<?php

namespace Todo;

use Nette;

class OddeleniRepository extends Repository {

    public function findPairsZkratkaOddNazev() {
        return $this->getTable()->fetchPairs('zkratkaOdd', 'nazev');
    }

    public function findAllOddeleni() {
        return $this->findAll();
    }

    public function addOddeleni($zkratkaOdd, $nazev) {
        $this->getTable()->insert(array(
            'zkratkaOdd' => $zkratkaOdd,
            'nazev' => $nazev));
    }

}

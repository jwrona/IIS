<?php

namespace Todo;

use Nette;

class OddeleniRepository extends Repository {

    public function findPairsZkratkaOddNazev() {
        return $this->getTable()->fetchPairs('zkratkaOdd', 'nazev');
    }
}

<?php

namespace Todo;

use Nette;

class LekRepository extends Repository {

    public function findAllLeky() {
        return $this->findAll();
    }

    public function findLekyByName($nazev) {
        return $this->findAll()->where('nazev', $nazev);
    }

    public function searchInTable($phrase) {
        $queryStr = "SELECT * 
                     FROM lek
                     WHERE (nazev LIKE '$phrase')
                     OR (ucinnaLatka LIKE '$phrase');";

        return $this->getConnection()->query($queryStr);
    }

}
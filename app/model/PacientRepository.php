<?php

namespace Todo;

use Nette;

class PacientRepository extends Repository {
    public function findByName($jmeno) {
        return $this->findAll()->where('jmeno', $jmeno)->fetch();
    }

    public function findByOddeleni($zkratkaOdd)
    {
	$queryStr = "SELECT *
                     FROM pacient AS p
                         JOIN hospitalizace AS h ON p.rodnecislo = h.rodnecislo
                     WHERE h.zkratkaOdd = '$zkratkaOdd'";

        return $this->getConnection()->query($queryStr);
    }
}

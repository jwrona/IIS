<?php

namespace Todo;

use Nette;

class PacientRepository extends Repository {
    public function findByName($jmeno) {
        return $this->findAll()->where('jmeno', $jmeno)->fetch();
    }
    
    public function findByRodneCislo($rodneCislo) {
        return $this->findAll()->where('rodneCislo', $rodneCislo)->fetch();
    }
    
    public function findDetailsByRodneCislo($rodneCislo) {
	$queryStr = "SELECT *
                     FROM pacient AS p
                         JOIN hospitalizace AS h ON p.rodnecislo = h.rodnecislo
                     WHERE h.zkratkaOdd = '$zkratkaOdd'";

        return $this->getConnection()->query($queryStr);
    }
    
    public function findHospitalizovanNyni($rodneCislo) {
	$queryStr = "SELECT *
                     FROM pacient AS p JOIN hospitalizace AS h ON p.rodneCislo = h.rodneCislo
                     WHERE p.rodneCislo = '$rodneCislo' AND h.datumPropusteni IS NULL AND p.erased = false";

        return $this->getConnection()->query($queryStr)->getRowCount();
    }
    
    public function findPocetHospitalizaci($rodneCislo) {
	$queryStr = "SELECT *
                     FROM pacient AS p JOIN hospitalizace AS h ON p.rodneCislo = h.rodneCislo
                     WHERE p.rodneCislo = '$rodneCislo'";

        return $this->getConnection()->query($queryStr)->getRowCount();
    }

    public function findByOddeleni($zkratkaOdd)
    {
	$queryStr = "SELECT *
                     FROM pacient AS p
                         JOIN hospitalizace AS h ON p.rodnecislo = h.rodnecislo
                     WHERE h.zkratkaOdd = '$zkratkaOdd' AND p.erased = false";

        return $this->getConnection()->query($queryStr);
    }

    public function searchInTable($phrase)
    {
	$queryStr = "SELECT * 
                     FROM pacient
                     WHERE (jmeno LIKE '$phrase')
                     OR (prijmeni LIKE '$phrase')
                     OR (rodneCislo LIKE '$phrase');";

        return $this->getConnection()->query($queryStr);
    }

    public function addPacient($jmeno, $prijmeni, $rc) {
        $this->getTable()->insert(array(
            'jmeno' => $jmeno,
            'prijmeni' => $prijmeni,
            'rodneCislo' => $rc,
        ));
    }

    public function findAllNehospitalizovani()
    {
	$queryStr = "SELECT p.jmeno, p.prijmeni, p.rodneCislo
                     FROM pacient AS p LEFT JOIN hospitalizace AS h ON p.rodneCislo = h.rodneCislo
                     WHERE h.IDhospitalizace IS NULL AND p.erased = false;";

        return $this->getConnection()->query($queryStr);
    }

    public function findInNehospitalizovani($phrase)
    {
	$queryStr = "SELECT p.jmeno, p.prijmeni, p.rodneCislo
                     FROM pacient AS p LEFT JOIN hospitalizace AS h ON p.rodneCislo = h.rodneCislo
                     WHERE h.IDhospitalizace IS NULL
                     AND p.erased = false
                     AND ((p.jmeno LIKE '$phrase')
                          OR (p.prijmeni LIKE '$phrase')
                          OR (p.rodneCislo LIKE '$phrase'));";

        return $this->getConnection()->query($queryStr);
    }

    public function editPacient($jmeno, $prijmeni, $rodneCislo) {
        $this->findBy(array('rodneCislo' => $rodneCislo))->update(
                array('jmeno' => $jmeno,
                    'prijmeni' => $prijmeni));
    }

    public function deletePacient($rodneCislo) {
        $this->findBy(array('rodneCislo' => $rodneCislo))->update(array('erased' => 1));
    }
}

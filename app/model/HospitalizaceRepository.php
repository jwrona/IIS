<?php

namespace Todo;

use Nette;

class HospitalizaceRepository extends Repository {

    public function findAllHospitalizace() {
        return $this->findAll();
    }

    public function findByZkratkaOdd($zkratkaOdd) {
        return $this->findAll()->where('zkratkaOdd', $zkratkaOdd)->where('IDlekare', 2);
    }

    public function findByIDlekare($IDlekare) {
      // return $this->findAll()->where('IDlekare', $IDlekare);
        return $this->connection->query(
                        'SELECT *
                         FROM hospitalizace, pacient
                         WHERE ' . $IDlekare . ' = hospitalizace.IDlekare AND hospitalizace.rodneCislo = pacient.rodneCislo'
        );
    }
    
    public function findByIDlekareZkratkaOdd($IDlekare, $zkratkaOdd) {
        return $this->connection->query(
                        'SELECT *
                         FROM hospitalizace, pacient
                         WHERE ' . $IDlekare . ' = hospitalizace.IDlekare '
                              .' AND hospitalizace.rodneCislo = pacient.rodneCislo'
                              .' AND "'.$zkratkaOdd.'" = hospitalizace.zkratkaOdd'
        );
    }
    
    public function findLeky($IDhospitalizace) {
        return $this->connection->query(
                        'SELECT *
                         FROM hospitalizace, podaniLeku, lek
                         WHERE ' . $IDhospitalizace . ' = hospitalizace.IDhospitalizace '
                              .' AND hospitalizace.rodneCislo = podaniLeku.rodneCislo'
                              .' AND lek.IDleku = podaniLeku.IDleku'
        );
    }

//    public function findByIDlekareZkratkaOdd($zkratkaOdd) {
//        return $this->findAll()->where('zkratkaOdd', $zkratkaOdd);
//    }

    public function updateHospitalizace() {
        $this->findBy(array('IDzamestnance' => $IDzamestnance))->update(
                array('jmeno' => $jmeno,
                    'prijmeni' => $prijmeni,
                    'username' => $username,
                    'zkratkaOdd' => $zkratkaOdd));
    }

    public function addHospitalizace() {
        $this->getTable()->insert(array(
            'jmeno' => $jmeno,
            'prijmeni' => $prijmeni,
            'username' => $username,
            'password' => $password,
            'role' => $role));
    }

}
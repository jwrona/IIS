<?php

namespace Todo;

use Nette;

class HospitalizaceRepository extends Repository {

    public function findAllHospitalizace() {
        return $this->findAll();
    }

    public function findByZkratkaOdd($zkratkaOdd) {
        return $this->connection->query(
                        'SELECT *
                         FROM hospitalizace, pacient
                         WHERE hospitalizace.rodneCislo = pacient.rodneCislo'
                        . ' AND "' . $zkratkaOdd . '" = hospitalizace.zkratkaOdd'
        );
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
                        . ' AND hospitalizace.rodneCislo = pacient.rodneCislo'
                        . ' AND "' . $zkratkaOdd . '" = hospitalizace.zkratkaOdd'
        );
    }

    public function findLeky($IDhospitalizace) {
        return $this->connection->query(
                        'SELECT *
                         FROM hospitalizace, lek, podaniLeku
                         WHERE ' . $IDhospitalizace . ' = hospitalizace.IDhospitalizace '
                        . ' AND hospitalizace.rodneCislo = podaniLeku.rodneCislo'
                        . ' AND lek.IDleku = podaniLeku.IDleku'
        );
    }

    public function findVysetreni($IDhospitalizace) {
        return $this->connection->query(
                        'SELECT *
                         FROM vysetreni, hospitalizace
                         WHERE ' . $IDhospitalizace . ' = hospitalizace.IDhospitalizace '
                        . ' AND hospitalizace.rodneCislo = vysetreni.rodneCislo'
        );
    }

    public function findPacient($IDhospitalizace) {
        return $this->connection->query(
                        'SELECT *
                         FROM pacient, hospitalizace
                         WHERE ' . $IDhospitalizace . ' = hospitalizace.IDhospitalizace '
                        . ' AND hospitalizace.rodneCislo = pacient.rodneCislo'
                )->fetch();
    }

    public function findLekar($IDhospitalizace) {
        return $this->connection->query(
                        'SELECT *
                         FROM hospitalizace, zamestnanec
                         WHERE ' . $IDhospitalizace . ' = hospitalizace.IDhospitalizace '
                        . ' AND hospitalizace.IDLekare = zamestnanec.IDzamestnance'
                )->fetch();
    }

//    public function updateHospitalizace() {
//        $this->findBy(array('IDzamestnance' => $IDzamestnance))->update(
//                array('jmeno' => $jmeno,
//                    'prijmeni' => $prijmeni,
//                    'username' => $username,
//                    'zkratkaOdd' => $zkratkaOdd));
//    }

    public function addHospitalizace($rodneCislo, $zkratkaOdd, $datumPrijeti, $IDlekare) {
        $this->getTable()->insert(array(
            'rodneCislo' => $rodneCislo,
            'zkratkaOdd' => $zkratkaOdd,
            'datumPrijeti' => $datumPrijeti,
            'IDLekare' => $IDlekare));
    }

}
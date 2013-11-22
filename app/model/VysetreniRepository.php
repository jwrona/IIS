<?php

namespace Todo;

use Nette;

class VysetreniRepository extends Repository {

//    public function findLeky($IDhospitalizace) {
//        return $this->connection->query(
//                        'SELECT *
//                         FROM hospitalizace, podaniLeku, lek
//                         WHERE ' . $IDhospitalizace . ' = hospitalizace.IDhospitalizace '
//                        . ' AND hospitalizace.rodneCislo = podaniLeku.rodneCislo'
//                        . ' AND lek.IDleku = podaniLeku.IDleku'
//        );
//    }

    public function AddVysetreni($IDlekare, $rodneCislo, $oddeleni, $CasProvedeni, $vysledek) {
        $this->getTable()->insert(array(
            'IDlekare' => $IDlekare,
            'rodneCislo' => $rodneCislo,
            'zkratkaOdd' => $oddeleni,
            'CasProvedeni' => $CasProvedeni,
            'vysledek' => $vysledek));
    }

}
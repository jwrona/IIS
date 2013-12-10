<?php

namespace Todo;

use Nette;
use Nette\Database\Connection;

class OddeleniRepository extends Repository {

    public function findPairsZkratkaOddNazevIDzamestnance($IDlekare) {
        return $this->connection->query(
                        'SELECT uvazek.zkratkaOdd, oddeleni.nazev 
                                 FROM oddeleni, uvazek
                                 WHERE ' . $IDlekare . ' = uvazek.IDlekare AND uvazek.zkratkaOdd = oddeleni.zkratkaOdd AND oddeleni.erased = 0'
                )->fetchPairs('zkratkaOdd', 'nazev');
    }

    public function findPairsZkratkaOddNazevIDsestry($IDsestry) {
        return $this->connection->query(
                        'SELECT zamestnanec.zkratkaOdd, oddeleni.nazev 
                                 FROM oddeleni, zamestnanec
                                 WHERE ' . $IDsestry . ' = zamestnanec.IDzamestnance '
                        . 'AND oddeleni.zkratkaOdd = zamestnanec.zkratkaOdd '
                        . 'AND oddeleni.erased = 0'
                )->fetchPairs('zkratkaOdd', 'nazev');
    }

    public function findPairsZkratkaOddNazev() {
        return $this->getTable()->where('erased', 0)->fetchPairs('zkratkaOdd', 'nazev');
    }

    public function findAllOddeleni() {
        return $this->findAll()->where('erased', 0);
    }

    public function findOddeleni($zkratkaOdd) {
        return $this->findAll()->where('zkratkaOdd', $zkratkaOdd)->where('erased', 0)->fetch();
    }

    public function addOddeleni($zkratkaOdd, $nazev) {
        if (0 < $this->connection->query(
                        'SELECT oddeleni.zkratkaOdd 
                         FROM oddeleni
                         WHERE "' . $zkratkaOdd . '" = oddeleni.zkratkaOdd AND oddeleni.erased = 1')->rowCount()) 
        {
            $this->findAll()->where('zkratkaOdd', $zkratkaOdd)->update(array('erased' => 0, 'nazev' => $nazev));
        } else {
            $this->getTable()->insert(array(
                'zkratkaOdd' => $zkratkaOdd,
                'nazev' => $nazev));
        }
    }

    public function updateOddeleni($zkratkaOdd, $nazev) {
        $this->findAll()->where('zkratkaOdd', $zkratkaOdd)->update(array('nazev' => $nazev));
    }

    public function deleteOddeleni($zkratkaOdd) {
        $this->findAll()->where('zkratkaOdd', $zkratkaOdd)->update(array('erased' => 1));
    }

}

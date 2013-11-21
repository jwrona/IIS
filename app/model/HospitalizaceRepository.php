<?php

namespace Todo;

use Nette;

class HospitalizaceRepository extends Repository {

    public function findAllHospitalizace() {
        return $this->findAll();
    }

    public function findByZkratkaOdd($zkratkaOdd) {
        return $this->findAll()->where('zkratkaOdd', $zkratkaOdd)->where('IDlekare',2);
    }
    
    public function findByIDlekare($IDlekare) {
        return $this->findAll()->where('IDlekare', $IDlekare);
    }
    
    public function findByIDlekareZkratkaOdd($zkratkaOdd) {
        return $this->findAll()->where('zkratkaOdd',$zkratkaOdd);
    }

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
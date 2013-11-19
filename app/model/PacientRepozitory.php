<?php

namespace Todo;

use Nette;

class PacientRepository extends Repository {

    public function findByName($username) {
        return $this->findAll()->where('username', $username)->fetch();
    }
    
    public function najdiJmeno($jmeno) {
        return $this->findAll()->where('jmeno', $jmeno)->fetch();
    }
    
    public function najdiVsechny() {
        return $this->findAll();
    }
}
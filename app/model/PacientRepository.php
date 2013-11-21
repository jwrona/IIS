<?php

namespace Todo;

use Nette;

class PacientRepository extends Repository {

    public function findByName($jmeno) {
        return $this->findAll()->where('jmeno', $jmeno)->fetch();
    }
}

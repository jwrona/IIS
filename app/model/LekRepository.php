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

}
<?php

namespace Todo;

use Nette;

class ZamestnanecRepository extends Repository {

    public function findByName($username) {
        return $this->findAll()->where('username', $username)->fetch();
    }

    public function setPassword($id, $password) {
        $this->getTable()->where(array('IDzamestnance' => $id))->update(array(
            'password' => Authenticator::calculateHash($password)));
    }

}
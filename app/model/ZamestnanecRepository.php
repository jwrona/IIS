<?php

namespace Todo;

use Nette;

class ZamestnanecRepository extends Repository {

    public function findByName($username) {
        return $this->findAll()->where('username', $username)->fetch();
    }
    
    public function findByIDzamestnance($IDzamestnance) {
        return $this->findAll()->where('IDzamestnance', $IDzamestnance)->fetch();
    }
    
    public function findDoctors(){
        return $this->findAll()->where('role', 'lekar');
    }
    
    public function findNurses(){
        return $this->findAll()->where('role', 'sestra');
    }
    
    public function findAdministrators(){
        return $this->findAll()->where('role', 'administrator');
    }

    public function setPassword($id, $password) {
        $this->getTable()->where(array('IDzamestnance' => $id))->update(array(
            'password' => Authenticator::calculateHash($password)));
    }

}
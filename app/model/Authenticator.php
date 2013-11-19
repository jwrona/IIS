<?php

namespace Todo;

use Nette,
    Nette\Security,
    Nette\Utils\Strings;

/**
 * Users authenticator.
 */
class Authenticator extends Nette\Object implements Security\IAuthenticator {

    /** @var UserRepository */
    private $zamestnanec;

    public function __construct(ZamestnanecRepository $zamestnanec) {
        $this->zamestnanec = $zamestnanec;
    }

    /**
     * Performs an authentication.
     * @return Nette\Security\Identity
     * @throws Nette\Security\AuthenticationException
     */
    public function authenticate(array $credentials) {
        list($username, $password) = $credentials;

        $row = $this->zamestnanec->findByName($username);

        if (!$row) {
            throw new Security\AuthenticationException('The username is incorrect.', self::IDENTITY_NOT_FOUND);
        }

        if ($row->password !== $this->calculateHash($password, $row->password)) {
            throw new Security\AuthenticationException('The password is incorrect.', self::INVALID_CREDENTIAL);
        }

        unset($row->password);
        return new Security\Identity($row->IDzamestnance, $row->role, $row->toArray());
    }

    /**
     * @param  int $id
     * @param  string $password
     */
    public function setPassword($id, $password) {
        $this->zamestnanec->findBy(array('IDzamestnance' => $id))->update(array(
            'password' => $this->calculateHash($password),
        ));
    }

    /**
     * Computes salted password hash.
     * @param string
     * @return string
     */
    public static function calculateHash($password, $salt = NULL) {
        if ($password === Strings::upper($password)) { // perhaps caps lock is on
            $password = Strings::lower($password);
        }
        return crypt($password, $salt ? : '$2a$07$' . Strings::random(22));
    }

}

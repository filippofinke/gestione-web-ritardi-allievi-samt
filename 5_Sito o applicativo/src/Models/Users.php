<?php

namespace FilippoFinke\Models;

use Exception;
use FilippoFinke\Libs\Validator;
use FilippoFinke\Utils\Database;

/**
 * Users.php
 * Classe utilizzata per intefacciarsi con la tabella "USER".
 *
 * @author Filippo Finke
 */
class Users
{
    /**
     * Metodo utilizzato per ricavare tutti gli utenti.
     *
     * @return array Array di utenti.
     */
    public static function getAll()
    {
        $pdo = Database::getConnection();
        $query = "SELECT * FROM user";
        try {
            $stm = $pdo->query($query);
            return $stm->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * Metodo utilizzato per ricavare un utente dalla sua
     * email.
     *
     * @param $email L'indirizzo email da cercare.
     * @return array L'utente oppure false.
     */
    public static function getByEmail($email)
    {
        $pdo = Database::getConnection();
        $query = "SELECT * FROM user WHERE email = :email";
        $stm = $pdo->prepare($query);
        $stm->bindParam(':email', $email);
        try {
            $stm->execute();
            return $stm->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return false;
        }
    }

}

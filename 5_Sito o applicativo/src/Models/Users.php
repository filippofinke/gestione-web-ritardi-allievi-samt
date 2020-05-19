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

    /**
     * Metodo utilizzato per inserire un utente.
     *
     * @param $name Il nome.
     * @param $lastName Il cognome.
     * @param $email L'indirizzo email.
     * @return bool True oppure false.
     */
    public static function insert($email, $name, $lastname)
    {
        $pdo = Database::getConnection();
        $query = "INSERT INTO user VALUES(:email, :name, :lastname, '', 7)";
        $stm = $pdo->prepare($query);
        $stm->bindValue(':email', strtolower($email));
        $stm->bindValue(':name', ucfirst($name));
        $stm->bindValue(':lastname', ucfirst($lastname));
        try {
            return $stm->execute() && Tokens::sendActivationToken($email);
        } catch (\PDOException $e) {
            throw new Exception("Un utente con questa email esiste già!");
        }
    }

    /**
     * Metodo utilizzato per aggiornare il permesso di un utente usando la sua
     * email.
     *
     * @param $email L'indirizzo email dell'utente.
     * @param $permission Il nuovo permesso.
     * @return bool True oppure false.
     */
    public static function update($email, $permission)
    {
        $pdo = Database::getConnection();
        $query = "UPDATE user SET permission = :permission WHERE email = :email";
        $stm = $pdo->prepare($query);
        $stm->bindParam(':email', $email);
        $stm->bindParam(':permission', $permission);
        try {
            return $stm->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * Metodo utilizzato per eliminare un utente usando la sua
     * email.
     *
     * @param $email L'indirizzo email da cercare.
     * @return bool True oppure false.
     */
    public static function delete($email)
    {
        $pdo = Database::getConnection();
        $query = "DELETE FROM user WHERE email = :email";
        $stm = $pdo->prepare($query);
        $stm->bindParam(':email', $email);
        try {
            return $stm->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * Metodo utilizzato per cambiare la password di un utente con un token.
     *
     * @param $token Il token di recupero password.
     * @param $password La nuova password.
     * @return bool True oppure false.
     */
    public static function changePassword($token, $password)
    {
        if (Validator::isValidPassword($password)) {
            $email = Tokens::useToken($token);
            if ($email) {
                $pdo = Database::getConnection();
                $query = "UPDATE user SET password = :password WHERE email = :email";
                $stm = $pdo->prepare($query);
                $stm->bindParam(':email', $email);
                $stm->bindValue(':password', password_hash($password, PASSWORD_DEFAULT));
                try {
                    $_SESSION["login_email"] = $email;
                    return $stm->execute();
                } catch (\PDOException $e) {
                }
            }
        }
        return false;
    }
}

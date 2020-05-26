<?php

namespace FilippoFinke\Models;

use FilippoFinke\Libs\Mail;
use FilippoFinke\Utils\Database;

/**
 * Tokens.php
 * Classe utilizzata per intefacciarsi con la tabella "TOKEN".
 *
 * @author Filippo Finke
 */
class Tokens
{
    /**
     * Costante che rappresenta il tempo massimo di validità di un token.
     */
    private const EXPIRE_AFTER = 10;

    /**
     * Metodo utilizzato per generare ed inviare un token di attivazione per email.
     *
     * @param $email L'email dell'utente.
     * @param boolean True o false.
     */
    public static function sendActivationToken($email)
    {
        $token = bin2hex(random_bytes(20));
        $hash = hash("sha256", $token);
        try {
            $pdo = Database::getConnection();
            $query = "INSERT INTO token VALUES(:email, :token, :created_at)";
            $stm = $pdo->prepare($query);
            $stm->bindValue('email', $email);
            $stm->bindValue('token', $hash);
            $time = time() + 86400 * 7;
            $stm->bindValue('created_at', date("Y-m-d", $time));
            $link = "http://" . $_SERVER['SERVER_NAME'] . BASE . "login/$token";
            $content = "Salve,<br>può accedere al suo account attraverso questo link: <a href='$link'>$link</a><br><br>Esso ha una validità di 7 giorni.<br><br>Gestione Ritardi Web SAMT";
            return $stm->execute() && Mail::send($email, "Nuovo account | Gestione Ritardi", $content);
        } catch (\PDOException $e) {
        }
    }

    /**
     * Metodo utilizzato per generare ed inviare un token di recupero password per email.
     *
     * @param $email L'email dell'utente.
     * @param boolean True o false.
     */
    public static function sendResetPasswordToken($email)
    {
        if (Users::getByEmail($email)) {
            self::deleteToken($email);
            $token = bin2hex(random_bytes(20));
            $hash = hash("sha256", $token);
            try {
                $pdo = Database::getConnection();
                $query = "INSERT INTO token(email, token) VALUE(:email, :token)";
                $stm = $pdo->prepare($query);
                $stm->bindValue('email', $email);
                $stm->bindValue('token', $hash);
                $link = "http://" . $_SERVER['SERVER_NAME'] . BASE . "login/$token";
                $content = "Salve,<br>può cambiare la sua password premendo il seguente link: <a href='$link'>$link</a><br><br>Esso ha una validità di " . (self::EXPIRE_AFTER) . " minuti.<br><br>Gestione Ritardi Web SAMT";
                return $stm->execute() && Mail::send($email, "Recupero password | Gestione Ritardi", $content);
            } catch (\PDOException $e) {
            }
        }
        return true;
    }

    /**
     * Metodo utilizzato per usare un token e controllarne la validità.
     *
     * @param $email L'email dell'utente.
     * @param boolean True o false.
     */
    public static function useToken($token)
    {
        $token = hash("sha256", $token);
        $pdo = Database::getConnection();
        $query = "SELECT email FROM token WHERE token = :token AND CURRENT_TIMESTAMP() - created_at <= " . (self::EXPIRE_AFTER * 60);
        try {
            $stm = $pdo->prepare($query);
            $stm->bindValue('token', $token);
            $stm->execute();
            $email = $stm->fetchColumn();
            if ($email) {
                $stm = $pdo->prepare("DELETE FROM token WHERE token = :token");
                $stm->bindValue('token', $token);
                $stm->execute();
                return $email;
            }
        } catch (\PDOException $e) {
        }
        return false;
    }

    /**
     * Metodo utilizzato per eliminare i token di recupero di un utente.
     *
     * @param $email L'email dell'utente.
     * @return boolean True o false.
     */
    private static function deleteToken($email)
    {
        try {
            $pdo = Database::getConnection();
            $query = "DELETE FROM token WHERE email = :email";
            $stm = $pdo->prepare($query);
            $stm->bindValue('email', $email);
            return $stm->execute();
        } catch (\PDOException $e) {
        }
        return false;
    }
}

<?php

namespace FilippoFinke\Models;

use FilippoFinke\Utils\Database;

/**
 * Students.php
 * Classe utilizzata per intefacciarsi con la tabella "STUDENT".
 *
 * @author Filippo Finke
 */
class Students
{
    /**
     * Metodo utilizzato per ricavare tutti gli studenti.
     *
     * @return array Array di studenti.
     */
    public static function getAll()
    {
        $pdo = Database::getConnection();
        $query = "SELECT * FROM student";
        try {
            $stm = $pdo->query($query);
            return $stm->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * Metodo utilizzato per ricavare uno studente dalla sua email.
     *
     * @return array Lo studente.
     */
    public static function getByEmail($email)
    {
        $pdo = Database::getConnection();
        $query = "SELECT * FROM student WHERE email = :email";
        try {
            $stm = $pdo->prepare($query);
            $stm->bindParam(':email', $email);
            $stm->execute();
            return $stm->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * Metodo utilizzato per inserire uno studente.
     *
     * @param $name Il nome.
     * @param $lastName Il cognome.
     * @param $email L'indirizzo email.
     * @param $section La sezione.
     * @return bool True oppure false.
     */
    public static function insert($email, $name, $lastname, $section)
    {
        $pdo = Database::getConnection();
        $query = "INSERT INTO student VALUES(:email, :name, :lastname, :section)";
        $stm = $pdo->prepare($query);
        $stm->bindParam(':email', strtolower($email));
        $stm->bindParam(':name', ucfirst($name));
        $stm->bindParam(':lastname', ucfirst($lastname));
        $stm->bindParam(':section', $section);
        try {
            return $stm->execute();
        } catch (\PDOException $e) {
            throw new \Exception("Uno studente con questa email esiste già!");
        }
    }
}

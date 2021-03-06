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
        $query = "SELECT * FROM student ORDER BY name ASC";
        try {
            $stm = $pdo->query($query);
            return $stm->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * Metodo utilizzato per ricavare tutti gli studenti per anno.
     * 
     * @param $id L'id dell'anno.
     * @return array Array di studenti.
     */
    public static function getByYear($year)
    {
        $pdo = Database::getConnection();
        $query = "SELECT * FROM student WHERE year = :year ORDER BY name ASC";
        try {
            $stm = $pdo->prepare($query);
            $stm->bindValue(':year', $year);
            $stm->execute();
            return $stm->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * Metodo utilizzato per ricavare uno studente dalla sua email e anno.
     * 
     * @param $id L'id dell'anno.
     * @return array Array di studenti.
     */
    private static function getByYearAndEmail($year, $email)
    {
        $pdo = Database::getConnection();
        $query = "SELECT * FROM student WHERE year = :year AND email = :email";
        try {
            $stm = $pdo->prepare($query);
            $stm->bindValue(':year', $year);
            $stm->bindValue(':email', $email);
            $stm->execute();
            return $stm->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * Metodo utilizzato per ricavare uno studente dal suo id.
     *
     * @param $id L'id dell'utente.
     * @return array Lo studente.
     */
    public static function getById($id)
    {
        $pdo = Database::getConnection();
        $query = "SELECT * FROM student WHERE id = :id";
        try {
            $stm = $pdo->prepare($query);
            $stm->bindValue(':id', $id);
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
        // Ricavo l'anno scolastico corrente da assegnare all'utente.
        $year = Years::getCurrentYear();
        // Controllo la presenza dell'anno scolastico nel database.
        if (!$year) {
            throw new \Exception("Prima di inserire uno studente deve essere presente un anno scolastico!");
        }
        $year = $year["id"];
        if (self::getByYearAndEmail($year, $email)) {
            throw new \Exception("Esiste già uno studente con questa email in questo anno!");
        }
        $pdo = Database::getConnection();
        $query = "INSERT INTO student VALUES(null, :email, :name, :lastname, :section, :year)";
        $stm = $pdo->prepare($query);
        $stm->bindValue(':email', strtolower($email));
        $stm->bindValue(':name', ucfirst($name));
        $stm->bindValue(':lastname', ucfirst($lastname));
        $stm->bindValue(':section', $section);
        $stm->bindValue(':year', $year);
        try {
            return $stm->execute();
        } catch (\PDOException $e) {
            throw new \Exception("Uno studente con questa email esiste già!");
        }
    }
}

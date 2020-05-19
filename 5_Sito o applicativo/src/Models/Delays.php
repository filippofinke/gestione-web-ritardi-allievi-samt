<?php

namespace FilippoFinke\Models;

use FilippoFinke\Utils\Database;
use FilippoFinke\Libs\Mail;
use FilippoFinke\Models\Years;

/**
 * Delays.php
 * Classe utilizzata per intefacciarsi con la tabella "DELAY".
 *
 * @author Filippo Finke
 */
class Delays
{
    /**
     * Metodo utilizzato per ricavare i ritardi di uno studente.
     * 
     * @param $email L'email dello studente.
     * @return array Array di ritardi.
     */
    public static function getByEmail($email)
    {
        $pdo = Database::getConnection();
        $query = "SELECT id, DATE_FORMAT(date, '%d.%m.%Y') as 'date', observations, DATE_FORMAT(recovered, '%d.%m.%Y') as 'recovered', justified FROM delay WHERE email = :email";
        try {
            $stm = $pdo->prepare($query);
            $stm->bindParam(':email', $email);
            $stm->execute();
            return $stm->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * Metodo utilizzato per ricavare i ritardi che devono essere recuperati.
     */
    public static function getToRecoverByEmail($email)
    {
        $year = Years::getCurrentYear();
        if (!$year) return false;
        $pdo = Database::getConnection();
        $query = "SELECT id, DATE_FORMAT(date, '%d.%m.%Y') as 'date', observations, DATE_FORMAT(recovered, '%d.%m.%Y') as 'recovered', justified FROM delay WHERE email = :email AND recovered IS NULL AND justified = 0 AND date BETWEEN :start AND :end";
        try {
            $stm = $pdo->prepare($query);
            $stm->bindParam(':email', $email);
            $stm->bindParam(':start', $year["start_first_semester"]);
            $stm->bindParam(':end', $year["end_second_semester"]);
            $stm->execute();
            $delays = $stm->fetchAll(\PDO::FETCH_ASSOC);
            $max = Settings::getValue('max_delays');
            if (count($delays) >= $max) {
                return array_slice($delays, ($max - 1));
            } else {
                return [];
            }
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * Metodo utilizzato per ricavare i ritardi fatti nel semestre corrente.
     * 
     * @param $email L'email dell'utente da controllare.
     * @return array Array di ritardi.
     */
    public static function getInCurrentSemesterByEmail($email)
    {
        $semester = Years::getCurrentSemester();
        $start = $semester[0];
        $end = $semester[1];

        $pdo = Database::getConnection();
        $query = "SELECT id, DATE_FORMAT(date, '%d.%m.%Y') as 'date', observations, DATE_FORMAT(recovered, '%d.%m.%Y') as 'recovered', justified FROM delay WHERE email = :email AND date BETWEEN :start AND :end";
        try {
            $stm = $pdo->prepare($query);
            $stm->bindParam(':email', $email);
            $stm->bindParam(':start', $start);
            $stm->bindParam(':end', $end);
            $stm->execute();
            return $stm->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * Metodo utilizzato per inserire un ritardo.
     *
     * @param $email L'email dello studente.
     * @param $date La data del ritardo.
     * @param $observations Le osservazioni.
     * @param $justified Se il ritardo è giustificato oppure no.
     * @return bool True oppure false.
     */
    public static function insert($email, $date, $observations, $justified)
    {
        $pdo = Database::getConnection();
        $query = "INSERT INTO delay VALUES(null, :email, :date, :observations, null, :justified)";
        $stm = $pdo->prepare($query);
        $stm->bindParam(':email', $email);
        $stm->bindParam(':date', $date);
        $stm->bindParam(':observations', $observations);
        $stm->bindParam(':justified', $justified);
        try {
            $stm->execute();
            $id =  $pdo->lastInsertId();
            if (count(self::getToRecoverByEmail($email)) > 0) {
                $date = date("d.m.Y", strtotime($date));
                Mail::send($email, 'Recupero ritardo | Gestione Ritardi', 'Salve,<br>lei ha raggiunto il numero massimo di ritardi consentiti con il ritardo in data: ' . $date . ', verrà contattato per un recupero.');
            }
            return $id;
        } catch (\PDOException $e) {
            throw new \Exception("Impossibile inserire il ritardo!" . $e->getMessage());
        }
    }

    /**
     * Metodo utilizzato per aggiornare un ritardo.
     *
     * @param $id L'id del ritardo.
     * @param $date La data del recupero.
     * @return bool True oppure false.
     */
    public static function update($id, $date)
    {
        $pdo = Database::getConnection();
        $query = "UPDATE delay SET recovered = :date WHERE id = :id";
        $stm = $pdo->prepare($query);
        $stm->bindParam(':id', $id);
        $stm->bindParam(':date', $date);
        try {
            return $stm->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * Metodo utilizzato per eliminare un ritardo.
     *
     * @param $id L'id del ritardo.
     * @return bool True oppure false.
     */
    public static function delete($id)
    {
        $pdo = Database::getConnection();
        $query = "DELETE FROM delay WHERE id = :id";
        $stm = $pdo->prepare($query);
        $stm->bindParam(':id', $id);
        try {
            return $stm->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }
}

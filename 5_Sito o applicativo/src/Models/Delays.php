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
     * @param $id L'id dello studente.
     * @return array Array di ritardi.
     */
    public static function getById($id)
    {
        $pdo = Database::getConnection();
        $query = "SELECT id, DATE_FORMAT(date, '%d.%m.%Y') as 'date', observations, DATE_FORMAT(recovered, '%d.%m.%Y') as 'recovered', justified FROM delay WHERE student = :student ORDER BY delay.date DESC";
        try {
            $stm = $pdo->prepare($query);
            $stm->bindValue(':student', $id);
            $stm->execute();
            return $stm->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * Metodo utilizzato per ricavare i ritardi che devono essere recuperati.
     * 
     * @param $id L'id dello studente.
     * @return array Array di ritardi.
     */
    public static function getToRecoverById($id)
    {
        $year = Years::getCurrentYear();
        if (!$year) return null;
        $pdo = Database::getConnection();
        $query = "SELECT id, DATE_FORMAT(date, '%d.%m.%Y') as 'date', observations, DATE_FORMAT(recovered, '%d.%m.%Y') as 'recovered', justified FROM delay WHERE student = :student AND recovered IS NULL AND justified = 0 AND date BETWEEN :start AND :end ORDER BY delay.date DESC";
        try {
            $stm = $pdo->prepare($query);
            $stm->bindValue(':student', $id);
            $stm->bindValue(':start', $year["start_first_semester"]);
            $stm->bindValue(':end', $year["end_second_semester"]);
            $stm->execute();
            $delays = $stm->fetchAll(\PDO::FETCH_ASSOC);
            $max = Settings::getValue('max_delays');
            if (count($delays) >= $max) {
                return array_slice($delays, 0, (count($delays) - $max + 1));
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
     * @param $id L'id dello studente.
     * @return array Array di ritardi.
     */
    public static function getInCurrentSemesterById($id)
    {
        $semester = Years::getCurrentSemester();
        if (!$semester) return null;
        $start = $semester[0];
        $end = $semester[1];

        $pdo = Database::getConnection();
        $query = "SELECT id, DATE_FORMAT(date, '%d.%m.%Y') as 'date', observations, DATE_FORMAT(recovered, '%d.%m.%Y') as 'recovered', justified FROM delay WHERE student = :student AND date BETWEEN :start AND :end ORDER BY delay.date DESC";
        try {
            $stm = $pdo->prepare($query);
            $stm->bindValue(':student', $id);
            $stm->bindValue(':start', $start);
            $stm->bindValue(':end', $end);
            $stm->execute();
            return $stm->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * Metodo utilizzato per inserire un ritardo.
     *
     * @param $student_id L'id dello studente.
     * @param $date La data del ritardo.
     * @param $observations Le osservazioni.
     * @param $justified Se il ritardo è giustificato oppure no.
     * @return bool True oppure false.
     */
    public static function insert($student_id, $date, $observations, $justified)
    {
        $pdo = Database::getConnection();
        $query = "INSERT INTO delay VALUES(null, :student, :date, :observations, null, :justified)";
        $stm = $pdo->prepare($query);
        $stm->bindValue(':student', $student_id);
        $stm->bindValue(':date', $date);
        $stm->bindValue(':observations', $observations);
        $stm->bindValue(':justified', $justified);
        try {
            $stm->execute();
            $id =  $pdo->lastInsertId();
            if (count(self::getToRecoverById($student_id)) > 0 && !$justified) {
                $date = date("d.m.Y", strtotime($date));
                $email = Students::getById($student_id)["email"];
                Mail::send($email, 'Recupero ritardo | Gestione Ritardi', 'Salve,<br>lei ha raggiunto il numero massimo di ritardi consentiti con il ritardo in data: ' . $date . ', verrà contattato per un recupero.');
            }
            return $id;
        } catch (\PDOException $e) {
            throw new \Exception("Impossibile inserire il ritardo!");
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
        $stm->bindValue(':id', $id);
        $stm->bindValue(':date', $date);
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
        $stm->bindValue(':id', $id);
        try {
            return $stm->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }
}

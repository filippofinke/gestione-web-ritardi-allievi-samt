<?php

namespace FilippoFinke\Models;

use FilippoFinke\Utils\Database;

/**
 * Years.php
 * Classe utilizzata per intefacciarsi con la tabella "YEAR".
 *
 * @author Filippo Finke
 */
class Years
{
    /**
     * Metodo utilizzato per ricavare tutti gli anni.
     *
     * @return array Array di anni.
     */
    public static function getAll()
    {
        $pdo = Database::getConnection();
        $query = "SELECT * FROM year";
        try {
            $stm = $pdo->query($query);
            return $stm->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * Metodo utilizzato per ricavare l'anno corrente.
     * 
     * @return array Anno corrente.
     */
    public static function getCurrentYear()
    {
        $pdo = Database::getConnection();
        $query = "SELECT * FROM year WHERE CURRENT_DATE() >= start_first_semester AND CURRENT_DATE() <= end_second_semester;";
        try {
            $stm = $pdo->query($query);
            return $stm->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * Metodo utilizzato per inserire un anno scolastico.
     *
     * @param $start_first_date Data di inizio primo semestre.
     * @param $end_first_date Data di fine primo semestre.
     * @param $start_second_date Data di inizio secondo semestre.
     * @param $end_second_date  Data di fine secondo semestre.
     * @return bool True oppure false.
     */
    public static function insert($start_first_date, $end_first_date, $start_second_date, $end_second_date)
    {
        $years = self::getAll();
        $start_date = \strtotime($start_first_date);
        $end_date = \strtotime($end_second_date);

        foreach ($years as $year) {
            $start_year = \strtotime($year['start_first_semester']);
            $end_year = \strtotime($year['end_second_semester']);
            if (
                ($start_date <= $end_year && $start_date >= $start_year) ||
                ($start_date <= $start_year && $end_date >= $end_year)
            ) {
                throw new \Exception("È già presente un anno scolastico nello stesso intervallo di tempo!");
            }
        }

        $pdo = Database::getConnection();
        $query = "INSERT INTO year VALUES(null, :sfs, :efs, :sss, :ess)";
        $stm = $pdo->prepare($query);
        $stm->bindParam(':sfs', $start_first_date);
        $stm->bindParam(':efs', $end_first_date);
        $stm->bindParam(':sss', $start_second_date);
        $stm->bindParam(':ess', $end_second_date);
        try {
            if ($stm->execute()) {
                return $pdo->lastInsertId();
            }
        } catch (\PDOException $e) {
        }
        return false;
    }

    /**
     * Metodo utilizzato per eliminare un anno scolastico.
     *
     * @param $id L'id dell'anno scolastico da eliminare.
     * @return bool True oppure false.
     */
    public static function delete($id)
    {
        $pdo = Database::getConnection();
        $query = "DELETE FROM year WHERE id = :id";
        $stm = $pdo->prepare($query);
        $stm->bindParam(':id', $id);
        try {
            return $stm->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }
}
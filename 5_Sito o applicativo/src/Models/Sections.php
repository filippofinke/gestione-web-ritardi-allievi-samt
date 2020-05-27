<?php

namespace FilippoFinke\Models;

use FilippoFinke\Utils\Database;

/**
 * Sections.php
 * Classe utilizzata per intefacciarsi con la tabella "SECTION".
 *
 * @author Filippo Finke
 */
class Sections
{
    /**
     * Metodo utilizzato per ricavare tutte le sezioni.
     *
     * @return array Array di sezioni.
     */
    public static function getAll()
    {
        $pdo = Database::getConnection();
        $query = "SELECT * FROM section WHERE deleted = 0";
        try {
            $stm = $pdo->query($query);
            return $stm->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * Metodo utilizzato per inserire una sezione.
     *
     * @param $name Il nome.
     * @return bool True oppure false.
     */
    public static function insert($name)
    {
        $pdo = Database::getConnection();
        $query = "INSERT INTO section VALUES(:name, 0)";
        $stm = $pdo->prepare($query);
        $stm->bindValue(':name', $name);
        try {
            return $stm->execute();
        } catch (\PDOException $e) {
            throw new \Exception("Un sezione con questo nome esiste già!");
        }
    }

    /**
     * Metodo utilizzato per eliminare una sezione.
     *
     * @param $name Il nome della sezione.
     * @return bool True oppure false.
     */
    public static function delete($name)
    {
        $pdo = Database::getConnection();
        $query = "UPDATE section SET deleted = :flag WHERE name = :name";
        $stm = $pdo->prepare($query);
        $stm->bindValue(':flag', 1);
        $stm->bindValue(':name', $name);
        try {
            return $stm->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }
}

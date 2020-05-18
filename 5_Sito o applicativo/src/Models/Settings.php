<?php

namespace FilippoFinke\Models;

use Exception;
use FilippoFinke\Utils\Database;

/**
 * Settings.php
 * Classe utilizzata per intefacciarsi con la tabella "SETTING".
 *
 * @author Filippo Finke
 */
class Settings
{
    /**
     * Metodo utilizzato per ricavare tutte le impostazioni.
     *
     * @return array Array di impostazioni.
     */
    public static function getAll()
    {
        $pdo = Database::getConnection();
        $query = "SELECT * FROM setting";
        try {
            $stm = $pdo->query($query);
            return $stm->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * Metodo utilizzato per ricavare una impostazione dal suo nome.
     *
     * @param $name Il nome dell'impostazione.
     * @return array La motivazione.
     */
    public static function get($name)
    {
        $pdo = Database::getConnection();
        $query = "SELECT * FROM setting WHERE name = :name";
        try {
            $stm = $pdo->prepare($query);
            $stm->bindParam(':name', $name);
            $stm->execute();
            return $stm->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * Metodo utilizzato per ricavare il valore di un impostazione dal suo nome.
     *
     * @param $name Il nome dell'impostazione.
     * @return string Il valore dell'impostazione.
     */
    public static function getValue($name)
    {
        $setting = self::get($name);
        if ($setting) {
            return $setting["value"];
        }
        return null;
    }

    /**
     * Metodo utilizzato per aggiornare una impostazione.
     *
     * @param $name Il nome dell'impostazione.
     * @param $value Il nuovo valore.
     * @return bool True o false.
     */
    public static function update($name, $value)
    {
        $setting = self::get($name);

        if ($setting) {
            if (
                call_user_func_array(
                    array("FilippoFinke\Libs\Validator", "isValid" . $setting["type"]),
                    array($value)
                )
            ) {
                $pdo = Database::getConnection();
                $query = "UPDATE setting SET value = :value WHERE name = :name";
                try {
                    $stm = $pdo->prepare($query);
                    $stm->bindParam(':value', $value);
                    $stm->bindParam(':name', $name);
                    return $stm->execute();
                } catch (\PDOException $e) {
                    return false;
                }
            } else {
                throw new Exception("Il valore deve essere di tipo: " . $setting["type"]);
            }
        } else {
            throw new Exception("Impostazione inesistente");
        }
    }
}

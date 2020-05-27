<?php

namespace FilippoFinke\Libs;

/**
 * Permission.php
 * Classe utilizzata per ricavare il permesso di un utente.
 *
 * @author Filippo Finke
 */
class Permission
{
    /**
     * Permesso di inserimento dei ritardi.
     */
    const INSERT = 1;

    /**
     * Permesso di visione dei ritardi.
     */
    const SELECT = 2;

    /**
     * Permesso di creazione PDF.
     */
    const CREATE = 4;

    /**
     * Permesso di amministratore.
     */
    const ADMINISTRATOR = 8;

    /**
     * Metodo utilizzato per controllare se un utente è amministratore.
     *
     * @param $permission Il permesso dell'utente.
     * @return bool True se è admin altrimenti false.
     */
    public static function isAdmin($permission = null)
    {
        if ($permission === null) {
            $permission = $_SESSION["permission"];
        }
        // Controllo che il bit del permesso sia impostato.
        return ($permission & self::ADMINISTRATOR) === self::ADMINISTRATOR;
    }

    /**
     * Metodo utilizzato per controllare se un utente può inserire ritardi.
     *
     * @param $permission Il permesso dell'utente.
     * @return bool True se ha il permesso altrimenti false.
     */
    public static function canInsert($permission = null)
    {
        if ($permission === null) {
            $permission = $_SESSION["permission"];
        }
        // Controllo che il bit del permesso sia impostato.
        return ($permission & self::INSERT) === self::INSERT || self::isAdmin($permission);
    }

    /**
     * Metodo utilizzato per controllare se un utente può visionare i ritardi.
     *
     * @param $permission Il permesso dell'utente.
     * @return bool True se ha il permesso altrimenti false.
     */
    public static function canSelect($permission = null)
    {
        if ($permission === null) {
            $permission = $_SESSION["permission"];
        }
        // Controllo che il bit del permesso sia impostato.
        return ($permission & self::SELECT) === self::SELECT || self::isAdmin($permission);
    }

    /**
     * Metodo utilizzato per controllare se un utente può creare PDF dei ritardi.
     *
     * @param $permission Il permesso dell'utente.
     * @return bool True se ha il permesso altrimenti false.
     */
    public static function canCreate($permission = null)
    {
        if ($permission === null) {
            $permission = $_SESSION["permission"];
        }
        // Controllo che il bit del permesso sia impostato.
        return ($permission & self::CREATE) === self::CREATE || self::isAdmin($permission);
    }
}

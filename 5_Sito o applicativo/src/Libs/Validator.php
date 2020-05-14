<?php

namespace FilippoFinke\Libs;

/**
 * Validator.php
 * Classe utilizzata per eseguire la validazione dei campi.
 *
 * @author Filippo Finke
 */

class Validator
{
    /**
     * Metodo che controlla se del testo è un nome valido.
     *
     * @param $name Il testo da controllare.
     * @return bool True se il testo è valido altrimento false.
     */

    public static function isValidName($name)
    {
        return preg_match('/^[A-Za-zÀ-ÖØ-öø-ÿ]{1,20}$/', $name);
    }

    /**
     * Metodo che controlla se del testo è un cognome valido.
     *
     * @param $name Il testo da controllare.
     * @return bool True se il testo è valido altrimento false.
     */
    public static function isValidLastName($name)
    {
        return self::isValidName($name);
    }

    /**
     * Metodo che controlla se del testo è una password valida.
     *
     * @param $password Il testo da controllare.
     * @return bool True se il testo è valido altrimento false.
     */
    public static function isValidPassword($password)
    {
        return (strlen($password) >= 6 && strlen($password) <= 32);
    }

    /**
     * Metodo che controlla se del testo è una email valida.
     *
     * @param $email Il testo da controllare.
     * @return bool True se il testo è valido altrimento false.
     */
    public static function isValidEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * Metodo che controlla se del testo è un numero.
     *
     * @param $password Il testo da controllare.
     * @return bool True se il testo è valido altrimento false.
     */
    public static function isValidNumber($number)
    {
        return ctype_digit($number);
    }
}

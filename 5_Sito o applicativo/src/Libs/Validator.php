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
        return preg_match('/^[A-Za-zÀ-ÖØ-öø-ÿ ]{1,20}$/', $name);
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
     * Metodo che controlla se il nome di una sezione è valido.
     *
     * @param $section Il testo da controllare.
     * @return bool True se il testo è valido altrimento false.
     */
    public static function isValidSection($section)
    {
        return preg_match('/^[A-Za-z0-9 ]{1,10}$/', $section);
    }

    /**
     * Metodo che controlla se un anno scolastico è valido.
     *
     * @param $start_first_date Data di inizio primo semestre.
     * @param $end_first_date Data di fine primo semestre.
     * @param $start_second_date Data di inizio secondo semestre.
     * @param $end_second_date  Data di fine secondo semestre.
     * @return bool True se l'anno è valido altrimento false.
     */
    public static function isValidSemester($start_first_date, $end_first_date, $start_second_date, $end_second_date)
    {

        $start_first_date = strtotime($start_first_date);
        $end_first_date = strtotime($end_first_date);
        $start_second_date = strtotime($start_second_date);
        $end_second_date = strtotime($end_second_date);

        return $start_first_date < $end_first_date && $start_second_date > $end_first_date && $start_second_date < $end_second_date;
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
    public static function isValidEmail($email, $valid_domain = null)
    {
        $valid = filter_var($email, FILTER_VALIDATE_EMAIL);
        if ($valid && $valid_domain) {
            $parts = explode('@', $email);
            $domain = array_pop($parts);
            return $domain == $valid_domain;
        }
        return $valid;
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

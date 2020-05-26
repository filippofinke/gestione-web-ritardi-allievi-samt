<?php

namespace FilippoFinke\Libs;

use FilippoFinke\Request;
use FilippoFinke\Response;

/**
 * Mail.php
 * Classe utilizzata per gestire l'invio di posta elettronica.
 *
 * @author Filippo Finke
 */
class Mail
{
    /**
     * L'email dal quale verranno inviati i messaggi.
     */
    private static $fromEmail;

    /**
     * Metodo setter per l'email dal quale inviare i messaggi.
     *
     * @param $fromEmail L'email.
     */
    public static function setFromEmail($fromEmail)
    {
        self::$fromEmail = $fromEmail;
    }

    /**
     * Metodo per inviare email.
     *
     * @param $to L'email al quale inviare le email.
     * @param $subject Il titolo dell'email.
     * @param $message Il contenuto dell'email.
     * @return bool True se è stata inviata altrimenti false.
     */
    public static function send($to, $subject, $message)
    {
        $eol = "\r\n";
        $headers = "From: <" . self::$fromEmail . ">" . $eol;
        $headers .= "Content-Type: text/html; charset=UTF-8" . $eol;
        return mail($to, $subject, $message, $headers);
    }
}

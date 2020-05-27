<?php

namespace FilippoFinke\Libs;

/**
 * Session.php
 * Classe utilizzata per gestire la sessione corrente.
 *
 * @author Filippo Finke
 */
class Session
{
    /**
     * Metodo utilizzato per ricavare il nome completo in formato: "Nome Cognome" dell'utente corrente.
     * 
     * @return string Il nome completo.
     */
    public static function getFullName()
    {
        if (isset($_SESSION["name"]) && isset($_SESSION["last_name"])) {
            // Costruisco il nome completo.
            return $_SESSION["name"] . " " . $_SESSION["last_name"];
        }
        return "Errore";
    }

    /**
     * Metodo utilizzato per controllare se un utente ha eseguito il login oppure no.
     *
     * @return bool True se è autenticato altrimenti false.
     */
    public static function isAuthenticated()
    {
        // Controllo se è presente l'indice authenticated.
        return (isset($_SESSION["authenticated"]) && $_SESSION["authenticated"] == true);
    }

    /**
     * Metodo utilizzato per autenticare l'utente corrente.
     *
     *  @param $data Un array contenente i parametri da salvare.
     */
    public static function authenticate($data = null)
    {
        $_SESSION["authenticated"] = true;
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                // Assegno in coppia key => value.
                $_SESSION[$key] = $value;
            }
        }
    }

    /**
     * Metodo utilizzato per eseguire la disconnessione.
     */
    public static function logout()
    {
        // Cancello tutti i dati della sessione.
        session_unset();
        // Distruggo la sessione.
        session_destroy();
    }
}

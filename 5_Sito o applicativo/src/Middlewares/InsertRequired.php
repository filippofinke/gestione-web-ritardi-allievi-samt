<?php

namespace FilippoFinke\Middlewares;

use FilippoFinke\Libs\Permission;

/**
 * InsertRequired.php
 * Classe utilizzata per controllare se un utente
 * può inserire dei ritardi.
 *
 * @author Filippo Finke
 */
class InsertRequired
{
    /**
     * Controlla se l'utente può aggiungere dati.
     *
     * @param $request La richiesta.
     * @param $response La risposta.
     */
    public function __invoke($request, $response)
    {
        // Controllo se l'utente non può inserire dei ritardi.
        if (!Permission::canInsert()) {
            // Ritorno una richiesta con codice 401 - Unauthorized.
            $response->withStatus(401);
            exit;
        }
    }
}

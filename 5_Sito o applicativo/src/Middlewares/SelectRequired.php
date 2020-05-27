<?php

namespace FilippoFinke\Middlewares;

use FilippoFinke\Libs\Permission;

/**
 * SelectRequired.php
 * Classe utilizzata per controllare se un utente
 * può visionare i ritardi.
 *
 * @author Filippo Finke
 */
class SelectRequired
{
    /**
     * Controlla se l'utente può visionare dati.
     *
     * @param $request La richiesta.
     * @param $response La risposta.
     */
    public function __invoke($request, $response)
    {
        // Controllo se l'utente non può visualizzare dei ritardi.
        if (!Permission::canSelect()) {
            // Ritorno una richiesta con codice 401 - Unauthorized.
            $response->withStatus(401);
            exit;
        }
    }
}

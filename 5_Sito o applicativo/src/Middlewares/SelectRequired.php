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
        if (!Permission::canSelect()) {
            $response->withStatus(401);
            exit;
        }
    }
}

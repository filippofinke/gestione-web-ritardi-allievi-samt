<?php

namespace FilippoFinke\Middlewares;

use FilippoFinke\Libs\Permission;

/**
 * AdminRequired.php
 * Classe utilizzata per controllare se un utente
 * ha l'accesso a determinati percorsi come utente amministratore.
 *
 * @author Filippo Finke
 */
class AdminRequired
{
    /**
     * Controlla se l'utente è un admin.
     *
     * @param $request La richiesta.
     * @param $response La risposta.
     */
    public function __invoke($request, $response)
    {
        if (!Permission::isAdmin()) {
            $response->redirect(BASE."login");
            exit;
        }
    }
}

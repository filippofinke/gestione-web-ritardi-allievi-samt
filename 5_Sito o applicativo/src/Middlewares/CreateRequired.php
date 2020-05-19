<?php

namespace FilippoFinke\Middlewares;

use FilippoFinke\Libs\Permission;

/**
 * CreateRequired.php
 * Classe utilizzata per controllare se un utente
 * può creare i PDF.
 *
 * @author Filippo Finke
 */
class CreateRequired
{
    /**
     * Controlla se l'utente può creare i PDF.
     *
     * @param $request La richiesta.
     * @param $response La risposta.
     */
    public function __invoke($request, $response)
    {
        if (!Permission::canCreate()) {
            $response->withStatus(401);
            exit;
        }
    }
}

<?php

namespace FilippoFinke\Controllers;

use FilippoFinke\Models\Settings;
use FilippoFinke\Request;
use FilippoFinke\Response;

/**
 * Setting.php
 * Controller che si occupa di gestire tutti i percorsi relativi alla modifica delle impostazioni.
 *
 * @author Filippo Finke
 */
class Setting
{
    /**
     * Metodo utilizzato per aggiornare il valore di una impostazione.
     *
     * @param $request La richiesta effettuata dall'utente.
     * @param $response La risposta da ritornare.
     * @return Response La risposta.
     */
    public static function update(Request $req, Response $res)
    {
        // Ricavo l'impostazione da aggiornare.
        $setting = $req->getAttribute('setting');
        // Ricavo il nuovo valore dell'impostazione.
        $value = $req->getParam('value');
        try {
            // Aggiorno il valore dell'impostazione.
            if ($value !== null && Settings::update($setting, $value)) {
                // Ritorno una richiesta con stato 200 - Success.
                return $res->withStatus(200);
            }
        } catch (\Exception $e) {
            // Ritorno una richiesta con stato 500 - Internal Server Error e un errore.
            return $res->withStatus(500)->withText($e->getMessage());
        }
        // Ritorno una richiesta con stato 400 - Bad Request.
        return $res->withStatus(400);
    }
}

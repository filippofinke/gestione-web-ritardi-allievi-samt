<?php

namespace FilippoFinke\Controllers;

use Exception;
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
        $setting = $req->getAttribute('setting');
        $value = $req->getParam('value');
        try {
            if ($value !== null && Settings::update($setting, $value)) {
                return $res->withStatus(200);
            }
        } catch (Exception $e) {
            return $res->withStatus(500)->withText($e->getMessage());
        }
        return $res->withStatus(400);
    }
}

<?php

namespace FilippoFinke\Controllers;

use FilippoFinke\Libs\Session;
use FilippoFinke\Request;
use FilippoFinke\Response;
use FilippoFinke\Models\Users;
use FilippoFinke\Models\Tokens;
use FilippoFinke\Libs\Validator;

/**
 * Auth.php
 * Controller che si occupa di gestire tutti i percorsi relativi all'autenticazione.
 *
 * @author Filippo Finke
 */
class Auth
{
    /**
     * Metodo che si occupa di caricare la pagina di accesso.
     *
     * @param $request La richiesta effettuata dall'utente.
     * @param $response La risposta da ritornare.
     * @return Response La risposta.
     */
    public static function login(Request $req, Response $res)
    {
        return $res->render(
            __DIR__ . '/../Views/Auth/login.php',
            array("token" => $req->getAttribute("token"))
        );
    }

    /**
     * Metodo che si occupa di caricare la pagina di recupero password.
     *
     * @param $request La richiesta effettuata dall'utente.
     * @param $response La risposta da ritornare.
     * @return Response La risposta.
     */
    public static function forgotPassword(Request $req, Response $res)
    {
        return $res->render(__DIR__ . '/../Views/Auth/forgot-password.php');
    }

    /**
     * Metodo utilizzato per verificare le credenziali dell'utente.
     *
     * @param $request La richiesta effettuata dall'utente.
     * @param $response La risposta da ritornare.
     * @return Response La risposta.
     */
    public static function doLogin(Request $req, Response $res)
    {
        $email = $req->getParam("email");
        $password = $req->getParam("password");
        if (isset($email) && Validator::isValidEmail($email) && isset($password) && Validator::isValidPassword($password)) {
            $user = Users::getByEmail($email);
            if ($user && password_verify($password, $user["password"])) {
                unset($user["password"]);
                Session::authenticate($user);
                return $res->withStatus(200);
            }
        }
        return $res->withStatus(403);
    }

    /**
     * Metodo utilizzato per eseguire la disconnessione.
     *
     * @param $request La richiesta effettuata dall'utente.
     * @param $response La risposta da ritornare.
     * @return Response La risposta.
     */
    public static function doLogout(Request $req, Response $res)
    {
        Session::logout();
        return $res->redirect("/login");
    }

    /**
     * Metodo utilizzato per eseguire il recupero password.
     *
     * @param $request La richiesta effettuata dall'utente.
     * @param $response La risposta da ritornare.
     * @return Response La risposta.
     */
    public static function doForgotPassword(Request $req, Response $res)
    {
        $email = $req->getParam("email");
        if (isset($email) && Validator::isValidEmail($email)) {
            if (Tokens::sendResetPasswordToken($email)) {
                return $res->withStatus(200);
            } else {
                return $res->withStatus(500);
            }
        }
        return $res->withStatus(400);
    }

    /**
     * Metodo utilizzato per cambiare la password.
     *
     * @param $request La richiesta effettuata dall'utente.
     * @param $response La risposta da ritornare.
     * @return Response La risposta.
     */
    public static function doChangePassword(Request $req, Response $res)
    {
        $token = $req->getParam("token");
        $password = $req->getParam("password");
        if (Users::changePassword($token, $password)) {
            return $res->withStatus(200);
        }
        return $res->withStatus(400);
    }
}

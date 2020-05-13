<?php

namespace FilippoFinke\Controllers;
use FilippoFinke\Request;
use FilippoFinke\Response;

class Test {

    public static function index(Request $req, Response $res) {
        return $res->render(__DIR__ . '/../Views/test.php');
    }

}
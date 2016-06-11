<?php
/**
 * Created by PhpStorm.
 * User: Lorenzo De Bernardini
 * Date: 11/06/2016
 * Time: 4:28 PM
 */

namespace Trippi\Controllers;

use Slim\Views\Twig;
use Slim\Router;
use Trippi\Models\Trip;
use Trippi\Models\Db;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Illuminate\Database\Capsule\Manager as Capsule;


class ProfileController{
    public function get(Response $response, Request $request, Twig $view, Trip $trip){
        $query = "SELECT a.locationID, l.city, l.country, a.rating 
                  FROM accomodation a, location l 
                  WHERE a.locationID = l.locationID AND 
                        a.rating > 2";

        $db = new Db();
        $result = $db->query($query);
        return $view->render($response, 'login.twig', [
            //'trips'=> $result
        ]);
    }
}

/*
 *
 */
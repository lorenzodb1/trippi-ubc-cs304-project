<?php
/**
 * Created by PhpStorm.
 * User: samirmarin
 * Date: 2016-06-10
 * Time: 10:50 PM
 */
namespace Trippi\Controllers;

use Slim\Views\Twig;
use Trippi\Models\Trip;
use Trippi\Models\Db;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class TripsController{

    public function index(Response $response, Request $request, Twig $view, Trip $trip){
        $query = "SELECT a.locationID, l.city, l.country, a.rating 
                  FROM accomodation a, location l 
                  WHERE a.locationID = l.locationID AND 
                        a.rating > 2";

        $db = new Db();
        $result = $db->query($query);

        $hotels = Capsule::table('accomodation')
            ->join('location', 'accomodation.locationID', '=', 'location.locationID')
            ->where('accomodation.rating', '>', '2')
            ->select('accomodation.locationID as id', 'location.city as city', 'location.country as country', 'accomodation.rating as rating')
            ->get();

        return $view->render($response, 'login.twig', [
            'trips'=> $result
        ]);
    }

}
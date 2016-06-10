<?php
/**
 * Created by PhpStorm.
 * User: samirmarin
 * Date: 2016-06-09
 * Time: 2:58 PM
 */
namespace Trippi\Controllers;

use Slim\Views\Twig;
use Trippi\Models\Trip;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

//testing
use Illuminate\Database\Capsule\Manager as Capsule;


class HomeController{
    public function index(Response $response, Request $request, Twig $view, Trip $trip){
        $trips = $trip->get();

        $hotels = Capsule::table('accomodation')
            ->join('location', 'accomodation.locationID', '=', 'location.locationID')
            ->where('accomodation.rating', '>', '2')
            ->select('accomodation.locationID as id', 'location.city as city', 'location.country as country', 'accomodation.rating as rating')
            ->get();

       // $query = "SELECT a.locationID, l.city, l.country, a.rating FROM accomodation a, location l WHERE a.locationID = l.locationID and a.rating > 2";


//        var_dump($trips->first()->tripId);
//        die();
        return $view->render($response, 'home.twig', [
            'trips'=> $hotels
        ]);
    }
}
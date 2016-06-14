<?php
/**
 * Created by PhpStorm.
 * User: giuliamattia
 * Date: 2016-06-13
 * Time: 3:34 PM
 */

namespace Trippi\Controllers;

use Slim\Router;
use Trippi\Models\Trip;


use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Trippi\Models\TripIDGenerator;
use Trippi\Models\CreateTrip;
use Slim\Router as router2;

class CreateTripController{

    public function createTrip(Request $request, Response $response, Twig $view, router2 $router){
        $data = $request->getParsedBody();
        $tripName =  filter_var($data['tripName'],FILTER_SANITIZE_STRING);
        $startDate = filter_var($data['startDate'],FILTER_SANITIZE_STRING);
        $endDate = filter_var($data['endDate'],FILTER_SANITIZE_STRING);

        $generator = new TripIDGenerator();
        $tripID = $generator->newTripID();
        
        $create = new CreateTrip();
        $createdTrip = $create->createNewTrip($tripID, $startDate, $endDate, $tripName);

        $tripModel = new Trip();
        $tripNames = $tripModel->getTripNameById($tripID);
        
        if($createdTrip) {
            return $view->render($response, 'trip/trip.twig', [
                'tripNames' => $tripNames
            ]);
        }
        
        else {
            return $response->withRedirect($router->pathFor('Trips.signIn'));
        }


    }

}

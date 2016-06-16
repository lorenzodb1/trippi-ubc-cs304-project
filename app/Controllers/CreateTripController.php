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
use Trippi\Models\IdGenerator;
use Trippi\Models\CreateTrip;
use Slim\Router as router2;

class CreateTripController  {

    public function createTrip(Request $request, Response $response, Twig $view, router2 $router){
        $data = $request->getParsedBody();
        $tripName =  filter_var($data['tripName'],FILTER_SANITIZE_STRING);
        $startDate = filter_var($data['startDate'],FILTER_SANITIZE_STRING);
        $endDate = filter_var($data['endDate'],FILTER_SANITIZE_STRING);
        $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
        

        $generator = new IdGenerator();
        $tripID = $generator->newTripID();
        
        $create = new CreateTrip();
        $createdTrip = $create->createNewTrip($tripID, $startDate, $endDate, $tripName);
        $linkTripToUser = $create->linkTripPlanner($email, $tripID);

        $tripModel = new Trip();
        //$tripName = $tripModel->getTripNameById($tripID);
        
        if($createdTrip and $linkTripToUser) {
            return $view->render($response, 'trip/trip_segment.twig', [
                'tripName' => $tripName,
                'tripId' => $tripID
            ]);
        }

        else {
            //return $response->withRedirect($router->pathFor('Trips.signIn'));
            return $view->render($response, 'trip/trip_segment.twig', [
                'tripName' => $tripName,
                'tripId' => $tripID
            ]);
        }


    }
    public function addLocationDetails(Request $request, Response $response, Twig $view){
        $data = $request->getParsedBody();
        $tripId =  filter_var($data['tripId'],FILTER_SANITIZE_STRING);
        $fromCity =filter_var($data['fromCity'], FILTER_SANITIZE_STRING);
        $fromCountry =filter_var($data['fromCountry'], FILTER_SANITIZE_STRING);
        $toCity = filter_var($data['toCity'],FILTER_SANITIZE_STRING);
        $toCountry = filter_var($data['toCountry'],FILTER_SANITIZE_STRING);
//        $hotelNameFrom =filter_var($data['hotelNameFrom'], FILTER_SANITIZE_STRING);
//        $checkInDateFrom =filter_var($data['checkInDateFrom'], FILTER_SANITIZE_STRING);
//        $checkOutDateFrom =filter_var($data['checkOutDateFrom'], FILTER_SANITIZE_STRING);
//        $activityFrom =  filter_var($data['activityFrom'],FILTER_SANITIZE_STRING);
//        $hotelNameTo = filter_var($data['hotelNameTo'], FILTER_SANITIZE_EMAIL);
//        $checkInDateTo = filter_var($data['checkInDateTo'], FILTER_SANITIZE_EMAIL);
//        $checkOutDateTo = filter_var($data['checkOutDateTo'], FILTER_SANITIZE_EMAIL);
//        $activityTo = filter_var($data['activityTo'], FILTER_SANITIZE_EMAIL);
//        $transpStarDate = filter_var($data['startDate'], FILTER_SANITIZE_EMAIL);
//        $transpEndDate = filter_var($data['endDate'], FILTER_SANITIZE_EMAIL);
        

//        $addTripDetails = $addTripDetails->addTripDetails($fromCity, $fromCountry, $toCity, $toCountry, $transpStarDate,
//                                        $transpEndDate, $tripId, $activityTo, $activityFrom, $hotelNameFrom,
//                                        $hotelNameTo, $checkInDateFrom, $checkOutDateFrom,
//                                        $checkInDateTo, $checkOutDateTo);

        $addTripDetails = new CreateTrip();
        $startingLocationId = $addTripDetails->addLocationDetails($fromCity, $fromCountry);
        $endingLocationId = $addTripDetails->addLocationDetails($toCity, $toCountry);
        $tripModel = new Trip();
        $tripName = $tripModel->getTripNameById($tripId);

        if($startingLocationId and $endingLocationId){
            return $view->render($response, 'trip/travelling_transportation.twig', [
                'tripName' => $tripName,
                'tripId' => $tripId,
                'tripDetails' => $addTripDetails,
                'startLocationId'=> $startingLocationId,
                'endLocationId'=> $endingLocationId,
                'startLocation'=> $fromCity . "," . $fromCountry,
                'endLocation'=> $toCity . "," . $toCountry
            ]);
        }
        else{
            return $view->render($response, 'trip/create_trip.twig', [
                'tripName' => $tripName,
                'tripId' => $tripId,
                'tripDetails' => $addTripDetails,
                'startLocationId'=> $startingLocationId,
                'endLocationId'=> $endingLocationId
            ]); 
        }
    }

}

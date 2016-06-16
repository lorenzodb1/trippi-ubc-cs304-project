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

    public function addTransportationDetails(Request $request, Response $response, Twig $view){
        $data = $request->getParsedBody();
        $tripId =  filter_var($data['tripId'],FILTER_SANITIZE_STRING);
        $startingLocationId =  filter_var($data['startingLocationId'],FILTER_SANITIZE_STRING);
        $endingLocationId =  filter_var($data['endingLocationId'],FILTER_SANITIZE_STRING);
        $startDate =  filter_var($data['startDate'],FILTER_SANITIZE_STRING);
        $endDate =  filter_var($data['endDate'],FILTER_SANITIZE_STRING);
        $type =  filter_var($data["type"],FILTER_SANITIZE_STRING);

        $addTransportationDetails = new CreateTrip();

        $generateID = new IdGenerator();
        $transportationID = $generateID->newTransportationId();
        //var_dump($transportationID);
        $addTransportationDetailsQuery = $addTransportationDetails->insertNewTravelTransportation(
            $transportationID,
            $startingLocationId,
            $endingLocationId,
            $tripId,
            $startDate,
            $endDate,
            $type);
        $tripModel = new Trip();
        $tripName = $tripModel->getTripNameById($tripId);
        
        $fromCity = $tripModel->getLocationCityById($startingLocationId);
        $fromCountry = $tripModel->getLocationCountryById($startingLocationId);

        $toCity = $tripModel->getLocationCityById($endingLocationId);

        $toCountry = $tripModel->getLocationCountryById($endingLocationId);

        var_dump($addTransportationDetailsQuery);



        if($addTransportationDetailsQuery){
            return $view->render($response, 'trip/trip_segment_activity.twig', [
                'tripName' => $tripName,
                'tripId' => $tripId,
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
                'startLocationId'=> $startingLocationId,
                'endLocationId'=> $endingLocationId,
                'startLocation'=> $fromCity . "," . $fromCountry,
                'endLocation'=> $toCity . "," . $toCountry
            ]);
        }
    }
    public function addLocationActivityDetails($locationId1, $locationId2, $tripId, Request $request, Response $response, Twig $view){
        $data = $request->getParsedBody();
        $nameActivityStart =  filter_var($data['nameActivityStart'],FILTER_SANITIZE_STRING);
        $placeActivityStart =  filter_var($data['placeActivityStart'],FILTER_SANITIZE_STRING);
        $dateActivityStart =  filter_var($data['dateActivityStart'],FILTER_SANITIZE_STRING);
        $nameActivityEnd =  filter_var($data['nameActivityEnd'],FILTER_SANITIZE_STRING);
        $placeActivityEnd =  filter_var($data['placeActivityEnd'],FILTER_SANITIZE_STRING);
        $dateActivityEnd =  filter_var($data['dateActivityEnd'],FILTER_SANITIZE_STRING);

        $addActivityDetails = new CreateTrip();
        
        $newActivity1 = $addActivityDetails->insertNewActivity(
            $nameActivityStart, 
            $placeActivityStart, 
            $dateActivityStart, 
            $locationId1);

        $newActivity2 = $addActivityDetails->insertNewActivity(
            $nameActivityEnd,
            $placeActivityEnd,
            $dateActivityEnd,
            $locationId2);

        $tripModel = new Trip();
        $tripName = $tripModel->getTripNameById($tripId);

        $fromCity = $tripModel->getLocationCityById($locationId1);
        $fromCountry = $tripModel->getLocationCountryById($locationId1);

        $toCity = $tripModel->getLocationCityById($locationId2);

        $toCountry = $tripModel->getLocationCountryById($locationId2);
        
        
        
        if($newActivity1 and $newActivity2){
            return $view->render($response, 'trip/accommodation_segment.twig', [
                'tripName' => $tripName,
                'tripId' => $tripId,
                'startLocationId'=> $locationId1,
                'endLocationId'=> $locationId2,
                'startLocation'=> $fromCity . "," . $fromCountry,
                'endLocation'=> $toCity . "," . $toCountry
            ]);
            
        }
        else{
            return $view->render($response, 'trip/create_trip.twig', [
                'tripName' => $tripName,
                'tripId' => $tripId,
                'startLocationId'=> $locationId1,
                'endLocationId'=> $locationId2,
                'startLocation'=> $fromCity . "," . $fromCountry,
                'endLocation'=> $toCity . "," . $toCountry
            ]);
        }

    }
    public function addAccommodationDetails($locationId1, $locationId2, $tripId, Request $request, Response $response, Twig $view){

        $data = $request->getParsedBody();
        $nameHotelStart =  filter_var($data['nameHotelStart'],FILTER_SANITIZE_STRING);
        $typeHotelStart =  filter_var($data['typeHotelStart'],FILTER_SANITIZE_STRING);
        $dateCheckInStart =  filter_var($data['dateCheckInStart'],FILTER_SANITIZE_STRING);
        $dateCheckoutStart =  filter_var($data['dateCheckoutStart'],FILTER_SANITIZE_STRING);
        $nameHotelEnd =  filter_var($data['nameHotelEnd'],FILTER_SANITIZE_STRING);
        $typeHotelEnd =  filter_var($data['typeHotelEnd'],FILTER_SANITIZE_STRING);
        $dateCheckInEnd =  filter_var($data['dateCheckInEnd'],FILTER_SANITIZE_STRING);
        $dateCheckoutEnd =  filter_var($data['dateCheckoutEnd'],FILTER_SANITIZE_STRING);

        $addAccommodationDetails = new CreateTrip();
        
        $accommodation1 = $addAccommodationDetails->insertNewAccommodation(
            $nameHotelStart, 
            $typeHotelStart, 
            $dateCheckInStart, 
            $dateCheckoutStart,
            $locationId1);

        $accommodation2 = $addAccommodationDetails->insertNewAccommodation(
            $nameHotelEnd,
            $typeHotelEnd,
            $dateCheckInEnd,
            $dateCheckoutEnd,
            $locationId2);
        
        if($accommodation1 and $accommodation2){

            return $view->render($response, 'trip/tripDetailsAddedSuccess.twig', [
//                'tripName' => $tripName,
//                'tripId' => $tripId,
//                'startLocationId'=> $locationId1,
//                'endLocationId'=> $locationId2,
//                'startLocation'=> $fromCity . "," . $fromCountry,
//                'endLocation'=> $toCity . "," . $toCountry
            ]);
            
        }
        
        else{
            return $view->render($response, 'trip/create_trip.twig', [
//                'tripName' => $tripName,
//                'tripId' => $tripId,
//                'startLocationId'=> $locationId1,
//                'endLocationId'=> $locationId2,
//                'startLocation'=> $fromCity . "," . $fromCountry,
//                'endLocation'=> $toCity . "," . $toCountry
            ]);
        }





    }





    }

<?php
/**
 * Created by PhpStorm.
 * User: samirmarin
 * Date: 2016-06-12
 * Time: 8:32 PM
 */

namespace Trippi\Controllers;

use Illuminate\Database\Eloquent\Model;
use Slim\Router;
use Trippi\Models\Authentication;
use Trippi\Models\Profile;
use Trippi\Models\Trip;
use Trippi\Models\UserRating;


use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Router as router3;

class ProfileController{

    public function getTrip($tripId, Request $request, Response $response, Twig $view){

        $tripModel = new Trip();
        $locations = $tripModel->getLocationsByTripId($tripId);
        $travelInfo = $tripModel->getTravelingInformationByTripId($tripId);
        $accommodations = $tripModel->getAccomodationsByTripId($tripId);
        $activities = $tripModel->getActivitiesByTripId($tripId);
        $tripNames = $tripModel->getTripNamesById($tripId);
        $users = $tripModel->searchUsersOnTrip($tripId);

        
        return $view->render($response, 'trip/trip.twig', [
            'locations'=> $locations,
            'travelInfo'=> $travelInfo,
            'accommodations'=> $accommodations,
            'activities'=>$activities,
            'tripNames'=>$tripNames,
            'users'=>$users
        ]);
        

    }
    
    public function deleteTrip($tripId, Request $request, Response $response, Twig $view, router3 $router) {
        
        $trip = new Trip();
        $deletedTrip = $trip->deleteTrip($tripId);
        
        if($deletedTrip) {
            return $response->withRedirect($router->pathFor('Trips.signIn'));
        }

        else {
            return $response->withRedirect($router->pathFor('Trips.signIn'));
        }
    }

    public function getAllTrips(Request $request, Response $response, Twig $view) {
        $trip = new Trip();
        $allTrips = $trip->allTrips();
        $count = $trip->countTrips();
        

        
            return $view->render($response, 'trip/trips.twig', [
                'trips'=> $allTrips,
                'triggerInfo' => $count]);
    }

    public function getOtherUser($email, Request $request, Response $response, Twig $view) {
        return $view->render($response, 'profile/other_profile.twig', [
            'users'=> Profile::get_profile($email),
            'plannedTrips'=> Authentication::userPlanTrip($email),
            'joinedTrips' => Authentication::userJoinTrip($email),
            'ratings' => UserRating::view_ratings($email)
        ]);
    }
}
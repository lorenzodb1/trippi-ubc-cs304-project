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
        $tripNames = $tripModel->getTripNameById($tripId);
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
    
    public function deleteTrip($tripId, $email, Request $request, Response $response, Twig $view, router3 $router) {
        
        $trip = new Trip();
        $deletedTrip = $trip->deleteTrip($tripId);
        
        if($deletedTrip) {
            $auth = new Authentication();
            $login = $auth->getUserInfo($email);

            return $view->render($response, 'profile/profile.twig', [
                'userEmail' =>$email,
                'users'=> $login,
                'plannedTrips'=> $auth->userPlanTrip($email),
                'joinedTrips' => $auth->userJoinTrip($email)
            ]);
        }

        else {
            return $response->withRedirect($router->pathFor('Trips.signIn'));
        }
    }

    public function removeTrip($tripId, $email, Request $request, Response $response, Twig $view, router3 $router) {

        $trip = new Trip();
        $removedTrip = $trip->removeTrip($tripId, $email);

        if($removedTrip) {
            $auth = new Authentication();
            
            $login = $auth->getUserInfo($email);

            return $view->render($response, 'profile/profile.twig', [
                'userEmail' =>$email,
                'users'=> $login,
                'plannedTrips'=> $auth->userPlanTrip($email),
                'joinedTrips' => $auth->userJoinTrip($email)
            ]);
        }

        else {
            return $response->withRedirect($router->pathFor('Trips.signIn'));
        }
    }

    public function getAllTrips(Request $request, Response $response, Twig $view) {
        $trip = new Trip();
        $allTrips = $trip->allTrips();
        

        
            return $view->render($response, 'trip/trips.twig', [
                'trips'=> $allTrips]);
    }

    public function getOtherUser($email, $remail, Request $request, Response $response, Twig $view) {
        if($email == $remail) {
            return $view->render($response, 'profile/profile.twig', [
                'userEmail' => $email,
                'users'=> Profile::get_profile($email),
                'plannedTrips' => Authentication::userPlanTrip($email),
                'joinedTrips' => Authentication::userJoinTrip($email),
                'ratings' => UserRating::view_ratings($email)
            ]);
        } else {
            return $view->render($response, 'profile/other_profile.twig', [
                'uemail' => $remail,
                'users'=> Profile::get_profile($email),
                'plannedTrips'=> Authentication::userPlanTrip($email),
                'joinedTrips' => Authentication::userJoinTrip($email),
                'ratings' => UserRating::view_ratings($email)
            ]);
        }
    }
}
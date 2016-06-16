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


    public function getUneditedTrip($tripId, $email, Request $request, Response $response, Twig $view) {
        $tripModel = new Trip();
        $locations = $tripModel->getLocationsByTripId($tripId);
        $travelInfo = $tripModel->getTravelingInformationByTripId($tripId);
        $accommodations = $tripModel->getAccomodationsByTripId($tripId);
        $activities = $tripModel->getActivitiesByTripId($tripId);
        $tripNames = $tripModel->getTripNameById($tripId);
        $users = $tripModel->searchUsersOnTrip($tripId);
        


        return $view->render($response, 'trip/trip_no_edits.twig', [
            'locations'=> $locations,
            'travelInfo'=> $travelInfo,
            'accommodations'=> $accommodations,
            'activities'=>$activities,
            'tripNames'=>$tripNames,
            'users'=>$users,
            'userEmail' => $email,
            
            'tripId' => $tripId
        ]);
    }



    public function getTrip($tripId, $email, Request $request, Response $response, Twig $view){

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
            'users'=>$users,
            'userEmail' => $email,
            
            'tripId' => $tripId
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

    public function getAllTrips($email, Request $request, Response $response, Twig $view) {
        $trip = new Trip();
        $allTrips = $trip->allTrips();
        

        
            return $view->render($response, 'trip/trips.twig', [
                'trips'=> $allTrips,
                'userEmail' => $email]);
    }

    public function delete_profile($email, Request $request, Response $response, Twig $view) {
        $data = $request->getParsedBody();
        $password =  filter_var($data['password'],FILTER_SANITIZE_STRING);
        Profile::delete_profile($email, $password);
        return $view->render($response, 'login.twig', [
        ]);
    }

    public function update_profile($email, Request $request, Response $response, Twig $view) {
        $data = $request->getParsedBody();
        $password =  filter_var($data['password'],FILTER_SANITIZE_STRING);
        $newdata = filter_var($data['newdata'],FILTER_SANITIZE_STRING);
        $value = $data['select'];
        Profile::update_profile($email, $password, $value, $newdata);
        return $view->render($response, 'profile/profile.twig', [
            'userEmail' => $email,
            'users'=> Profile::get_profile($email),
            'plannedTrips' => Authentication::userPlanTrip($email),
            'joinedTrips' => Authentication::userJoinTrip($email),
            'ratings' => UserRating::view_ratings($email)
        ]);
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
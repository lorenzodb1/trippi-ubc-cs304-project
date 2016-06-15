<?php
/**
 * Created by PhpStorm.
 * User: samirmarin
 * Date: 2016-06-09
 * Time: 2:58 PM
 */

namespace Trippi\Controllers;

use Slim\Views\Twig;
use Slim\Router;
use Trippi\Models\Authentication;
use Trippi\Models\Trip;
use Trippi\Models\Users;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class SearchController {

    public function index(Response $response, Request $request, Twig $view, Trip $trip){
        return $view->render($response, 'search/search.twig', []);
    }

    /*
     * Search for any user
     */
    public function searchByUser(Response $response, Request $request, Twig $view, Router $router) {
        $uri = $request->getUri();
        $data = $request->getQueryParams();

        $queryFunction = filter_var($data['queryFunction'], FILTER_SANITIZE_STRING);

        if( $queryFunction == 'searchUserByUserName') {
          $userName = filter_var($data['username'], FILTER_SANITIZE_STRING);
          
          if($userName) {
            $users = new Users();
            $userList = $users->searchUserByUserName($userName);
          
            if($userList) {
              return $this->returnResults($userList);
            }
          } else {
              return null;
          }

        } else if ( $queryFunction == 'searchByUsersName') {

          $name = filter_var($data['name'], FILTER_SANITIZE_STRING);
          if( $name ) {
            $users = new Users();
            $userList = $users->searchByUserName($name);
            if($userList) {
              return $this->returnResults($userList);
            }

          } else {
              return null;
          }
          

        } else if ( $queryFunction == 'searchByUsersEmail') {

          $email = filter_var($data['email'], FILTER_SANITIZE_STRING);
          if( $email ) {
            $users = new Users();
            $userList = $users->searchByUserEmail($email);
            if($userList) {
              return $this->returnResults($userList);
            }

          } else {
              return null;
          }
          

        } else if ( $queryFunction == 'searchByUserRating') {

          $rating = filter_var($data['rating'], FILTER_SANITIZE_STRING);
          if( $rating ) {
            $users = new Users();
            $userList = $users->searchByUserRating($rating);
            if($userList) {
              return $this->returnResults($userList);
            }

          } else {
              return null;
          }
          

        } else if ( $queryFunction == 'searchByUserLocation') {

          $city = filter_var($data['city'], FILTER_SANITIZE_STRING);
          $country = filter_var($data['country'], FILTER_SANITIZE_STRING);
          if( $city || $country ) {
            $users = new Users();
            $userList = $users->searchByUserLocation($country, $city);
            if($userList) {
              return $this->returnResults($userList);
            }

          } else {
              return null;
          }
          

        } else if ( $queryFunction == 'searchByUsersInTrip') {

          $tripId = filter_var($data['tripId'], FILTER_SANITIZE_STRING);
          if( $tripId ) {
            $users = new Users();
            $userList = $users->returnMembersOfTrip($tripId);
            if($userList) {
              return $this->returnResults($userList);
            }

          } else {
              return null;
          }
          

        } else if ( $queryFunction == 'searchByUsersTravelledToLocation') {

          $city = filter_var($data['city'], FILTER_SANITIZE_STRING);
          if( $city ) {
            $users = new Users();
            $userList = $users->returnUsersTravelledTO($city);
            if($userList) {
              return $this->returnResults($userList);
            }
          } else {
              return null;
          }
          
        }
    }

    /*
     * Search for any trip
     */
    public function searchByTrip(Response $response, Request $request, Twig $view, Router $router) {
        $uri = $request->getUri();
        $data = $request->getQueryParams();

        $queryFunction = filter_var($data['queryFunction'], FILTER_SANITIZE_STRING);

        if( $queryFunction == 'searchForMaxRatedTrip') {
            
            $trips = new Trip();
            $tripList = $trips->searchMaxTripRating();
            return $this->returnResults($tripList);

        } else if( $queryFunction == 'searchForMinRatedTrip') {
            
            $trips = new Trip();
            $tripList = $trips->searchMinTripRating();
            return $this->returnResults($tripList);

        } else if( $queryFunction == 'searchForAvgRatedTrip') {
            
            $trips = new Trip();
            $tripList = $trips->searchAvgTripRatingByTrip();
            return $this->returnResults($tripList);

        } else if( $queryFunction == 'searchIncompleteTrips') {
            
            $trips = new Trip();
            $tripList = $trips->searchIncompleteTrips();
            return $this->returnResults($tripList);

        } else if( $queryFunction == 'searchCompleteTrips') {
            
            $trips = new Trip();
            $tripList = $trips->searchCompleteTrips();
            return $this->returnResults($tripList);

        } else if( $queryFunction == 'searchForAllUsersOnTrip') {
            
            $tripId = filter_var($data['tripId'], FILTER_SANITIZE_STRING);
            $trips = new Trip();
            $tripList = $trips->searchUsersOnTrip($tripId);
            return $this->returnResults($tripList);

        }  else if( $queryFunction == 'searchForAllTripsStartingFrom') {
            
            $startLocation = filter_var($data['startLocation'], FILTER_SANITIZE_STRING);
            $trips = new Trip();
            $tripList = $trips->searchTripsByStartLocation($startLocation);
            return $this->returnResults($tripList);

        } else if( $queryFunction == 'searchTripsByEqualDuration') {
            
            $duration = filter_var($data['duration'], FILTER_SANITIZE_STRING);
            $trips = new Trip();
            $tripList = $trips->searchTripsByGreaterDuration($duration);
            return $this->returnResults($tripList);

        }   else if( $queryFunction == 'searchTripsByGreaterDuration') {
            
            $duration = filter_var($data['duration'], FILTER_SANITIZE_STRING);
            $trips = new Trip();
            $tripList = $trips->searchTripsByGreaterDuration($duration);
            return $this->returnResults($tripList);

        } else if( $queryFunction == 'searchTripsByLesserDuration') {

            $duration = filter_var($data['duration'], FILTER_SANITIZE_STRING);
            $trips = new Trip();
            $tripList = $trips->searchTripsByLesserDuration($duration);
            return $this->returnResults($tripList);

        }
    }

    public function returnResults($response) {
      if($response) {
        return json_encode($response);
      } else {
        return null;
      }
    }

}

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
use Trippi\Models\Location;
use Trippi\Models\Trip;
use Trippi\Models\Users;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class LocationsController {

    /*
     * Search for locations
     */
    public function searchByLocation(Response $response, Request $request, Twig $view, Router $router) {
        $uri = $request->getUri();
        $data = $request->getQueryParams();

        $queryFunction = filter_var($data['queryFunction'], FILTER_SANITIZE_STRING);

        if( $queryFunction == 'searchUserByUserName') {
          $locationList = filter_var($data['username'], FILTER_SANITIZE_STRING);
          
          if($locationList) {
            $users = new Users();
            $locationList = $users->searchUserByUserName($locationList);
          
            if($locationList) {
              return $this->returnResults($locationList);
            }
          } else {
              return null;
          }

        } 
    }    

    public function addLocationToTrip(Response $response, Request $request, Twig $view, Router $router) {
      $data = $request->getParsedBody();

      if( $data ) {
        $location = new Location();
        $location2 = new Location();
        $location3 = new Location();

        $tripId = filter_var($data['tripID'], FILTER_SANITIZE_STRING);
        $city1 = filter_var($data['city1'], FILTER_SANITIZE_STRING);
        $country1 = filter_var($data['country1'], FILTER_SANITIZE_STRING);
        $city2 = filter_var($data['city2'], FILTER_SANITIZE_STRING);
        $country2 = filter_var($data['country2'], FILTER_SANITIZE_STRING);
        $type = filter_var($data['type'], FILTER_SANITIZE_STRING);
        $fromDate = filter_var($data['fromDate'], FILTER_SANITIZE_STRING);
        $toDate = filter_var($data['toDate'], FILTER_SANITIZE_STRING);

        $fromLocationId = $location->getLocationIDWithParams( $city1, $country1 );
        $toLocationId = $location->getLocationIDWithParams( $city2, $country2 );
        $doesDurationExist = $location->doesDurationExist( $fromDate, $toDate );

        if( !$fromLocationId ) {

            $fromLocationId = substr($this->GUID(), 0, 8);
            $location->addLocation( $fromLocationId, $city1, $country1 );
          }

        }

        if( !$toLocationId ) {

            $toLocationId = substr($this->GUID(), 0, 8);
            $location2->addLocation( $toLocationId, $city2, $country2 );
        }

        if( !$doesDurationExist ) {
            // Calculate duration
            $duration = intval(substr($toDate, 8, 2)) - intval(substr($fromDate, 8, 2));
            $duration = $duration . ' days';

            $location->addDuration( $fromDate, $toDate, $duration );
        }

        $travelId = substr($this->GUID(), 0, 8);

        $location3->addLocationToTrip( $travelId, $tripId, $fromLocationId, $toLocationId, $type, $fromDate, $toDate );

      }
    


    private function GUID() {
        if (function_exists('com_create_guid') === true)
        {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    public function returnResults($response) {
      if($response) {
        return json_encode($response);
      } else {
        return null;
      }
    }

}

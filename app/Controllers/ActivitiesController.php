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
use Trippi\Models\Location;
use Trippi\Models\Activities;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ActivitiesController {

    /*
     * Search for locations
     */
    public function updateActivity(Response $response, Request $request, Twig $view, Router $router) {
      $uri = $request->getUri();
      $data = $request->getParsedBody();;

      $city = filter_var($data['city'], FILTER_SANITIZE_STRING);
      $country = filter_var($data['country'], FILTER_SANITIZE_STRING);
      $activityName = filter_var($data['acitivtyName'], FILTER_SANITIZE_STRING);
      $place = filter_var($data['place'], FILTER_SANITIZE_STRING);
      $cost = filter_var($data['cost'], FILTER_SANITIZE_STRING);
      $date = filter_var($data['date'], FILTER_SANITIZE_STRING);

      // Find location ID
      $location = new Location();
      $locationID = $location->getLocationIDWithParams( $city, $country );

      if( ! $locationID ) {
        $locationID = substr( $this->GUID(), 0, 8 );
        $location->addLocation( $locationID, $city, $country );
      } else {
        var_dump($locationID);
        $locationID = $locationID[0];
        $locationID = $locationID['locationID'];
      }

      // Check if activity already exists

      $activities = new Activities();
      $exists = $activities->getActivityByKeys( $locationID, $activityName, $place );
      if( $exists ) {
        return $this->returnResults( $activities->updateActivity( $city, $country, $activityName, $place, $cost, $date ) );
      } else {
        return $activities->addNewActivity( $locationID, $activityName, $place, $cost, $date );
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

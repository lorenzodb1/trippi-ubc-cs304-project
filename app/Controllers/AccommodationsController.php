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
use Trippi\Models\Accommodation;
use Trippi\Models\Location;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AccommodationsController {

    /*
     * Search for locations
     */
    public function updateAccommodation(Response $response, Request $request, Twig $view, Router $router) {

        $data = $request->getParsedBody();
        $acc = new Accommodation();

        if( $data ) {

          $name = filter_var($data['name'], FILTER_SANITIZE_STRING);
          $city = filter_var($data['city'], FILTER_SANITIZE_STRING);
          $country = filter_var($data['country'], FILTER_SANITIZE_STRING);
          $type = filter_var($data['type'], FILTER_SANITIZE_STRING);
          $cost = filter_var($data['cost'], FILTER_SANITIZE_STRING);
          $rating = filter_var($data['rating'], FILTER_SANITIZE_STRING);
          $startDate = filter_var($data['startDate'], FILTER_SANITIZE_STRING);
          $toDate = filter_var($data['toDate'], FILTER_SANITIZE_STRING);

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

          if( $acc->doesAccommodationExist( $name, $type, $locationID ) ) {
              $acc->updateAccommodation( $name, $type, $cost, $rating, $startDate, $toDate, $locationID );

          } else {
              $acc->addNewAccommodation( $name, $type, $cost, $rating, $startDate, $toDate, $locationID );            
          }


        }


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

      private function returnArrayResult( $result ) {
        if( $result ) {
          // Successful Match
          $rows = array();
          while($row = mysqli_fetch_array($result)) {
            $rows[] = $row;
          }
          return $rows;
        } else {
          // No match found
          return false;
        }  
      }

}

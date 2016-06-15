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

    public function returnResults($response) {
      if($response) {
        return json_encode($response);
      } else {
        return null;
      }
    }

}

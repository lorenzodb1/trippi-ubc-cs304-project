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
use Trippi\Models\Trip;
use Trippi\Models\Db;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

//testing
use Illuminate\Database\Capsule\Manager as Capsule;


class HomeController{
    public function index(Response $response, Request $request, Twig $view, Trip $trip){
        $query = "SELECT a.locationID, l.city, l.country, a.rating FROM accomodation a, location l WHERE a.locationID = l.locationID and a.rating > 2";

        $db = new Db();
        $result = $db->query($query);
        return $view->render($response, 'login.twig', [
            //'trips'=> $result
        ]);
    }
    
    public function signIn(Response $response, Request $request, Twig $view, Router $router){

        $data = $request->getParsedBody();
        $email_info = '\'' . filter_var($data['email'], FILTER_SANITIZE_STRING) . '\'';
        $password_info = $data['password'];
        var_dump($email_info);
        var_dump($password_info);
        //var_dump($user_info['password']);
        //$email = $array[0];
        //$password = $request->getAttribute('password');
        $db = new Db();
        $query = "SELECT *
                  FROM `user` u 
                  WHERE u.email = " . $email_info;
        $result = $db->query($query);
        
        if($result){
            //check if the password is correct
            $query2 = "SELECT a.locationID, l.city, l.country, a.rating 
                       FROM accomodation a, location l 
                       WHERE a.locationID = l.locationID AND 
                             a.rating > 2";

            $tripsHotelResult = $db->query($query2);
            return $view->render($response, 'profile/profile.twig', ['trips'=> $tripsHotelResult]);
            
            //else we must say password is incorrect and redirect back to page..
            
        }
        else{
            //redirect and give error message saying user name does not exist
            return $response->withRedirect($router->pathFor('home'));
//            $query2 = "SELECT a.locationID, l.city, l.country, a.rating
//                       FROM accomodation a, location l
//                       WHERE a.locationID = l.locationID AND
//                             a.rating > 2";
//
//            $tripsHotelResult = $db->query($query2);
//            return $view->render($response, 'Trips/Trips.twig', [
//                'trips'=> $tripsHotelResult
//            ]);
        }

        //validate our signIn-- if everything is out then direct user to page with trip info.. 
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: giuliamattia
 * Date: 2016-06-14
 * Time: 8:24 PM
 */

namespace Trippi\Controllers;
use Slim\Router;
use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Trippi\Models\Authentication;
use Trippi\Models\JoinTrip;

class JoinTripController {
    
    
    public function joinTrip($email, Request $request, Response $response, Twig $view, Router $router) {
        $data = $request->getParsedBody();
        $tripId = $data['select'];
        $joinedTrip = JoinTrip::joinTrip($tripId, $email);
        if($joinedTrip) {
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
            return $response->withRedirect($router->pathFor('home'));
        }
        
        
        
    }
    
    
    
    
    
    
}
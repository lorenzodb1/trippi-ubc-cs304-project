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
use Trippi\Models\Db;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

//testing
use Illuminate\Database\Capsule\Manager as Capsule;


class HomeController{
    public function index(Response $response, Request $request, Twig $view, Trip $trip){
        return $view->render($response, 'login.twig', [
        ]);
    }
    
    public function signIn(Response $response, Request $request, Twig $view, Router $router){
        $data = $request->getParsedBody();
        $email =  filter_var($data['email'],FILTER_SANITIZE_EMAIL);
        $password =  filter_var($data['password'],FILTER_SANITIZE_STRING);
        $authenticate = new Authentication();
        if($authenticate->verifyEmail($email)){
            //check if the password is correct
            $login = $authenticate->login($email, $password);
            if($login) {
                return $view->render($response, 'profile/profile.twig', [
                    'users'=> $login,
                    'trips'=> $authenticate->userTrips($email)
                ]);

            }
            else{
                return $response->withRedirect($router->pathFor('home'));
            }
        }
        else{
            return $response->withRedirect($router->pathFor('home'));
        }

    }

    public function signUp(Response $response, Request $request, Twig $view, Router $router){

    }
}
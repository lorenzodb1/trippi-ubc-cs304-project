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
use Trippi\Models\SignUp;
use Trippi\Models\Trip;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
//testing
class HomeController{
    public function index(Response $response, Request $request, Twig $view, Trip $trip){
        return $view->render($response, 'login.twig', [
        ]);
    }

    public function signIn(Response $response, Request $request, Twig $view, Router $router){
        $data = $request->getParsedBody();
        $email =  filter_var($data['email'],FILTER_SANITIZE_EMAIL);
        $password =  $data['password'];
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
    
    /*
     * TODO: To be completed...
     */
    public function signUp(Response $response, Request $request, Twig $view, Router $router){
        $data = $request->getParsedBody();
        $test_email = filter_var($data['email'],FILTER_SANITIZE_EMAIL);
        $email = &data['email'];
        if($test_email != $email) {
            //go back to homepage and say what when wrong
            return $response->withRedirect($router->pathFor('home'));
        }
        $password =  $data['password'];
        $authenticate = new Authentication();
        if(!$authenticate->verifyEmail($email)){
            //check if the password exists
            $check = new SignUp();
            $signup = $check->sign_up($email, $password);
            if($signup) {
//                return $view->render($response, 'profile/profile.twig', [
//                    'users'=> $login,
//                    'trips'=> $authenticate->userTrips($email)
//                ]);
            }
            else{
//                return $response->withRedirect($router->pathFor('home'));
            }
        }
        else{
//            return $response->withRedirect($router->pathFor('home'));
        }
    }
}
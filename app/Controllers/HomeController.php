<?php
/**
 * Created by PhpStorm.
 * User: samirmarin
 * Date: 2016-06-09
 * Time: 2:58 PM
 */
namespace Trippi\Controllers;

use ControllersUtils;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Slim\Views\Twig;
use Slim\Router;
use Trippi\Models\Authentication;
use Trippi\Models\ModelsUtils;
use Trippi\Models\Profile;
use Trippi\Models\SignUp;
use Trippi\Models\Trip;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Trippi\Models\UserRating;

//testing
class HomeController{

    public function index(Response $response, Request $request, Twig $view, Trip $trip){
        return $view->render($response, 'login.twig', [
        ]);
    }
    
    
    public function getProfile($email, Response $response, Request $request, Twig $view, Router $router) {

        $auth = new Authentication();
        $login = $auth->getUserInfo($email);
        
        return $view->render($response, 'profile/profile.twig', [
            'userEmail' => $email,
            'users'=> $login,
            'plannedTrips'=> Authentication::userPlanTrip($email),
            'joinedTrips' => Authentication::userJoinTrip($email),
            'ratings' => UserRating::view_ratings($email)
        ]);
    }
    


    public function signIn(Response $response, Request $request, Twig $view, Router $router){
        $data = $request->getParsedBody();
        $email =  filter_var($data['email'],FILTER_SANITIZE_EMAIL);
        $password =  $data['password'];
        if(ModelsUtils::verifyEmail($email)){
            //check if the password is correct
            $login = Authentication::login($email, $password);
            if($login) {
                return $view->render($response, 'profile/profile.twig', [
                    'userEmail' => $email,
                    'users'=> $login,
                    'plannedTrips'=> Authentication::userPlanTrip($email),
                    'joinedTrips' => Authentication::userJoinTrip($email),
                    'ratings' => UserRating::view_ratings($email)
                ]);
            }
            else{
                return $view->render($response, '/login.twig', [
                    'error' => $email
                ]);
            }
        }
        else{
                return $view->render($response, '/login.twig', [
                    'error' => $email
                ]);
        }
    }

    public function signUp(Response $response, Request $request, Twig $view, Router $router)
    {
        $data = $request->getParsedBody();
        $username = filter_var($data['username'], FILTER_SANITIZE_STRING);
        $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
        $password = $data['password'];
        if (ModelsUtils::verifyEmail($email)) {
            $signup = SignUp::sign_up($username, $email, $password);
            if ($signup) {
                return $view->render($response, 'profile/new_profile.twig', [
                    'users'=> Profile::get_profile($email)
                ]);
            } else {
                return $response->withRedirect($router->pathFor('home'));
            }
        }
        else{
            return $response->withRedirect($router->pathFor('home'));
        }
    }

    public function getTrip(Response $response, Request $request, Twig $view, Router $router){
        return $view->render($response, 'trip/trip.twig');
    }
}
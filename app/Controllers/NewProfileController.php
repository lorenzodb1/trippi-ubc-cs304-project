<?php
/**
 * Created by PhpStorm.
 * User: lorenzodb1
 * Date: 13/06/2016
 * Time: 7:14 PM
 */

namespace Trippi\Controllers;

use Illuminate\Support\Facades\Auth;
use Slim\Router;
use Trippi\Models\Authentication;
use Trippi\Models\ModelsUtils;
use Trippi\Models\Profile;
use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class NewProfileController {

    public function create_profile($email, Response $response, Request $request, Twig $view, Router $router)
    {
        $data = $request->getParsedBody();
        $name = filter_var($data['name'], FILTER_SANITIZE_STRING);
        $dob = filter_var($data['dob'], FILTER_SANITIZE_STRING);
        $hometown = filter_var($data['hometown'], FILTER_SANITIZE_STRING);
        $country = filter_var($data['country'], FILTER_SANITIZE_STRING);
        $bio = filter_var($data['bio'], FILTER_SANITIZE_STRING);
        if(ModelsUtils::verifyEmail($email)) {
            //check if the password is correct
            $create = Profile::create_profile($email, $name, $hometown, $country, $dob, $bio);
            if ($create) {
                return $view->render($response, 'profile/profile.twig', [
                    'userEmail' => $email,
                    'users' => Profile::get_profile($email),
                    'plannedTrips' => Authentication::userPlanTrip($email),
                    'joinedTrips' => Authentication::userJoinTrip($email)
                ]);
            } else {
                return $response->withRedirect($router->pathFor('profile/new_profile'));
            }
        }
        else{
            return $response->withRedirect($router->pathFor('profile/new_profile'));
        }
    }

    public function getTrip(Response $response, Request $request, Twig $view, Router $router)
    {
        return $view->render($response, 'trip/trip.twig');
    }
}
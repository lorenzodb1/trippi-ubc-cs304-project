<?php
/**
 * Created by PhpStorm.
 * User: lorenzodb1
 * Date: 15/06/2016
 * Time: 2:45 PM
 */

namespace Trippi\Controllers;

use Trippi\Models\Authentication;
use Trippi\Models\Profile;
use Trippi\Models\UserRating;

use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Router as router3;

class RatingsController{

    public function add_rating($remail, Request $request, Response $response, Twig $view, router3 $router) {
        $data = $request->getParsedBody();
        $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
        $rating =  filter_var($data['rating'],FILTER_SANITIZE_STRING);
        $comment = filter_var($data['comment'],FILTER_SANITIZE_STRING);
        UserRating::add_rating($email, $remail, $rating, $comment);
        return $view->render($response, 'profile/other_profile.twig', [
            'users'=> Profile::get_profile($remail),
            'plannedTrips'=> Authentication::userPlanTrip($remail),
            'joinedTrips' => Authentication::userJoinTrip($remail),
            'ratings' => UserRating::view_ratings($remail)
        ]);
    }
}
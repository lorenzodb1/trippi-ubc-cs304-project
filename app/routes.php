<?php
/**
 * Created by PhpStorm.
 * User: samirmarin
 * Date: 2016-06-09
 * Time: 2:57 PM
 */


$app->get('/', ['Trippi\Controllers\HomeController', 'index'])->setName('home');

$app->post('/profile', ['Trippi\Controllers\HomeController', 'signIn'])->setName('signIn');

$app->post('/new_account', ['Trippi\Controllers\HomeController', 'signUp'])->setName('signUp');

$app->post('/new_profile/{email}', ['Trippi\Controllers\NewProfileController', 'create_profile'])->setName('getInfo');

// Locations
$app->get('/locations', ['Trippi\Controllers\LocationsController', 'searchByLocation'])->setName('searchByLocation');
$app->post('/locations', ['Trippi\Controllers\LocationsController', 'addLocationToTrip'])->setName('addLocationToTrip');

// Activities
$app->post('/activities', ['Trippi\Controllers\ActivitiesController', 'updateActivity'])->setName('updateActivity');

// Search Routes
$app->get('/search', ['Trippi\Controllers\SearchController', 'index'])->setName('goToSearch');
$app->get('/search/users', ['Trippi\Controllers\SearchController', 'searchByUser'])->setName('searchByUser');
$app->get('/search/trips', ['Trippi\Controllers\SearchController', 'searchByTrip'])->setName('searchByTrip');

//TODO: SM: this routing naming a a bit confusing it goes to the home buts its route with trips time permiting we can refactor the name.
$app->get('/profile', ['Trippi\Controllers\HomeController', 'signIn'])->setName('Trips.signIn');

$app->get('/profile/{tripId}/{email}', ['Trippi\Controllers\ProfileController', 'getTrip'])->setName('trip.getTrip');
$app->post('/createProfile', ['Trippi\Controllers\CreateTripController', 'createTrip'])->setName('trip.createTrip');
$app->get('/createProfile', ['Trippi\Controllers\CreateTripController', 'createTrip'])->setName('trip.getCreateTrip');

$app->post('/createProfile/addLocations', ['Trippi\Controllers\CreateTripController', 'addLocationDetails'])->setName('addLocationDetails');

$app->get('/deleteProfile/{tripId}/{email}', ['Trippi\Controllers\ProfileController', 'deleteTrip'])->setName('trip.deleteTrip');


$app->get('/getTrips/{email}', ['Trippi\Controllers\ProfileController', 'getAllTrips'])->setName('trip.getAllTrips');

$app->get('/otherProfile/{email}/{remail}', ['Trippi\Controllers\ProfileController', 'getOtherUser'])->setName('getProfile');

$app->post('/otherProfile/', ['Trippi\Controllers\ProfileController', 'getOtherUser'])->setName('viewProfile');

$app->post('/addedRating/{email}/{remail}', ['Trippi\Controllers\RatingsController', 'add_rating'])->setName('addRating');

$app->post('/joinProfile', ['Trippi\Controllers\JoinTripController', 'joinTrip'])->setName('trip.joinTrip');

$app->get('/profileTrip/{tripId}/{email}', ['Trippi\Controllers\ProfileController', 'getUneditedTrip'])->setName('trip.getUneditedTrip');

$app->get('/getProfile/{email}', ['Trippi\Controllers\HomeController', 'getProfile'])->setName('trip.getProfile');

$app->post('/createProfile/addTransportation', ['Trippi\Controllers\CreateTripController', 'addTransportationDetails'])->setName('addTransportationDetails');
$app->post('/createProfile/addActivities/{locationId1}/{locationId2}/{tripId}', ['Trippi\Controllers\CreateTripController', 'addLocationActivityDetails'])->setName('addLocationActivities');
$app->post('/createProfile/addAccommodations/{locationId1}/{locationId2}/{tripId}', ['Trippi\Controllers\CreateTripController', 'addAccommodationDetails'])->setName('addLocationAccommodations');


$app->get('/removeTrip/{tripId}/{email}', ['Trippi\Controllers\ProfileController', 'removeTrip'])->setName('trip.removeTrip');

$app->post('/delete_profile/{email}', ['Trippi\Controllers\ProfileController', 'delete_profile'])->setName('deleteProfile');

$app->post('/update_profile/{email}', ['Trippi\Controllers\ProfileController', 'update_profile'])->setName('updateProfile');





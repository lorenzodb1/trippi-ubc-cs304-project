<?php
/**
 * Created by PhpStorm.
 * User: samirmarin
 * Date: 2016-06-09
 * Time: 2:57 PM
 */


$app->get('/', ['Trippi\Controllers\HomeController', 'index'])->setName('home');

$app->post('/', ['Trippi\Controllers\HomeController', 'signIn'])->setName('signIn');

$app->get('/Trips', ['Trippi\Controllers\HomeController', 'signIn'])->setName('Trips.signIn');

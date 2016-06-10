<?php
/**
 * Created by PhpStorm.
 * User: samirmarin
 * Date: 2016-06-09
 * Time: 2:07 PM
 */
use Trippi\App;
use Illuminate\Database\Capsule\Manager as Capsule;

session_start();

require __DIR__ . '/../vendor/autoload.php';


$app = new App;

$capsule = new Capsule;

$capsule->addConnection([
    'driver' => 'mysql',

    'host' => 'localhost',

    'database' => 'DB_trippi',

    'username' => 'root',

    'password' => '',

    'charset' => 'utf8',

    'collation' => 'utf8_unicode_ci',
]);

$capsule->setAsGlobal();

$capsule->bootEloquent();

require __DIR__ . '/../app/routes.php';

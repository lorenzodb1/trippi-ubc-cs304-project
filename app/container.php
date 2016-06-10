<?php
/**
 * Created by PhpStorm.
 * User: samirmarin
 * Date: 2016-06-09
 * Time: 2:33 PM
 */

use Interop\Container\ContainerInterface;
use Trippi\Models\Trip;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use function DI\get;



Return [
    'router' => get(Slim\Router::class),

    Twig::class => function(ContainerInterface $c){

        $twig = new Twig(__DIR__ . '/../resources/view', [
            'cache' => false,
        ]);


        $twig->addExtension(new TwigExtension(
            $c->get('router'),
            $c->get('request')->getUri()
        ));
        return $twig;
    },

    Trip::class => function(ContainerInterface $c){
            return new Trip();
    }
];
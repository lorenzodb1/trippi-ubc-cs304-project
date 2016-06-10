<?php
/**
 * Created by PhpStorm.
 * User: samirmarin
 * Date: 2016-06-09
 * Time: 2:14 PM
 */
namespace Trippi;


use DI\ContainerBuilder;

use DI\Bridge\Slim\App as DiBridge;

Class App extends DIBridge{

    protected function configureContainer(ContainerBuilder $builder){
        $builder->addDefinitions([
            'settings.displayErrorDetails' => true,
        ]);

        $builder->addDefinitions(__DIR__ . '/container.php');
    }

}
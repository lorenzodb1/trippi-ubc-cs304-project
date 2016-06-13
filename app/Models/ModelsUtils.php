<?php

/**
 * Created by PhpStorm.
 * User: lorenzodb1
 * Date: 12/06/2016
 * Time: 8:49 PM
 */

namespace Trippi\Models;

/**
 * Class ModelsUtils contains all those methods and constants that we may need through all models
 */
class ModelsUtils {

    public function mysqlString($string){
        return '\'' . $string . '\'';
    }
}
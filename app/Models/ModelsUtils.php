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

    public function verifyEmail($email) {
        // Verify that email contains @
        $db = new Db();
        $query = "SELECT `email` 
              FROM `user` 
              WHERE `email` = " . $this->mysqlString($email);
        $result = $db->query($query);
        if( $result != false ) {
            // Successful Match
            return true;
        } else {
            // No match found
            return false;
        }
    }
}
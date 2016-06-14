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

    public static function mysqlString($string) {
        return '\'' . $string . '\'';
    }

    /*
     * Verify the email is part of the database
     */
    public static function verifyEmail($email) {
        // Verify that email contains @ and is correct format
        $db = new Db();
        $query = "SELECT `email` 
                  FROM `user` 
                  WHERE `email` = " . ModelsUtils::mysqlString($email);
        $result = $db->query($query);
        if( $result != false ) {
            return true;
        } else {
            return false;
        }
    }
}
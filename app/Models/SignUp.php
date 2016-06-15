<?php

/**
 * Created by PhpStorm.
 * User: lorenzodb1
 * Date: 2016-06-12
 * Time: 8:49 PM
 */

namespace Trippi\Models;

use mysqli;
use Trippi\Models\Db;

class SignUp {

    /*
     * function returns true or false whether the sign up was successful or not
     */

    public static function sign_up($username, $email, $password) {
        $db = new Db();
        $query = "INSERT INTO `user`(`username`, `email`, `password`)
                  VALUES (". ModelsUtils::mysqlstring($username) . "," . ModelsUtils::mysqlstring($email) . "," .
                          ModelsUtils::mysqlstring(crypt($password, '$6$rounds=5000$' . $email . '$')) . ")";
        $result = $db->query($query);
        return $result;
    }
}
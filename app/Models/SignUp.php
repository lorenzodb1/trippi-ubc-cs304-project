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

    public function sign_up($email, $password) {
        $db = new Db();
        $query = "INSERT INTO `user`(`email`,`password`)
                  VALUES (" . ModelsUtils::mysqlstring($email) . "," . ModelsUtils::mysqlstring($password) . ")";
        $result = $db->query($query);
        return $result;
    }
}
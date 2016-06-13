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
     * both function returns true or false whether the sign up was successful or not
     */

    public function sign_up($email, $password) {
        $db = new Db();
        $query = "INSERT INTO `user`(`email`,`password`)
                  VALUES (" . $email . "," . $password . ")";
        $result = $db->query($query);
        return $result;
    }

    public function create_profile($username, $name, $hometown, $country, $dateOfBirth, $aboutMe) {
        $db = new Db();
        $query = "INSERT INTO `user`(`username`,`name`,`hometown`,`country`,`dateOfBirth`, `aboutMe`)
                  VALUES (" . $username . "," . $name . "," . $hometown . "," . $country . "," . $dateOfBirth . "," . $aboutMe  . ")";
        $result = $db->query($query);
        return $result;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: lorenzodb1
 * Date: 12/06/2016
 * Time: 11:25 PM
 */

namespace Trippi\Models;

use mysqli;
use Trippi\Models\Db;
use Trippi\Models\ModelsUtils;

class Profile {

    /*
     * TODO: what should these functions return?
     */
    
    public static function create_profile($email, $password, $name, $hometown, $country, $dateOfBirth, $aboutMe) {
        $db = new Db();
        $query = "UPDATE `user`
                  SET `name` = " . ModelsUtils::mysqlstring($name) . ", 
                      `hometown` = " . ModelsUtils::mysqlstring($hometown) . ", `country` = " . ModelsUtils::mysqlstring($country) . ", 
                      `dateOfBirth` = " . ModelsUtils::mysqlstring($dateOfBirth) . ", `aboutMe` = " . ModelsUtils::mysqlstring($aboutMe) . " 
                  WHERE `email` = " . ModelsUtils::mysqlstring($email) . " AND 
                        `password` = " . ModelsUtils::mysqlstring(crypt($password, '$6$rounds=5000$' . $email . '$'));
        $result = $db->query($query);
        return $result;
    }

    public static function update_profile($email, $password, $data_type, $new_data) {
        $db = new Db();
        $query = "UPDATE `user`
                  SET " . ModelsUtils::mysqlstring($data_type) . " = " . ModelsUtils::mysqlstring($new_data) . " 
                  WHERE `email` = " . ModelsUtils::mysqlstring($email) . " AND 
                        `password` = " . ModelsUtils::mysqlstring(crypt($password, '$6$rounds=5000$' . $email . '$'));
        $result = $db->query($query);
        return $result;
    }

    public static function delete_profile($email, $password) {
        $db = new Db();
        $query = "DELETE FROM `user` 
                  WHERE `email` = " . ModelsUtils::mysqlstring($email) . " AND 
                        `password` = " . ModelsUtils::mysqlstring(crypt($password, '$6$rounds=5000$' . $email . '$'));
        $result = $db->query($query);
        return $result;
    }
}
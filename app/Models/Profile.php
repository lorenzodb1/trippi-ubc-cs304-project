<?php
/**
 * Created by PhpStorm.
 * User: Lorenzo
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
    
    public function create_profile($email, $username, $name, $hometown, $country, $dateOfBirth, $aboutMe) {
        $db = new Db();
        $query = "UPDATE `user`
                  SET `username` = " . ModelsUtils::mysqlstring($username) . ", `name` = " . ModelsUtils::mysqlstring($name) . ", 
                      `hometown` = " . ModelsUtils::mysqlstring($hometown) . ", `country` = " . ModelsUtils::mysqlstring($country) . ", 
                      `dateOfBirth` = " . ModelsUtils::mysqlstring($dateOfBirth) . ", `AboutMe` = " . ModelsUtils::mysqlstring($aboutMe) . " 
                  WHERE `email` = " . ModelsUtils::mysqlstring($email);
        $result = $db->query($query);
        return true;
    }

    public function update_profile($username, $password, $data_type, $new_data) {
        $db = new Db();
        $query = "UPDATE `user`
                  SET " . ModelsUtils::mysqlstring($data_type) . " = " . ModelsUtils::mysqlstring($new_data) . "
                  WHERE `username` = " . ModelsUtils::mysqlstring($username) . " AND `password` = " . ModelsUtils::mysqlstring($password);
        $result = $db->query($query);
        return true;
    }

    public function delete_profile($username, $password) {
        $db = new Db();
        $query = "DELETE FROM `user`
                  WHERE `username` = " . ModelsUtils::mysqlstring($username) . " AND `password` = " . ModelsUtils::mysqlstring(password);
        $result = $db->query($query);
        if($result) {
            return true;
        } else {
            return false;
        }
    }
}
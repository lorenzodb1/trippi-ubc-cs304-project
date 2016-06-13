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

class Profile {

    /*
     * TODO: what should these functions return?
     */
    
    public function create_profile($username, $name, $hometown, $country, $dateOfBirth, $aboutMe) {
        $db = new Db();
        $query = "INSERT INTO `user`(`username`,`name`,`hometown`,`country`,`dateOfBirth`, `aboutMe`)
                  VALUES (" . $username . "," . $name . "," . $hometown . "," . $country . "," . $dateOfBirth . "," . $aboutMe  . ")";
        $result = $db->query($query);
        return true;
    }

    public function update_profile($username, $password, $data_type, $new_data) {
        $db = new Db();
        $query = "UPDATE `user`
                  SET " . $data_type . " = " . $new_data . "
                  WHERE `username` = " . $username . " AND `password` = " . $password;
        $result = $db->query($query);
        return true;
    }

    public function delete_profile($username, $password) {
        $db = new Db();
        $query = "DELETE FROM `user`
                  WHERE `username` = " . $username . " AND `password` = " . $password;
        $result = $db->query($query);
        if($result) {
            return true;
        } else {
            return false;
        }
    }
}
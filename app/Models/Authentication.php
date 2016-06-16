<?php
/**
 * Created by PhpStorm.
 * User: samirmarin
 * Date: 2016-06-10
 * Time: 5:30 PM
 */
namespace Trippi\Models;
use mysqli;
use Trippi\Models\Db;
class Authentication{

    // Login
    // Called after verifyEmail, then if verified,
    // we check to ensure the password-email combination
    // matches, then they are authenticated and may
    // log in.
    // Return info associated with user (as an array) if email and password match, otherwise return false
    
    public function getUserInfo($email) {
        $db = new Db();
        $query = "SELECT `email`,`username`,`name`,`hometown`,`country`,`dateOfBirth`, `aboutMe`, `karma`, `rating` 
                  FROM `user` 
                  WHERE `email` = " . ModelsUtils::mysqlstring($email);
        $result = $db->query($query);
        if($result) {
            $rows = array();
            while($row = mysqli_fetch_array($result)) {
                $rows[] = $row;
            }
            return $rows;
        } else {
            // No match found
            return false;
        }
    }
    

  // Login
  // Called after verifyEmail, then if verified,
  // we check to ensure the password-email combination
  // matches, then they are authenticated and may
  // log in.
  // Return info associated with user (as an array) if email and password match, otherwise return false
  public static function login($email, $password) {
    $db = new Db();
    $query = "SELECT `email`,`username`,`name`,`hometown`,`country`,`dateOfBirth`, `aboutMe`, `rating`, `karma`
              FROM `user` 
              WHERE `email` = " . ModelsUtils::mysqlstring($email) . " AND 
                    `password`  = " . ModelsUtils::mysqlstring(crypt($password, '$6$rounds=5000$' . $email . '$'));
        $result = $db->query($query);
        if( $result != false ) {
            // Successful Match
            $rows = array();
            while($row = mysqli_fetch_array($result)) {
                $rows[] = $row;
            }
            return $rows;
        } else {
            // No match found
            return false;
        }
    }

    public static function userPlanTrip($email) {
        $db = new Db();
        $query = "SELECT t.tripId AS id, tripName, startDate AS 'from', endDate AS 'to' 
                  FROM trip t, plan p where t.tripId = p.tripId AND 
                       p.email = " . ModelsUtils::mysqlString($email);
        $result = $db->query($query);
        return $result;
    }
    public static function userJoinTrip($email) {
        $db = new Db();
        $query = "SELECT t.tripId AS id, tripName, startDate AS 'from', endDate AS 'to' 
                  FROM trip t, `joins` j 
                  WHERE t.tripId = j.tripId AND 
                        j.email = " . ModelsUtils::mysqlString($email);
        $result = $db->query($query);
        return $result;
    }
    
    public function getPassword($email) {
        $db = new Db();
        $query = "SELECT password 
                  FROM user 
                  WHERE 'email' = " . ModelsUtils::mysqlString($email);
        $result = $db->query($query);
        //return $result->fetch_object()->password;
        return $result;         // need to fix this
    }
     
}
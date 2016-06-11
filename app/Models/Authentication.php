<?php
/**
 * Created by PhpStorm.
 * User: samirmarin
 * Date: 2016-06-10
 * Time: 5:30 PM
 */
namespace Trippi\Models;

use mysqli;
use Models\Db;

class Authentication{
    // the database connection
    protected static $connection;


    /*
     * Verify the email is valid for login
     * This is undertaken after the user tries to log in.
     */
    public function verifyEmail($email) {
      // Verify that email contains @
      $db = new Db();

      $query = "SELECT `email` FROM `user` WHERE email='$email'";

      $result = $db->query($query);

      if( $result != false ) {
        // Successful Match
        return true;
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
    public function login($email, $password) {
      $db = new Db();
      $result = $db->query();


      $query = "SELECT `email`,`username`,`name`,`hometown`,`country`,`dateOfBirth` FROM `user` WHERE email='$email' AND password='$password'";

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


}
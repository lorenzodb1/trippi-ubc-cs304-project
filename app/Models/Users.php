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

class Users{

  /*
   * VANILLA USER SEARCH QUERIES
   */ 

  public function searchUserByUserName($userName) {
      $query = "SELECT `email`,`username`,`name`,`hometown`,`country`,`dateOfBirth`,`aboutMe`,`rating` FROM `user` WHERE username='$userName'";

      return returnResult( $this->submitQuery($query));
  }

  public function searchByUserEmail($email) {
      $query = "SELECT `email`,`username`,`name`,`hometown`,`country`,`dateOfBirth`,`aboutMe`,`rating` FROM `user` WHERE email='$email'";

      return returnResult( $this->submitQuery($query));  
  }

  public function searchByUserRating($rating) {
      $query = "SELECT `email`,`username`,`name`,`hometown`,`country`,`dateOfBirth`,`aboutMe`,`rating` FROM `user` WHERE rating='$rating'";

      return returnResult( $this->submitQuery($query));
  }

  public function searchByUserDOB($dob) {
      // TODO: Determine how DOB's are searched by day, year,
      // and look for members born in the same year

      $query = "SELECT `email`,`username`,`name`,`hometown`,`country`,`dateOfBirth`,`aboutMe`,`rating` FROM `user` WHERE dateOfBirth='$dob'";

      return returnResult( $this->submitQuery($query));
  }

  public function searchByUserLocation($country, $homeTown) {
      $query = "SELECT `email`,`username`,`name`,`hometown`,`country`,`dateOfBirth`,`aboutMe`,`rating` FROM `user` WHERE country='$country'";

      if( $homeTown ) {
        $query += " AND hometown='$homeTown'";
      }

      return returnResult( $this->submitQuery($query));
  }

  public function searchByUserName($name) {
      $query = "SELECT `email`,`username`,`name`,`hometown`,`country`,`dateOfBirth`,`aboutMe`,`rating` FROM `user` WHERE name LIKE '%$name%'";

      return returnResult( $this->submitQuery($query));
  }

  // member of trip

  public function returnMembersOfTrip($tripId) {
      $query = "SELECT * FROM `joins` j, `user` u WHERE u.email = j.email AND tripId='$tripId'";

      return returnResult( $this->submitQuery($query));
  }
    // visited location

  public function returnUsersTravelledTO() {

  }





 
    // travelling to
    // travelling to by date

    // participating in activity
      // by date


    // alll users who have been to location
    // all users who have done acivity
    // all users who have been to hotel
    // 


    // Helper function to setup DB connection, submit
    // query and return a result
    private function submitQuery(%query) {
      $db = new Db();

      return $db->query($query);
    }

    // Helper function for returning results into an
    // array
    private function returnResult( $result ) {
      if( $result ) {
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
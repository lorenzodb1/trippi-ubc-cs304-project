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
  /*
   * Verify the email is valid for login
   * This is undertaken after the user tries to log in.
   */
  public function verifyEmail($email) {
    // Verify that email contains @
    $db = new Db();
    $query = "SELECT `email` 
              FROM `user` 
              WHERE `email` = " . $this->mysqlString($email);
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
    $query = "SELECT `email`,`username`,`name`,`hometown`,`country`,`dateOfBirth`, `aboutMe` 
              FROM `user` 
              WHERE `email` = " .$this->mysqlString($email) . " AND `password`  = " . $this->mysqlString($password);
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
  
  private function mysqlString($string){
    return '\'' . $string . '\'';
  }

  /**
   * @param $email user email
   * @return mixed query of all trip info associated with the user.
   */
  public function userTrips($email){
    $db = new Db();
    $query = "SELECT t.tripId AS id, t.tripName AS tripName, t.startDate AS `from`, t.endDate AS `to` 
              FROM joins j, trip t 
              WHERE " . $this->mysqlString($email) . " = j.email AND j.tripId = t.tripId
              UNION
              SELECT t.tripId AS id, t.tripName AS tripName, t.startDate AS `from`, t.endDate AS `to` 
              FROM plan p, trip t 
              WHERE " . $this->mysqlString($email) . " = p.email AND p.tripId = t.tripId";
    //$query2 = "SELECT a.locationID, l.city, l.country, a.rating FROM accomodation a, location l WHERE a.locationID = l.locationID and a.rating > 2";
    $tripsHotelResult = $db->query($query);
    return $tripsHotelResult;
  }
}
<?php
/**
 * Created by PhpStorm.
 * User: giuliamattia
 * Date: 2016-06-13
 * Time: 7:03 PM
 */

namespace Trippi\Models;

class Activities {

    public function updateActivity( $city, $country, $activityName, $place, $cost, $date ) {
        $db = new Db();
        $query = "UPDATE `activity` 
                  SET `cost`=" . ModelsUtils::mysqlString($cost) .",`name`=" . ModelsUtils::mysqlString($activityName) . " 
                  WHERE `locationID` IN (SELECT `locationID` 
                                         FROM `location` 
                                         WHERE `city`=" . ModelsUtils::mysqlString($city) .  " AND 
                                               `country`=" . ModelsUtils::mysqlString($country) .  ") AND 
                                               `place`=" . ModelsUtils::mysqlString($place) .  " AND 
                                               `adate`=" . ModelsUtils::mysqlString($date);

        return $this->returnBoolResult( $this->submitQuery($query) );
    }

    public function addNewActivity( $locationID, $activityName, $place, $cost, $date ) {
      $query = "INSERT INTO `activity`(`name`, `place`, `adate`, `cost`, `locationID`) VALUES (" . ModelsUtils::mysqlString($activityName) .  "," . ModelsUtils::mysqlString($place) .  "," . ModelsUtils::mysqlString($date) .  "," . ModelsUtils::mysqlString($cost) .  "," . ModelsUtils::mysqlString($locationID) .  ")";
    
      return $this->returnBoolResult( $this->submitQuery($query) );
    }

    public function getActivityByKeys( $locationID, $name, $place ) {
      $query = "SELECT * 
                FROM `activity` 
                WHERE `name`=" . ModelsUtils::mysqlString($name) .  " AND 
                `place`=" . ModelsUtils::mysqlString($place) .  " AND 
                `locationID`=" . ModelsUtils::mysqlString($locationID) .  "";
    
      return $this->returnArrayResult( $this->submitQuery($query) );
    }

    private function submitQuery($query){
        $db = new Db();
        return $db->query($query);
    }

  // Helper function for returning results into an
  // array
  private function returnBoolResult( $result ) {
    return ($result) ? true : false;
  }

  private function returnArrayResult( $result ) {
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
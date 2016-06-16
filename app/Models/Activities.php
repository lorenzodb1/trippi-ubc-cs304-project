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

        return $this->returnResult( $this->submitQuery($query) );
    }

    private function submitQuery($query){
        $db = new Db();
        return $db->query($query);
    }

  // Helper function for returning results into an
  // array
  private function returnResult( $result ) {
    return ($result) ? true : false;
  }
}
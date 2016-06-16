<?php
/**
 * Created by PhpStorm.
 * User: giuliamattia
 * Date: 2016-06-13
 * Time: 7:03 PM
 */

namespace Trippi\Models;

class Location {

    public function getAlLocations() {
        $db = new Db();
        $query = "SELECT * 
                  FROM `location` 
                  ORDER BY `country` ASC";
        $query = "SELECT * FROM `location` ORDER BY `country` ASC";
        return $this->returnResult( $this->submitQuery($query));
    }

    public function getLocationIDWithParams( $city, $country ) {
      $query = "SELECT `locationID` 
                FROM `location` 
                WHERE `city`=" . ModelsUtils::mysqlstring( $city ) . " AND 
                      `country`=" . ModelsUtils::mysqlstring( $country );
    
      return $this->returnResult( $this->submitQuery( $query ) );
    }

    public function addLocation($id, $city, $country ) {

      $query = "INSERT INTO `location`(`locationID`, `city`, `country`) 
                VALUES (" . ModelsUtils::mysqlstring( $id ) . ",
                        " . ModelsUtils::mysqlstring( $city ) . ",
                        " . ModelsUtils::mysqlstring( $country ) .")";
      
      return $this->submitQuery( $query );
    }

    public function doesDurationExist( $startDate, $endDate ) {
      $query = "SELECT * 
                FROM `travelling_duration` 
                WHERE `startDate`=" . ModelsUtils::mysqlstring( $startDate ) . " AND 
                      `endDate`=" . ModelsUtils::mysqlstring( $endDate );
    
      return $this->returnResult( $this->submitQuery( $query ) );
    }

    public function addDuration( $startDate, $endDate, $duration ) {
      $query = "INSERT INTO `travelling_duration`(`startDate`, `endDate`, `duration`) 
                VALUES (" . ModelsUtils::mysqlstring( $startDate ) . ", 
                        " . ModelsUtils::mysqlstring( $endDate ) . ", 
                        " . ModelsUtils::mysqlstring( $duration ) . ")";
    
      return $this->submitQuery( $query );
    }

    public function addLocationToTrip($id, $tripId, $fromLocationId, $toLocationId, $type, $fromDate, $toDate ) {
      $cost = 100;

      $query = "INSERT INTO `travelling_transportation`(`transportationID`, `from_locationID`, `to_locationID`, 
                            `tripID`, `startDate`, `endDate`, `cost`, `type`) 
                VALUES (" . ModelsUtils::mysqlstring( $id ) . ",
                        " . ModelsUtils::mysqlstring( $fromLocationId ) . ", 
                        " . ModelsUtils::mysqlstring( $toLocationId ).  ", 
                        " . ModelsUtils::mysqlstring( $tripId ) . ", 
                        " . ModelsUtils::mysqlstring( $fromDate ) . ", 
                        " . ModelsUtils::mysqlstring( $toDate ) . ", 
                        " . ModelsUtils::mysqlstring( $cost ) . ", 
                        " . ModelsUtils::mysqlstring( $type ) . ")";
      var_dump($query);
      return $this->submitQuery( $query );
    }

    /*
     * Helpers
     */ 

    private function submitQuery($query){
        $db = new Db();

        return $db->query($query);
    }

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
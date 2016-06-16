<?php
/**
 * Created by PhpStorm.
 * User: giuliamattia
 * Date: 2016-06-13
 * Time: 7:03 PM
 */

namespace Trippi\Models;

class Accommodation {

    public function searchAccommodationByCostRange($minCost, $maxCost) {
        $db = new Db();
        $query = "SELECT `name`, `type`, `cost`, `rating` 
                  FROM `accomodation` 
                  WHERE `cost` >= " . ModelsUtils::mysqlString($minCost) ." AND 
                        `cost` <= " . ModelsUtils::mysqlString($maxCost);
        $result = $db->query($query);
        $rows = array();
        while ($row = mysqli_fetch_array($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function searchAccommodationByType($type) {
        $db = new Db();
        $query = "SELECT `name` 
                  FROM accomodation 
                  WHERE `type` = " . ModelsUtils::mysqlString($type);
        $result = $db->query($query);
        $rows = array();
        while ($row = mysqli_fetch_array($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function searchAccommodationByRatingOver($rating) {
        $db = new Db();
        $query = "SELECT `name`, `type`, `cost` 
                  FROM accomodation 
                  WHERE rating > " . ModelsUtils::mysqlString($rating);
        $result = $db->query($query);
        $rows = array();
        while ($row = mysqli_fetch_array($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function searchAccommodationByRatingEqual($rating) {
        $db = new Db();
        $query = "SELECT `name`, `type`, `cost` 
                  FROM accomodation 
                  WHERE rating = " . ModelsUtils::mysqlString($rating);
        $result = $db->query($query);
        $rows = array();
        while ($row = mysqli_fetch_array($result)) {
            $rows[] = $row;
        }
        return $rows;
    } 

    public function addNewAccommodation( $name, $type, $cost, $rating, $startDate, $endDate, $locationID ) {
        

        $query = "INSERT INTO `accomodation`(`name`, `type`, `cost`, `rating`, `startDate`, `endDate`, `locationID`) VALUES (" . ModelsUtils::mysqlstring( $name ) . "," . ModelsUtils::mysqlstring( $type ) . "," . ModelsUtils::mysqlstring( $cost ) . "," . ModelsUtils::mysqlstring( $rating ) . "," . ModelsUtils::mysqlstring( $startDate ) . "," . ModelsUtils::mysqlstring( $endDate ) . "," . ModelsUtils::mysqlstring( $locationID ) . ")";
        
        var_dump($query);
        
        return $this->submitQuery( $query );
    }  

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
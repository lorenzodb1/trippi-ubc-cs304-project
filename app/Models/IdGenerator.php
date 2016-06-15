<?php
/**
 * Created by PhpStorm.
 * User: giuliamattia
 * Date: 2016-06-13
 * Time: 4:19 PM
 */

namespace Trippi\Models;

use mysqli;

class IdGenerator {

    private function findMax() {
        $db = new Db();
        $query = "select max(tripID) AS tripID from trip";
        $result = $db->query($query);

        return $result->fetch_object()->tripID;

    }

    public function newTripID() {
        if($this->findMax())
            return $this->findMax() + 1;
        
        else return false;
    }

    //todo we should refactor to have one get max method if we have time
    private function findMaxLocationID() {
        $db = new Db();
        $query = "select max(locationID) AS locationID from location";
        $result = $db->query($query);

        return $result->fetch_object()->locationID;

    }
    
    private function findMaxTransportionionID(){
        $db = new Db();
        $query = "select max(trasportationID) AS transportationID from travelling_transportation";
        $result = $db->query($query);

        return $result->fetch_object()->locationID;
    }

    /**
     * only creates a new locationID in none exist else
     * returns the existing location Id for that city, country 
     * location Id
     */
    public function newLocationID($city, $country){
        $check = $this->getlocationID($city, $country);
        if(mysqli_num_rows($check) == 0){
            $db = new Db();
            $locationID = $this->findMaxLocationID() + 1;
            $queryInsert = "INSERT INTO location VALUES (" . ModelsUtils::mysqlString($locationID) . ","
                . ModelsUtils::mysqlString($city) . ","
                . ModelsUtils::mysqlString($country) . ")";

            $resultInsert = $db->query($queryInsert);
            if($resultInsert){
                return $locationID;
            }
            else{
                return false;
            }

        }
        else{
            return $check->fetch_object()->locationID;
        }
    }

    public function newTransportationId(){
        if($this->findMaxTransportionionID())
            return $this->findMaxTransportionionID() + 1;

        else return false;
    }

    private function getlocationID($city, $country){
        $db = new Db();
        $query = "SELECT l.locationID AS locationID
                  FROM location l 
                  WHERE l.city =" . ModelsUtils::mysqlString($city) . " AND
                        l.country =" . ModelsUtils::mysqlString($country);

        return $db->query($query);
    }





}

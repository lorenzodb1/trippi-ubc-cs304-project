<?php
/**
 * Created by PhpStorm.
 * User: giuliamattia
 * Date: 2016-06-13
 * Time: 4:36 PM
 */

namespace Trippi\Models;

class CreateTrip {
    
    public function createNewTrip($tripID, $startDate, $endDate, $tripName) {
        $db = new Db();


        if($this->createNewTripDuration($startDate, $endDate)) {
            $query = "INSERT INTO trip VALUES (" . $this->mysqlString($tripID) . " , " . $this->mysqlString($startDate) . ", " . $this->mysqlString($endDate) . ", 'incomplete', " . $this->mysqlString($tripName) . ", null )";
            $result = $db->query($query);
            return $result;
        }
    }

    public function createNewTripDuration($startDate, $endDate) {
        $db = new Db();
        $duration = $startDate - $endDate;
        $query = "INSERT INTO trip_duration VALUES (" . $this->mysqlString($startDate) ." , " . $this->mysqlString($endDate) .",  " . $this->mysqlString($duration) ." )";
        $result = $db->query($query);
        return $result;
    }

    public function linkTripPlanner($email, $tripID) {

        $this->dealWithAdminIssues($email);

        $db = new Db();

        $query = "INSERT INTO plan VALUES (" . $this->mysqlString($tripID) ." , " . $this->mysqlString($email) .")";
        $result = $db->query($query);
        return $result;
    }

    private function dealWithAdminIssues($email) {
        $db = new Db();
        $query = "SELECT *
                  FROM admin a
                  WHERE a.email =" . ModelsUtils::mysqlString($email);
        $result = $db->query($query);

        if(mysqli_num_rows($result) == 0) {
            $queryInsert = "INSERT INTO admin VALUES (" . ModelsUtils::mysqlString($email) . ")";
            $db->query($queryInsert);;
        }
    }

    private function insertNewTravelDuration($startDate, $endDate) {
        $db = new Db();
        $duration = $startDate - $endDate;
        $query = "INSERT INTO travelling_duration 
                  VALUES (" . ModelsUtils::mysqlString($startDate) ." , 
                          " . ModelsUtils::mysqlString($endDate) .",  
                          " . ModelsUtils::mysqlString($duration) ." )";
        $result = $db->query($query);
        return $result;
    }

    public function insertNewTravelTransportation($transportationID, $fromLocationID, $toLocationID, $tripId,
                                                   $startDate, $endDate, $type) {
        $db = new Db();

        $duration = $this->insertNewTravelDuration($startDate, $endDate);

        if($duration){
            $query = "INSERT INTO travelling_transportation 
                  VALUES (" . ModelsUtils::mysqlString($transportationID) ." , 
                          " . ModelsUtils::mysqlString($fromLocationID) .",  
                          " . ModelsUtils::mysqlString($toLocationID) .",  
                          " . ModelsUtils::mysqlString($tripId) .",  
                          " . ModelsUtils::mysqlString($startDate) .",  
                          " . ModelsUtils::mysqlString($endDate) .",
                            NULL, " . ModelsUtils::mysqlString($type) . ")";
            $result = $db->query($query);
            return $result;
        }
        else{
            return $duration;
        }


    }

    public function insertNewActivity($activity, $place, $date, $locationId) {
        $db = new Db();
        $query = "INSERT INTO activity 
                  VALUES (" . ModelsUtils::mysqlString($activity) ." ,
                          " . ModelsUtils::mysqlString($place) .",
                          " . ModelsUtils::mysqlString($date) .",
                             NULL,
                          " . ModelsUtils::mysqlString($locationId) .")";  

        $result = $db->query($query);
        return $result;
    }

    public function insertNewAccommodation($hotelName, $type, $startDate, $endDate, $locationId) {
        $db = new Db();
        $query = "INSERT INTO accomodation
                  VALUES (" . ModelsUtils::mysqlString($hotelName) ." ,
                         " . ModelsUtils::mysqlString($type) .",  
                             NULL, NULL,
                            " . ModelsUtils::mysqlString($startDate) .",  
                            " . ModelsUtils::mysqlString($endDate) .",  
                          " . ModelsUtils::mysqlString($locationId) .")";
        $result = $db->query($query);
        return $result;
    }
    
    public function addLocationDetails($city, $country){
        $generateID = new IdGenerator();
        $locationId = $generateID->newLocationId($city, $country);
        return $locationId;
    }

    /**@deprecated use the ModelUtils instead
     * @param $string
     * @return string
     */
    private function mysqlString($string){
        return '\'' . $string . '\'';
    }
}
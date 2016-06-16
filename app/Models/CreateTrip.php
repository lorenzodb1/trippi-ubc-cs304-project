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
        $query = "INSERT INTO travel_duration 
                  VALUES (" . ModelsUtils::mysqlString($startDate) ." , 
                          " . ModelsUtils::mysqlString($endDate) .",  
                          " . ModelsUtils::mysqlString($duration) ." )";
        $result = $db->query($query);
        return $result;
    }

    private function insertNewTravelTransportation($transportationID, $fromLocation, $toLocation, $tripId,
                                                    $startDate, $endDate) {
        $db = new Db();
        $query = "INSERT INTO travel_transportation 
                  VALUES (" . ModelsUtils::mysqlString($transportationID) ." , 
                          " . ModelsUtils::mysqlString($fromLocation) .",  
                          " . ModelsUtils::mysqlString($toLocation) .",  
                          " . ModelsUtils::mysqlString($tripId) .",  
                          " . ModelsUtils::mysqlString($startDate) .",  
                          " . ModelsUtils::mysqlString($endDate) .",  
                          NULL, NULL)";
        $result = $db->query($query);
        return $result;
    }

    private function insertNewActivity($activity, $locationId) {
        $db = new Db();
        $query = "INSERT INTO activity 
                  VALUES (" . ModelsUtils::mysqlString($activity) ." ,
                            NULL, NULL, NULL,
                          " . ModelsUtils::mysqlString($locationId) .")";  

        $result = $db->query($query);
        return $result;
    }

    private function insertNewAccomdation($hotelName, $startDate, $endDate, $locationId) {
        $db = new Db();
        $query = "INSERT INTO accomodation
                  VALUES (" . ModelsUtils::mysqlString($hotelName) ." ,
                            NULL, NULL, NULL,
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



    public function addTripDetails($fromCity, $fromCountry, $toCity, $toCountry,
                                    $transpStartDate, $transpEndDate, $tripId,
                                    $activityTo, $activityFrom, $hotelNameFrom, $hotelNameTo,
                                    $checkInFrom, $checkOutFrom, $checkInTo,
                                    $checkOutTo){
        $generateID = new IdGenerator();
        $locationIdFrom = $generateID->newLocationId($fromCity, $fromCountry);
        $locationIdTo = $generateID->newLocationId($toCity, $toCountry);
        
        if($locationIdFrom AND $locationIdTo){
            if($this->insertNewTravelDuration($transpStartDate, $transpEndDate)){
                $transportationID = $generateID->newTransportationId();
                if($this->insertNewTravelTransportation($transportationID, $locationIdFrom, $locationIdTo, $tripId,
                                                        $transpStartDate, $transpEndDate)){
                    if($this->insertNewActivity($activityFrom, $locationIdFrom) and
                        $this->insertNewActivity($activityTo, $locationIdTo)){
                        
                        if($this->insertNewAccomdation($hotelNameFrom, $checkInFrom, $checkOutFrom, $locationIdFrom) and
                           $this->insertNewAccomdation($hotelNameTo, $checkInTo, $checkOutTo, $locationIdTo)){
                            
                            return true;
                        }
                        else{
                            return true; //throw new \ErrorException("accommodation insertion not successful");
                        }

                    }
                    else{
                        return true; //throw new \ErrorException("activity insertion not successful");
                    }

                }
                else{
                    return true; //throw new \ErrorException(" travelTransportation insertion not successful");
                }
            }
            else{
                return true; //throw new \ErrorException("travel duration insertion not successful");
            }
        }
        else{
            return true; //throw new \ErrorException("LocationID's did not get inserted or obtain");
        }
    }
    /**@deprecated use the ModelUtils instead
     * @param $string
     * @return string
     */
    private function mysqlString($string){
        return '\'' . $string . '\'';
    }
}
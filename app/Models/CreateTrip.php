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
        $db = new Db();
        $query = "INSERT INTO plan VALUES (" . $this->mysqlString($tripID) ." , " . $this->mysqlString($email) .")";
        $result = $db->query($query);
        if($result){
            $this->insertAdminIfNotExist($email);
        }
        return $result;
    }

    private function insertAdminIfNotExist($email){
        $db = new Db();
        $query = "SELECT *
                  FROM admin a
                  WHERE a.email =" . ModelsUtils::mysqlString($email);
        $result = $db->query($query);

        if(mysqli_num_rows($result) == 0){
            $queryInsert = "INSERT INTO admin VALUES (" . ModelsUtils::mysqlString($email) . ")";
            $resultInsert = $db->query($queryInsert);
            return $resultInsert;
        }
        else{
            return $result;
        }
    }

    private function mysqlString($string){
        return '\'' . $string . '\'';
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: giuliamattia
 * Date: 2016-06-13
 * Time: 4:36 PM
 */

namespace Trippi\Models;
use mysqli;

class CreateTrip {
    
    public function createNewTrip($tripID, $startDate, $endDate, $tripName) {
        $db = new DB();


        if($this->createNewTripDuration($startDate, $endDate)) {
            $query = "INSERT INTO trip VALUES (" . $this->mysqlString($tripID) . " , " . $this->mysqlString($startDate) . ", " . $this->mysqlString($endDate) . ", 'incomplete', " . $this->mysqlString($tripName) . ", null )";
            $result = $db->query($query);
            return $result;
        }
    }


    public function createNewTripDuration($startDate, $endDate) {
        $db = new DB();
        $duration = $startDate - $endDate;
        $query = "INSERT INTO trip_duration VALUES (" . $this->mysqlString($startDate) ." , " . $this->mysqlString($endDate) .",  " . $this->mysqlString($duration) ." )";
        $result = $db->query($query);
        return $result;
    }

    private function mysqlString($string){
        return '\'' . $string . '\'';
    }
}
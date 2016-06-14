<?php
/**
 * Created by PhpStorm.
 * User: giuliamattia
 * Date: 2016-06-13
 * Time: 4:19 PM
 */

namespace Trippi\Models;

use mysqli;

class TripIDGenerator {

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


}

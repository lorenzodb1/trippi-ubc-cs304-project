<?php
/**
 * Created by PhpStorm.
 * User: giuliamattia
 * Date: 2016-06-14
 * Time: 8:29 PM
 */


namespace Trippi\Models;

class JoinTrip {

    public function joinTrip($tripId, $email) {
        $db = new Db();
        $query = "INSERT INTO joins VALUES (" . $this->mysqlString($tripId) . " , " . $this->mysqlString($email) .")";
        $result = $db->query($query);
        return $result;

    }


    private function mysqlString($string){
        return '\'' . $string . '\'';
    }
}
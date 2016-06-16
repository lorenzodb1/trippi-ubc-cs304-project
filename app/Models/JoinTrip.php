<?php
/**
 * Created by PhpStorm.
 * User: giuliamattia
 * Date: 2016-06-14
 * Time: 8:29 PM
 */


namespace Trippi\Models;

class JoinTrip {

    public static function joinTrip($tripId, $email) {
        $db = new Db();
        $query = "INSERT INTO joins VALUES (" . ModelsUtils::mysqlString($tripId) . ", " . ModelsUtils::mysqlString($email) .")";
        $result = $db->query($query);
        return $result;
    }
}
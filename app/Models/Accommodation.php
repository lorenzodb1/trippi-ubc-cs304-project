<?php
/**
 * Created by PhpStorm.
 * User: giuliamattia
 * Date: 2016-06-13
 * Time: 7:03 PM
 */

namespace Trippi\Models;

class Accommodation {

    private function mysqlString($string){
        return '\'' . $string . '\'';
    }

    public function searchAccommodationByCostRange($minCost, $maxCost) {
        $db = new Db();
        $query = "select name, type, cost, rating from accomodation where cost >= " . $this->mysqlString($minCost) ." AND cost <= " . $this->mysqlString($maxCost) ."";
        $result = $db->query($query);
        $rows = array();
        while ($row = mysqli_fetch_array($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function searchAccommodationByType($type) {
        $db = new Db();
        $query = "select name from accomodation where type " . $this->mysqlString($type) ."";
        $result = $db->query($query);
        $rows = array();
        while ($row = mysqli_fetch_array($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function searchAccommodationByRatingOver($rating) {
        $db = new Db();
        $query = "select name, type, cost from accomodation where rating > " . $this->mysqlString($rating) ." ";
        $result = $db->query($query);
        $rows = array();
        while ($row = mysqli_fetch_array($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function searchAccommodationByRatingEqual($rating) {
        $db = new Db();
        $query = "select name, type, cost from accomodation where rating = " . $this->mysqlString($rating) ." ";
        $result = $db->query($query);
        $rows = array();
        while ($row = mysqli_fetch_array($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    

}
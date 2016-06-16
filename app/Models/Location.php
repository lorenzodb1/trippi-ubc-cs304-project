<?php
/**
 * Created by PhpStorm.
 * User: giuliamattia
 * Date: 2016-06-13
 * Time: 7:03 PM
 */

namespace Trippi\Models;

class Location {

    private function mysqlString($string){
        return '\'' . $string . '\'';
    }

    public function getAlLocations() {
        $db = new Db();
        $query = "SELECT * 
                  FROM `location` 
                  ORDER BY `country` ASC";

            return $this->returnResult( $this->submitQuery($query));
    }

    private function submitQuery($query){
        $db = new Db();

        return $db->query($query);

    }

  // Helper function for returning results into an
  // array
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
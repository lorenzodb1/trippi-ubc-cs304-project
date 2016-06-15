<?php
/**
 * Created by PhpStorm.
 * User: lorenzodb1
 * Date: 14/06/2016
 * Time: 6:45 PM
 */

namespace Trippi\Models;

use mysqli;

class UserRating {

    public function add_rating($rater_email, $rated_email, $rating, $comment) {
        $db = new Db();
        $query = "INSERT INTO `userrating`(`emailRater`, `emailRated`, `rating`, `comment`)
                  VALUES (" . $rater_email . ", " . $rated_email . ", " . $rating . ", " . $comment . ")";
        $result = $db->query($query);
        return $result;
    }

    public function view_ratings($rated_email) {
        $db = new Db();
        $query = "SELECT *
                  FROM `userrating`
                  WHERE `emailRated` = " . $rated_email;
        $result = $db->query($query);
        $rows = array();
        while ($row = mysqli_fetch_array($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function view_ratings_by_highest($rated_email) {
        $db = new Db();
        $query = "SELECT * 
                  FROM `userrating` 
                  WHERE `emailRated` = " . $rated_email . " 
                  ORDER BY `rating` DESC";
        $result = $db->query($query);
        $rows = array();
        while ($row = mysqli_fetch_array($result)) {
            $rows[] = $row;
        }
        return $rows;
    }
}
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

    public static function add_rating($rater_email, $rated_email, $rating, $comment)
    {
        $db = new Db();
        $query = "INSERT INTO `userrating`(`emailRater`, `emailRated`, `rating`, `comment`)
                  VALUES (" . ModelsUtils::mysqlString($rater_email) . ", " . ModelsUtils::mysqlString($rated_email) . ", 
                          " . ModelsUtils::mysqlString($rating) . ", " . ModelsUtils::mysqlString($comment) . ")";
        $result = $db->query($query);
        return $result;
    }

    public static function view_ratings($rated_email)
    {
        $db = new Db();
        $query = "SELECT u2.username AS `username`, u2.email AS `email`, u2.name AS `rater`, ur.rating AS `rating`, ur.comment AS `comment`
                  FROM `userrating` ur, `user` u2
                  WHERE u2.email = ur.emailRater AND
	                    u2.email <> ur.emailRated AND
                        `emailRated` = " . ModelsUtils::mysqlString($rated_email);
        $result = $db->query($query);
        return $result;
    }

    public static function view_ratings_by_highest($rated_email)
    {
        $db = new Db();
        $query = "SELECT u2.username AS `username`, u2.email AS `email`, u2.name AS `rater`, ur.rating AS `rating`, ur.comment AS `comment`
                  FROM `userrating` ur, `user` u2
                  WHERE u2.email = ur.emailRater AND
	                    u2.email <> ur.emailRated AND
                        `emailRated` = " . ModelsUtils::mysqlString($rated_email) . " 
                  ORDER BY `rating` DESC";
        $result = $db->query($query);
        return $result;
    }
}
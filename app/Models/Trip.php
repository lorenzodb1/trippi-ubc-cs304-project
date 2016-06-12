<?php
/**
 * Created by PhpStorm.
 * User: samirmarin
 * Date: 2016-06-09
 * Time: 9:51 PM
 */
namespace Trippi\Models;
use mysqli;
use Trippi\Models\Db;


class Trip{

    /**
     * The table associated with the model.
     *
     * @var string
     */


    // this is an aggregation query
    // return array of tripID and rating
    public function searchMaxTripRating() {

        $db = new Db();

        $query = "SELECT tripId, rating FROM tripRating WHERE rating = (SELECT max(rating) from tripRating)";

        $result = $db->query($query);

        $rows = array();
        while($row = mysqli_fetch_array($result)) {
            $rows[] = $row;
        }
        return $rows;

    }


    // this is an aggregation query
    // return array of tripID and rating
    public function searchMinTripRating() {

        $db = new Db();

        $query = "SELECT tripId, rating FROM tripRating WHERE rating = (SELECT min(rating) from tripRating)";

        $result = $db->query($query);

        $rows = array();
        while($row = mysqli_fetch_array($result)) {
            $rows[] = $row;
        }
        return $rows;

    }


    // this is an aggregation query
    // return array of tripID and rating (ordered by rating in descending order)
    public function searchAvgTripRatingByTrip() {

        $db = new Db();

        $query = "SELECT tripID, avg(rating) FROM `tripRating` GROUP by tripID order by avg(rating) DESC";

        $result = $db->query($query);

        $rows = array();
        while($row = mysqli_fetch_array($result)) {
            $rows[] = $row;
        }
        return $rows;

    }


    // projection/selection query
    // return array of tripID
    public function searchIncompleteTrips() {

        $db = new Db();

        $query = "SELECT tripID FROM `trip` WHERE status = 'incomplete'";

        $result = $db->query($query);

        $rows = array();
        while($row = mysqli_fetch_array($result)) {
            $rows[] = $row;
        }
        return $rows;

    }

    // projection/selection query
    // return array of tripID
    public function searchCompleteTrips() {

        $db = new Db();

        $query = "SELECT tripID FROM `trip` WHERE status = 'complete'";

        $result = $db->query($query);

        $rows = array();
        while($row = mysqli_fetch_array($result)) {
            $rows[] = $row;
        }
        return $rows;

    }


    // projection/selection query
    // return names of all people who have joined a trip with a specified tripID
    public function searchUsersOnTrip($tripID) {

        $db = new Db();

        $query = "SELECT name FROM joins j, user u WHERE j.email = u.email AND tripId = '$tripID' ORDER BY name";

        $result = $db->query($query);

        $rows = array();
        while($row = mysqli_fetch_array($result)) {
            $rows[] = $row;
        }
        return $rows;

    }

    // projection/selection query
    // return tripIDs of trip with specified startLocation
    public function searchTripsByStartLocation($location) {

        $db = new Db();

        $query = "SELECT tripID FROM trip WHERE startLocation = '$location'";

        $result = $db->query($query);

        $rows = array();
        while($row = mysqli_fetch_array($result)) {
            $rows[] = $row;
        }
        return $rows;
    }


}
<?php
/**
 * Created by PhpStorm.
 * User: samirmarin
 * Date: 2016-06-09
 * Time: 9:51 PM
 */
namespace Trippi\Models;
use mysqli;
class Trip
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    // this is an aggregation query
    // return array of tripID and rating

    public function deleteTrip($tripId)
    {
        $db = new Db();
        $query = "DELETE FROM trip WHERE tripName = " . ModelsUtils::mysqlstring($tripId);
        $result = $db->query($query);
        return $result;
    }




    public function searchMaxTripRating()
    {
        $db = new Db();
        $query = "SELECT tripId, rating 
                  FROM tripRating 
                  WHERE rating = (SELECT MAX(rating) 
                                  FROM tripRating)";
        $result = $db->query($query);
        $rows = array();
        while ($row = mysqli_fetch_array($result)) {
            $rows[] = $row;
        }
        return $rows;
    }
    // this is an aggregation query
    // return array of tripID and rating
    public function searchMinTripRating()
    {
        $db = new Db();
        $query = "SELECT tripId, rating 
                  FROM tripRating 
                  WHERE rating = (SELECT MIN(rating) 
                                  FROM tripRating)";
        $result = $db->query($query);
        $rows = array();
        while ($row = mysqli_fetch_array($result)) {
            $rows[] = $row;
        }
        return $rows;
    }
    // this is an aggregation query
    // return array of tripID and rating (ordered by rating in descending order)
    public function searchAvgTripRatingByTrip()
    {
        $db = new Db();
        $query = "SELECT tripID, AVG(rating) 
                  FROM `tripRating` 
                  GROUP BY tripID 
                  ORDER BY AVG(rating) DESC";
        $result = $db->query($query);
        $rows = array();
        while ($row = mysqli_fetch_array($result)) {
            $rows[] = $row;
        }
        return $rows;
    }
    // projection/selection query
    // return array of tripID
    public function searchIncompleteTrips()
    {
        $db = new Db();
        $query = "SELECT tripID 
                  FROM `trip` 
                  WHERE status = " . ModelsUtils::mysqlstring('incomplete');
        $result = $db->query($query);
        $rows = array();
        while ($row = mysqli_fetch_array($result)) {
            $rows[] = $row;
        }
        return $rows;
    }
    // projection/selection query
    // return array of tripID
    public function searchCompleteTrips()
    {
        $db = new Db();
        $query = "SELECT tripID 
                  FROM `trip` 
                  WHERE status = " . ModelsUtils::mysqlstring('complete');
        $result = $db->query($query);
        $rows = array();
        while ($row = mysqli_fetch_array($result)) {
            $rows[] = $row;
        }
        return $rows;
    }
    // projection/selection query
    // return names of all people who have joined a trip with a specified tripID
    public function searchUsersOnTrip($tripID)
    {
        $db = new Db();
        $query = "SELECT DISTINCT u.name AS `name`, u.username AS userName 
                  FROM joins j, `user` u 
                  WHERE (j.email = u.email AND 
                        j.tripId =" . ModelsUtils::mysqlString($tripID) .")
                  UNION
                  SELECT DISTINCT u.name AS `name`, u.username AS userName 
                  FROM admin a, plan p, `user` u 
                  WHERE (p.email = a.email AND
                         a.email = u.email AND
                        p.tripId =" . ModelsUtils::mysqlString($tripID) .")";
        $result = $db->query($query);
        $rows = array();
        while ($row = mysqli_fetch_array($result)) {
            $rows[] = $row;
        }
        return $rows;
    }
    // projection/selection query
    // return tripIDs of trip with specified startLocation
    public function searchTripsByStartLocation($location)
    {
        $db = new Db();
        $query = "SELECT tripID 
                  FROM trip 
                  WHERE startLocation = " . ModelsUtils::mysqlstring($location);
        $result = $db->query($query);
        $rows = array();
        while ($row = mysqli_fetch_array($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    private function mysqlString($string){
        return '\'' . $string . '\'';
    }

    public function getLocationsByTripId($tripId){
        $db = new Db();

        $query = "SELECT l.city AS city,
                         l.country AS country
                  FROM location l, travelling_transportation t
                  WHERE (l.locationID = t.from_locationID or 
                        l.locationID = t.to_locationID) AND" .
                         $this->mysqlString($tripId) . " = 
                        t.tripID";

        $result = $db->query($query);
        return $result;
    }

    public function getTravelingInformationByTripId($tripId){
        $db = new Db();

        $query = "SELECT l1.city AS fromCity,
                         l1.country AS fromCountry,
                         l2.city AS toCity,
                         l2.country AS toCountry,
                         t.type AS typeTravel,
                         t.startDate AS fromDate,
                         t.endDate AS toDate
                  FROM location l1, location l2, travelling_transportation t
                  WHERE l1.locationID = t.from_locationID AND 
                        l2.locationID = t.to_locationID AND" .
                        $this->mysqlString($tripId) . "= t.tripID";

        $result = $db->query($query);

        return $result;
    }

    public function getActivitiesByTripId($tripId){
        $db = new Db();

        $query = "SELECT l.city AS city,
                         l.country AS country,
                         a.name AS activityName,
                         a.place AS activityPlace,
                         a.adate AS `date`
                  FROM location l, travelling_transportation t, activity a
                  WHERE ((l.locationID = t.from_locationID) AND" .
                        $this->mysqlString($tripId) . " = 
                        t.tripID AND
                        (a.locationID = t.from_locationID)) or
                        ((l.locationID = t.to_locationID) AND" .
            $this->mysqlString($tripId) . " = 
                        t.tripID AND
                        (a.locationID = t.to_locationID))";

        $result = $db->query($query);
        return $result;

    }

    public function getAccomodationsByTripId($tripId){
        $db = new Db();

        $query = "SELECT l.city AS city,
                         l.country AS country,
                         a.name AS `name`,
                         a.type AS `type`,
                         a.rating AS rating,
                         a.startDate AS `from`,
                         a.endDate AS `to`
                  FROM location l, travelling_transportation t, accomodation a
                  WHERE ((l.locationID = t.from_locationID) AND" .
                        $this->mysqlString($tripId) . " = 
                        t.tripID AND
                        (a.locationID = t.from_locationID)) or
                        ((l.locationID = t.to_locationID) AND" .
            $this->mysqlString($tripId) . " = 
                        t.tripID AND
                        (a.locationID = t.to_locationID))";

        $result = $db->query($query);
        return $result;
    }
    public function getTripNameById($tripId)
    {
        $db = new Db();

        $query = "SELECT t.tripName AS tripName
                  FROM trip t
                  WHERE t.tripId =" . $this->mysqlString($tripId);

        $result = $db->query($query);
        return $result;
    }

    // return tripIDs of trip with duration equal to specified duration
    public function searchTripsByEqualDuration($duration) {

        $db = new Db();

        $query = "SELECT tripID FROM trip t, trip_duration d WHERE t.startDate = d.startDate AND t.endDate = d.endDate AND duration = '$duration''";

        $result = $db->query($query);

        $rows = array();
        while($row = mysqli_fetch_array($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    // return tripIDs of trip with duration greater than specified duration
    public function searchTripsByGreaterDuration($duration) {

        $db = new Db();

        $query = "SELECT tripID FROM trip t, trip_duration d WHERE t.startDate = d.startDate AND t.endDate = d.endDate AND duration > '$duration''";

        $result = $db->query($query);

        $rows = array();
        while($row = mysqli_fetch_array($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    // return tripIDs of trip with duration less than specified duration
    public function searchTripsByLesserDuration($duration) {

        $db = new Db();

        $query = "SELECT tripID FROM trip t, trip_duration d WHERE t.startDate = d.startDate AND t.endDate = d.endDate AND duration < '$duration''";

        $result = $db->query($query);

        $rows = array();
        while($row = mysqli_fetch_array($result)) {
            $rows[] = $row;
        }
        return $rows;
    }



}
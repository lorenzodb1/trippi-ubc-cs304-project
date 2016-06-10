<?php
/**
 * Created by PhpStorm.
 * User: samirmarin
 * Date: 2016-06-03
 * Time: 2:44 PM
 */

$host="localhost";
$user="root";
$password="";
$dataBaseName = "DB_trippi";

$connect = mysqli_connect($host, $user, $password, $dataBaseName);
$query = "SELECT a.locationID, l.city, l.country, a.rating FROM accomodation a, location l WHERE a.locationID = l.locationID and a.rating > 2";
$result = mysqli_query($connect, $query);
while($row = mysqli_fetch_array($result)){
    echo "$row[0], $row[1],$row[2], $row[3]<br>";
}

mysqli_free_result($result);
mysqli_close($connect);
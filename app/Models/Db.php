<?php
/**
 * Created by PhpStorm.
 * User: samirmarin
 * Date: 2016-06-10
 * Time: 5:30 PM
 */
namespace Trippi\Models;

use mysqli;

class Db{
    // the database connection
    protected static $connection;

    /**
     * connects to the database
     * @return if fails returns false else mysqli object on success
     */
    public function connect(){
        if(!isset(self::$connection)) {
            $config = parse_ini_file(realpath('../configurations/config.ini'));
            self::$connection = new mysqli('localhost',$config['username'],$config['password'],$config['dbname']);
        }
        if(self::$connection === false) {
            return false;
        }
        return self::$connection;
    }

    /**
     * Query the database
     *
     * @param $query The query string
     * @return mixed The result of the mysqli::query() function
     */
    public function query($query) {
        $connection = $this -> connect();

        $result = $connection-> query ($query);

        return $result;
    }

}
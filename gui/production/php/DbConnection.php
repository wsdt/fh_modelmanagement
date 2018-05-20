<?php

include 'User.php'; //optional because only needed in insertDefaultData();

/** Used PDO instead of mysqli so it should be easier to transfer
 * this to other dbms. */
class DbConnection
{
    private static $dbServername = "localhost";
    private static $dbName = "fhkufsteinmodels";
    private static $dbUsername = "root";
    private static $dbPassword = "";

    private static $dbConnection = null;

    /** DEFAULT DATA INSERTION (Delete in production mode)
     This method get's only called on database creation! */
    private function insertDefaultData() {
        $dbCon = $this->getDbConnection(true);

        $salt = "dsf6sd4f5sd4f65sd4f5";
        (new User(15654,'test',User::hashPassword('12345',$salt),$salt))->dbReplace($dbCon);
    }


    //Do not use these methods if database does not exist
    public function exec($sql)
    {
        DbConnection::getDbConnection(true)->exec($sql);
    }

    public function query($sql)
    {
        return DbConnection::getDbConnection(true)->query($sql);
    }


    // #################################################################################
    public function __construct()
    {
        $this->getDbConnection(false)->exec("CREATE DATABASE IF NOT EXISTS " . DbConnection::$dbName . ";");
        $this->exec("USE " . DbConnection::$dbName . ";");
        $this->exec("CREATE TABLE IF NOT EXISTS User (
            usr_id INT PRIMARY KEY,
            usr_username VARCHAR(100) NOT NULL,
            usr_hashedpassword VARCHAR(250) NOT NULL, 
            usr_salt VARCHAR(250) NOT NULL,
            UNIQUE (usr_username)
        );");

        $this->closeConnection();
    }

    //Private because only used in getDbConnection()
    private function establishConnection($doesDatabaseExist)
    {
        try {
            $conn = new PDO("mysql:host=" . DbConnection::$dbServername .
                (($doesDatabaseExist) ? ";dbname=" . DbConnection::$dbName : ""),
                DbConnection::$dbUsername, DbConnection::$dbPassword);

            // set error mode to exception so we can react to it with try catch
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //connection successful

            //if db hasn't existed before, we will insert our default data
            if (!$doesDatabaseExist) {
                $this->insertDefaultData();
            }

            return $conn;
        } catch (PDOException $e) {
            die("<p>Could not establish dbConnection: " . $e->getMessage() . "</p>");
        }
    }

    private static function closeConnection()
    {
        DbConnection::$dbConnection = null;
    }

    //Close dbConnection on object destroy
    function __destruct()
    {
        $this->closeConnection();
    }

    //GETTER/SETTER -------------------------
    //MUST NOT BE STATIC TO force constr to be called
    public function getDbConnection($doesDatabaseExist)
    {
        if (DbConnection::$dbConnection == null) {
            DbConnection::$dbConnection = $this->establishConnection($doesDatabaseExist);
        }
        return DbConnection::$dbConnection;
    }

}
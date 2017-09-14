<?php


//print_r("database class included <br>"); //this will break other pages using headers - testing only

date_default_timezone_set('Europe/London');
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set("display_errors", 1);

/**
 * Class Database
 *
 * HOW TO INSERT A RECORD
 * 1) Create a new instance of Database class:
 * $database = new Database();
 *
 * 2) Define your INSERT query:
 * $database->query('INSERT INTO mytable (FName, LName, Age, Gender) VALUES (:fname, :lname, :age, :gender)');
 *a
 * 3)Bind data to the placeholders above (for example :fname)
 * $database->bind(':fname', 'John');
 *
 * 4) Execute!
 * $database->execute();
 */


//http://culttt.com/2012/10/01/roll-your-own-pdo-php-class/

//SETTINGS
//set the URL/directory that the blog will be found at - this is used throughout for redirects etc
$blogUrl = 'careers';

//set the base url of the website
$siteUrl = "http://nottsymca.com";



class Database
{

//    private $host = 'localhost'; //local connection
//    private $user = 'roxy';
//    private $pass = 'sero73672';
//    private $dbname = 'siteTemplate_demoDB';


    private $host = 'localhost'; // phpmyadmin database host
    private $user = 'mprit187_dynamic'; // phpmyadmin database user
    private $pass = 'DWrlC*NMHGMN'; // phpmyadmin database password
    private $dbname = 'mprit187_dynamic_pages'; // phpmyadmin database name


    private $dbh;
    private $error;
    private $stmt;

    public function __construct()
    {
        // Set DSN
        $dsn = 'mysql:host=' . $this->host . ';port=' . $this->port . ';dbname=' . $this->dbname;

        // Set options
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        // Create a new PDO instanace
        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } // Catch any errors
        catch (PDOException $e) {
            $this->error = $e->getMessage();
        }
    }

    public function query($query)
    {
        $this->stmt = $this->dbh->prepare($query);
    }

    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    public function execute()
    {
        return $this->stmt->execute();
    }

    public function resultset()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Fetch a SINGLE row
     *
     * @return mixed
     */
    public function single()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get the number of rows returned
     *
     * @return mixed
     */
    public function rowCount()
    {
        return $this->stmt->rowCount();
    }

    public function lastInsertId()
    {
        return $this->dbh->lastInsertId();
    }

    /**
     * For debugging
     *
     * @return mixed
     */
    public function debugDumpParams()
    {
        return $this->stmt->debugDumpParams();
    }
}


//include the custom functions file // make sure thing link is correct!
$path = $_SERVER['DOCUMENT_ROOT']; $path .= "/". $blogUrl ."/admin/_functions.php"; include_once($path);

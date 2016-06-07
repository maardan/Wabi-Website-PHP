<?php

include_once 'User.php';
include_once 'Asset.php';
include_once 'Purchase.php';

date_default_timezone_set("America/Los_Angeles");

/*
    Database Connection singleton class.
    Should not be used directly, make data requests instead through DatabaseHelper.
    Taken from: https://gist.github.com/jonashansen229/4534794
*/
    class Database {

        private $_connection;
    private static $_instance; //The single instance
    private $_host = "localhost";
    private $_username = "s16g08";
    private $_password = "midnightnative";
    private $_database = "student_s16g08";
    /*
    Get an instance of the Database
    @return Instance
    */
    public static function getInstance() {
        if(!self::$_instance) { // If no instance then make one
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    // Constructor
    private function __construct() {
        $this->_connection = new mysqli($this->_host, $this->_username, 
            $this->_password, $this->_database);

        // Error handling
        if(mysqli_connect_error()) {
            trigger_error("Failed to conenect to database: " . mysql_connect_error(),
             E_USER_ERROR);
        }
    }
    // Magic method clone is empty to prevent duplication of connection
    private function __clone() { }
    // Get mysqli connection
    public function getConnection() {
        return $this->_connection;
    }
}

/*
 *  Database helper class interfacing with the Database.
*/
class DatabaseRequest {

    private $dbSingleton;
    private $conn;

    public function __construct() {
        $this->dbSingleton = Database::getInstance();
        $this->conn = $this->dbSingleton->getConnection();
    }

    public function getAssetData($id) {
        $query = "select * from wa_asset where id = $id";
        $result = $this->conn->query($query);

        $assetObj = new Asset($result);

        return $assetObj;
    }

    public function getUserData($email) {
        $query = "select * from wa_user where email ='$email';";
        $result = $this->conn->query($query);
        if(!empty($result)){ 
            $userObj = new User($result);

            return $userObj;
        } else {
            return null;
        }
    }

    public function getUserDataFromId($id) {
        $query = "select * from wa_user where id = $id;";
        $result = $this->conn->query($query);

        $userObj = new User($result);

        return $userObj;
    }

    public function getFeaturedArtist() {
        $query = "select * from wa_featured_artist where active = 1 limit 1;";
        $result = $this->conn->query($query);
        $result = $result->fetch_assoc();
        return $result['user_id'];  
    }

    public function getRandomFeaturedImage($user_id) {
        $query = "select id from wa_asset where user_id = $user_id order by rand() limit 1;";
        $result = $this->conn->query($query);
        $result = $result->fetch_assoc();
        return $result['id'];
    }

    public function findAssets($key) {
        $key = $this->conn->real_escape_string($key);
        $regex = "^$key| $key";

        $result = $this->conn->query("(select * from wa_asset where title regexp '$regex' and disabled = 0) or (description regexp '([[[:blank:][:punct:]]|^)$key([[:blank:][:punct:]]|$)' and disabled = 0);");

        $assets = array(); 
        $rows = $result->num_rows;

        for ($x = 0; $x < $rows; $x++) {
            $assets[] = new Asset($result);    
        }

        return $assets;  
    }
    
    public function getPurchaseData($user_id) {
        $query = "select * from wa_purchase where user_id = $user_id";
        $result = $this->conn->query($query);
        $purchases = array();

        while($row = $result->fetch_assoc()){
            $purchases[] = new Purchase($row);
        }

        return $purchases; 
    }

    public function getArtistAssets($user_id, $limit=1) {
        $query = "select * from wa_asset where user_id = $user_id and disabled = 0 order by created desc limit $limit;";
        $result = $this->conn->query($query);
        $assets = array();

        $rows = $result->num_rows;

        for ($x = 0; $x < $rows; $x++) {
            $assets[] = new Asset($result);    
        }

        return $assets;     
    }
    
    
    public function getArtistEarnings($user_id) {
        
        $start_time_unix = strtotime("midnight");
        $end_time_unix = strtotime("midnight") + 86400; 
        $earnings = array();
        
        
        for ($x = 7; $x >= 0; $x--) {
              
            $start_time = date ("Y-m-d H:i:s", $start_time_unix - ($x * 86400));
            $end_time = date ("Y-m-d H:i:s", $end_time_unix - ($x * 86400));

            $query = "select sum(amount) 'amount' from wa_purchase where created between '$start_time' and '$end_time'
                        and asset_id in (select id from wa_asset where user_id = $user_id);";
            $result = $this->conn->query($query);
            
            $row = $result->fetch_assoc(); 
                   
            $earnings[] = array("date"=>substr($start_time,5,5), "amount"=>($row["amount"]==NULL ? "0" : $row["amount"]));
              
        }
        
	    return $earnings;
        
    }
    
    
    
    /* WRITE METHODS */
    
    public function addNewUser($type, $email, $password, $first_name, $last_name) { 
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->conn->prepare("insert into wa_user (type, email, password_hash, first_name, last_name) values (?,?,?,?,?)");
        $stmt->bind_param("issss", $type, $email, $password_hash, $first_name, $last_name);
        $stmt->execute();

        if ($stmt->error) {
            return false;
        } else {
            return true;
        }
    }

    //DatabaseRequest->purchase(111, 111, 'U', 10000); to buy picture
    public function purchase($user_id, $asset_id, $license_type, $amount) {
        $query = "insert into wa_purchase (user_id, asset_id, license_type, amount, created) values (?, ?, ?, ?, ?);";
        date_default_timezone_set('PST');

        $timestamp = date('Y-m-d G:i:s');

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iisds", $user_id, $asset_id, $license_type, $amount, $timestamp);
        $stmt->execute();

        if ($stmt->error) {
            return $stmt->error;

        } else {
            return true;
        }
    }

    //$DatabaseRequest->signup(3, 'lala@email.com', "qweqweqweq", "k", "s");
    public function signup($account_type, $username, $password_hash, $first_name, $last_name, $profile_pic, $bio, $link) {
        $query = "insert into wa_user (type, email, password_hash, first_name, last_name, profile_photo, biography, disabled, created, personal_link) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
        date_default_timezone_set('GMT');

        $timestamp = date('Y-m-d G:i:s');
        $test = 0;
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("issssssiss", $account_type, $username, $password_hash, $first_name, $last_name, $profile_pic, $bio, $test, $timestamp, $link);
        $stmt->execute();

        if ($stmt->error) {
            return $stmt->error;

        } else {
            return true;
        }
    }

    public function addAsset($user, $type, $title, $description, $thumb_url, $original_url, $web_price, $print_price, $unlimited_price) {
        $query = "insert into wa_asset (user_id, type, title, description, thumb_url, original_url, web_price, print_price, unlimited_price, created) values (?,?,?,?,?,?,?,?,?,NOW());";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iissssddd", $user, $type, $title, $description, $thumb_url, $original_url, $web_price, $print_price, $unlimited_price);
        $stmt->execute();

        if ($stmt->error) {
            return $stmt->error;
        } else {
            return true;
        }
    }

    public function disableAsset($user_id, $asset_id) {             
        $stmt = $this->conn->prepare("update wa_asset set disabled = 1 where user_id = ? and id = ?;");
        $stmt->bind_param("ii", $user_id, $asset_id);
        $stmt->execute();
        
        return $stmt->affected_rows;
        
        
    }
    
    public function updateProfilePhoto($profile_photo, $user_id) {
        $query = "update wa_user set profile_photo=? where id=?;";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $profile_photo, $user_id);
        $stmt->execute();

        if ($stmt->error) {
            return $stmt->error;
        } else {
            return true;
        }
    }    

    public function updateProfileBio($biography, $user_id) {
        $query = "update wa_user set biography=? where id=?;";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $biography, $user_id);
        $stmt->execute();

        if ($stmt->error) {
            return $stmt->error;
        } else {
            return true;
        }
    }   
    
    public function updateProfileLink($personal_link, $user_id) {
        $query = "update wa_user set personal_link=? where id=?;";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $personal_link, $user_id);
        $stmt->execute();

        if ($stmt->error) {
            return $stmt->error;
        } else {
            return true;
        }
    }       

    public function updateFirstName($first_name, $user_id) {
        $query = "update wa_user set first_name=? where id=?;";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $first_name, $user_id);
        $stmt->execute();

        if ($stmt->error) {
            return $stmt->error;
        } else {
            return true;
        }
    }       

    public function updateLastName($last_name, $user_id) {
        $query = "update wa_user set last_name=? where id=?;";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $last_name, $user_id);
        $stmt->execute();

        if ($stmt->error) {
            return $stmt->error;
        } else {
            return true;
        }
    }
    
    public function updateTitle($title, $id, $user_id) {
        $query = "update wa_asset set title=? where id=? and user_id=?;";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sii", $title, $id, $user_id);
        $stmt->execute();

        if ($stmt->error) {
            return $stmt->error;
        } else {
            return true;
        }
    }    
    
    public function updateDescription($description, $id, $user_id) {
        $query = "update wa_asset set description=? where id=? and user_id=?;";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sii", $description, $id, $user_id);
        $stmt->execute();

        if ($stmt->error) {
            return $stmt->error;
        } else {
            return true;
        }
    }
    
    public function updateWebPrice($web_price, $id, $user_id) {
        $query = "update wa_asset set web_price=? where id=? and user_id=?;";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("dii", $web_price, $id, $user_id);
        $stmt->execute();

        if ($stmt->error) {
            return $stmt->error;
        } else {
            return true;
        }
    }    

    public function updatePrintPrice($print_price, $id, $user_id) {
        $query = "update wa_asset set print_price=? where id=? and user_id=?;";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("dii", $print_price, $id, $user_id);
        $stmt->execute();

        if ($stmt->error) {
            return $stmt->error;
        } else {
            return true;
        }
    }    

    public function updateUnlimitedPrice($unlimited_price, $id, $user_id) {
        $query = "update wa_asset set unlimited_price=? where id=? and user_id=?;";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("dii", $unlimited_price, $id, $user_id);
        $stmt->execute();

        if ($stmt->error) {
            return $stmt->error;
        } else {
            return true;
        }
    }        
    
    public function updateAssetImage($thumb_url, $original_url, $id, $user_id) {
        $query = "update wa_asset set thumb_url=?, original_url=? where id=? and user_id=?;";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssii", $thumb_url, $original_url, $id, $user_id);
        $stmt->execute();

        if ($stmt->error) {
            return $stmt->error;
        } else {
            return true;
        }
    }   
    
    public function updateAssetVideo($original_url, $id, $user_id) {
        $query = "update wa_asset set original_url=? where id=? and user_id=?;";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sii", $original_url, $id, $user_id);
        $stmt->execute();

        if ($stmt->error) {
            return $stmt->error;
        } else {
            return true;
        }
    }          
    
}

<?php

class User {

    private $user_id = '';
    private $user_type = '';
    private $user_email = '';
    private $user_password_hash = '';
    private $user_firstname = '';
    private $user_lastname = '';
    private $user_profilephoto = '';
    private $user_biography = '';
    private $user_personallink = '';

    function __construct($resultJson) {

        //{"id":"2","type":"2","email":"artist@wabi.com","password_hash":"$2y$10$mn2dbWpxGzwl6j0jOaKBDear7pKH7qI7pLA6KMAwngZ.ZK3DkY1iy","first_name":"Sarah","last_name":"Artist","disabled":"0","created":"2016-04-07 10:58:07", "peronal_link":"www.google.com"}
        if($results = $resultJson->fetch_array()) {
            $result_array[] = $results;
        }

        if (isset($result_array)) {
            $this->user_id = $result_array[0]['id'];
            $this->user_type = $result_array[0]['type'];
            $this->user_email = $result_array[0]['email'];
            $this->user_password_hash = $result_array[0]['password_hash'];
            $this->user_firstname = $result_array[0]['first_name'];
            $this->user_lastname = $result_array[0]['last_name'];
            $this->user_profilephoto = $result_array[0]['profile_photo'];
            $this->user_biography = $result_array[0]['biography'];
            $this->user_personallink = $result_array[0]['personal_link'];
        }
    }

    function getUserId() {
        return $this->user_id;
    }

    function getUserType() {
        return $this->user_type;
    }

    function getUserEmail() {
        return $this->user_email;
    }

    function getUserPassword() {
        return $this->user_password_hash;
    }

    function getUserFirstName() {
        return $this->user_firstname;
    }

    function getUserLastName() {
        return $this->user_lastname;
    }
    
    function getUserProfilePhoto() {
        return $this->user_profilephoto;
    }
    
    function getUserBiography() {
        return $this->user_biography;
    }
    
    function getUserPersonalLink() {
        return $this->user_personallink;
    }
}

?>
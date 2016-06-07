<?php

class Asset {
    
    private $id = '';
    private $user_id = '';
    private $type = '';
    private $title = '';
    private $description = '';
    private $thumb_url = '';
    private $original_url = '';
    private $created = '';
    private $web_price = '';
    private $print_price = '';
    private $unlimited_price = '';
    private $disabled = '';
    
    function __construct($resultJson) {
        
        if ($results = $resultJson->fetch_array()) {
            $result_array[] = $results;  
        }
        
        if (isset($result_array)) {
            $this->id = $result_array[0]['id'];
            $this->user_id = $result_array[0]['user_id'];
            $this->type = $result_array[0]['type'];
            $this->title = $result_array[0]['title'];
            $this->description = $result_array[0]['description'];
            $this->thumb_url = $result_array[0]['thumb_url'];
            $this->original_url = $result_array[0]['original_url'];
            $this->web_price = $result_array[0]['web_price'];
            $this->print_price = $result_array[0]['print_price'];
            $this->unlimited_price = $result_array[0]['unlimited_price'];
            $this->created = $result_array[0]['created'];
            $this->disabled = $result_array[0]['disabled'];
        }   
            
    }
    
    function getId() {
        return $this->id;
    }
    
    function getUserId() {
        return $this->user_id;
    }

    function getType() {
        return $this->type;
    }
    
    function getTitle() {
        return $this->title;
    }
    
    function getDescription() {
        return $this->description;
    }
    
    function getThumbURL() {
        return $this->thumb_url;
    }
    
    function getOriginalURL() {
        return $this->original_url;
    }
    
    function getCreated() {
        return $this->created;
    }
    
    function getWebPrice() {
        return $this->web_price;
    }
    
    function getPrintPrice() {
        return $this->print_price;
    }
    
    function getUnlimitedPrice() {
        return $this->unlimited_price;
    }
    
    function getDisabled() {
        return $this->disabled;
    }
   
}
    
    
?>
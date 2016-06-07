<?php

class Purchase {

    private $id = '';
    private $user_id = '';
    private $asset_id = '';
    private $license_type = '';
    private $amount = '';
    private $created = '';
    
    function __construct ($result_array) {
             
        $this->id = $result_array['id'];
        $this->user_id = $result_array['user_id'];
        $this->asset_id = $result_array['asset_id'];
        $this->license_type = $result_array['license_type'];
        $this->amount = $result_array['amount'];
        $this->created = $result_array['created'];
    }
    
    function getId() {
        return $this->id;
    }

    function getUserId() {
        return $this->user_id;
    }
    
    function getAssetId() {
        return $this->asset_id;
    }
    
    function getLicenseType() {
        return $this->license_type;
    }
    
    function getAmount() {
        return $this->amount;
    }
    
    function getCreated() {
        return $this->created;
    }
    
}


?>
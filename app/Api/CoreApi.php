<?php
namespace App\Api;
/* this class is a extension of the WALApi class */

class CoreApi extends BaseApi {

    protected $base_url = 'https://hydrogrowthmanager.azurewebsites.net/automation/';

    public function sendTest(){
        return $this->post('SendTest', ['micrcocontrollerID' => 'AA:BB:CC', 'type' => 'TDS', 'value' => '102.2']);
    }

}
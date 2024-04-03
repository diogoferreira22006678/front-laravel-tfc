<?php
namespace App\Api;

use App\Api\BaseApi;
use App\Models\Rele;
use App\Models\Value;
use App\Models\Sensor;
use App\Models\Arduino;
use App\Models\Container;
use App\Models\SensorType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CoreApi extends BaseApi {

    protected $base_url = 'https://hydrogrowthmanager.azurewebsites.net/automation/';

    public function sendTest(){
        return $this->post('SendTest', ['micrcocontrollerID' => 'AA:BB:CC', 'type' => 'TDS', 'value' => '102.2']);
    }

    public function RequestContainers(){
        return $this->post('RequestContainers');
    }

}
<?php

namespace App\Http\Controllers;

use App\Models\Container;
use App\Models\Arduino;
use App\Models\Rele;
use App\Models\Sensor;
use App\Models\SensorType;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    function saveContainersData($data) {
        foreach ($data as $containerData) {
            // Create Container
            $container = new Container();
            $container->container_name = $containerData['name'];
            $container->container_dimension = $containerData['dimension'];
            $container->container_location = $containerData['location'];
            $container->save();
    
            // Iterate over microcontrollers
            foreach ($containerData['microcontrollers'] as $microcontrollerData) {
                $arduino = new Arduino();
                $arduino->arduino_name = $microcontrollerData['name'];
                $arduino->arduino_capacity = $microcontrollerData['capacity'];
                $arduino->container_id = $container->id;
                $arduino->save();
    
                // Iterate over relays
                foreach ($microcontrollerData['relays'] as $relayData) {
                    $rele = new Rele();
                    $rele->rele_name = $relayData['name'];
                    $rele->rele_state = $relayData['state'];
                    $rele->arduino_id = $arduino->id;
                    $rele->save();
    
                    // Save Sensor
                    $sensorType = SensorType::firstOrCreate(['sensor_type_name' => $relayData['sensor']['type']]);
                    $sensor = new Sensor();
                    $sensor->sensor_name = $relayData['sensor']['name'];
                    $sensor->sensor_type_id = $sensorType->id;
                    $sensor->rele_id = $rele->id;
                    $sensor->save();
                }
            }
        }
    }
}

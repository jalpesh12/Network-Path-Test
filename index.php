<?php

require_once './console/Console.php';
require_once './prepare_data/PrepareData.php';
require_once './network/Device.php';
require_once './network/Network.php';


use NetworkTest\Console as Console;
use NetworkTest\PrepareData as PrepareData;
use NetworkTest\Network\Device as Device;
use NetworkTest\Network\Network as Network;

$console = new Console\Console();
$rawCSVData = array();
// Open and read the CSV Data
$file = fopen($console->csvFilePath, 'r');
while (($result = fgetcsv($file)) !== false)
{
    $rawCSVData[] = $result;
}

$prepareData = new PrepareData\PrepareData();
if (!empty($rawCSVData)) {
    $structuredData = $prepareData->processCSVData($rawCSVData);
}

$network = new Network();

$devices = [];
// Initalized and set all the unique devices in the network
foreach ($prepareData->unqiueDevices as $device => $deviceName) {
    $devices[$device] = new Device($device);
}


if (!empty($structuredData)) {
    foreach($structuredData as $device => $adjacentDevice) {
        foreach($adjacentDevice as $deviceName => $deviceValue) {
            if (isset($devices[$deviceName])) {
                $devices[$device]->connect($devices[$deviceName], $deviceValue); 
            }
            
        }
        $network->add($devices[$device]);
    }
}


print_r($network);
die();








// Step 2 - Get the input value from the console
            // Check for the valid input if proper input not provided then show message to provide valid input.
            // Also, need to make sure it does not exit the program once it returns the output untill user exit the console.

// Step 3 - Find/Calulate the travel time between device using valid from and to value along with Time
          // Set all the unique Devices(from and to) i.e in our case (A, B, C, D...).(Bascially it will be dynamic)
          // Create a object/array in such a way that it contains all the properties such as 
          // adjacent devices with its latency
          // Set the input device from and to which is provided from the user input
          
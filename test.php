<?php

require_once './prepare_data/PrepareData.php';
require_once './network/Device.php';
require_once './network/Network.php';
require_once './network/algorithm/NetworkPath.php';
require_once './console/Console.php';

use NetworkTest\Console as Console;
use NetworkTest\PrepareData as PrepareData;
use NetworkTest\Network\Device as Device;
use NetworkTest\Network\Network as Network;
use NetworkTest\Network\Algorithm\NetworkPath as NetworkPath;


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


//Connect all the devices
if (!empty($structuredData)) {
    foreach($structuredData as $device => $adjacentDevice) {
        foreach($adjacentDevice as $deviceName => $deviceValue) {
            $devices[$device]->connect($devices[$deviceName], $deviceValue); 
        }
    }
}

$starting_index = 'A';
$ending_index = 'D';

$visited_nodes = [];





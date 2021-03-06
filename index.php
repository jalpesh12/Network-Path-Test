<?php

require_once './console/Console.php';
use NetworkTest\Console as Console;

$console = new Console\Console();

$rawCSVData = array();
// Open and read the CSV Data
$file = fopen($console->csvFilePath, 'r');
while (($result = fgetcsv($file)) !== false)
{
    $rawCSVData[] = $result;
}

// Step 2 - Get the input value from the console
            // Check for the valid input if proper input not provided then show message to provide valid input.
            // Also, need to make sure it does not exit the program once it returns the output untill user exit the console.

// Step 3 - Find/Calulate the travel time between device using valid from and to value along with Time
          // Set all the unique Devices(from and to) i.e in our case (A, B, C, D...).(Bascially it will be dynamic)
          // Create a object/array in such a way that it contains all the properties such as 
          // adjacent devices with its latency
          // Set the input device from and to which is provided from the user input
          
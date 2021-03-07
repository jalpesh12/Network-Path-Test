<?php
/*
 * This file is used to handle all the console related events/data/input.
 * Reads the CSV file from the console command + also handling console user input handiling
 *
 */

namespace NetworkTest\Console;

use NetworkTest\Network\Algorithm\NetworkPath as NetworkPath;

class Console {

    /**
     * Default path is used(test_data) for the fallback logic. Just in case if provided csv gets not loaded or not found then it will be helpful.
     */
    public $csvFilePath = 'test_data.csv';

    /**
     * Instantiates a console to get the params (basically to get csv file params)
     */
    public function __construct()
    {
        $options = ['file:'];
        $getArgument = getopt(null, $options);

        if (!empty($getFilePath) && !empty($getFilePath['file']))  {
            $this->csvFilePath = $getFilePath['file'];
        }
    }

    /**
     * Initalize the console for the console input for the programs
     * 
     * @param $network The whole network of devices data
     * @param $devices Contains all the devices data
     */
    public function initConsole($network, $devices) {

        echo '|------Welcome to Network Test Path----|' .PHP_EOL;

        menu:

        $option = fwrite(STDOUT,"Please enter user input([Device From][Device To][Time]) (eg A F 1000): ");
        $option = trim(fgets(STDIN));

        if (!empty($option)) {

            $this->exitProgram($option);
        
            $options = explode(' ', $option);
            if (count($options) !== 3) {
                echo PHP_EOL . 'Please enter valid format (eg A F 1000)'. PHP_EOL;
                goto menu;
            }
        
            // Run the algorithm
            $algorithm = new NetworkPath($network);
            $algorithm->setStartingDevice($devices[$options[0]]);
            $algorithm->setEndingDevice($devices[$options[1]]);
            $algorithm->setMaximumLatency($options[2]);
            echo PHP_EOL . $algorithm->getLiteralShortestPath() . PHP_EOL;
        
            goto menu;
        
        } else {
            echo 'Please enter valid inpit format (eg A F 1000)'. PHP_EOL;
            goto menu;
        }

    }

    /**
     * stop the execution and exit the program
     * 
     * @param $option input parameter from the console
     */
    public function exitProgram($option) {
        if (strtoupper($option) == 'QUIT' || $option == 'EXIT') {
            die();
        }
    }


}
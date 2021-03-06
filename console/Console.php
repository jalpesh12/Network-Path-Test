<?php
/*
 * This file is used to handle all the console related events/data/input.
 * Reads the CSV file from the console command + also handling console user input handiling
 *
 */

namespace NetworkTest\Console;

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


}
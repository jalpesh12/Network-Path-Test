<?php
/*
 * This file is used to prepare a data in required format
 *
 */

namespace NetworkTest\PrepareData;

class PrepareData {

    public $unqiueDevices = [];

    /**
     * This function is used to prepare raw csv data.
     * Making the array which can be helpful to process the data
     * 
     * @param array $rawCSVData Raw CSV data
     * 
     * @return array
     * 
     */
    public function processCSVData($rawCSVData) {
        $refinedData = [];
        foreach($rawCSVData as $index => $rowData) {
            $refinedData[$rowData[0]][] = [$rowData[1] => $rowData[2]];
            $refinedData[$rowData[1]][] = [$rowData[0] => $rowData[2]];
        }

        $structuredData = [];
        if (!empty($refinedData)) {
            $this->unqiueDevices = array_keys($refinedData);
            foreach ($refinedData as $device => $adjacentDevices) {
                $allAjacentDevices = call_user_func_array('array_merge', $adjacentDevices);
                $structuredData[$device] =  $allAjacentDevices;
            }
        }

        return $structuredData;
    }

}
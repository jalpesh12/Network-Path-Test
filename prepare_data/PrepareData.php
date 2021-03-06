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
        foreach ($rawCSVData as $index => $csvRow) {
          $tmp = [];
          $tmp[$csvRow[0]] = [
            $csvRow[1] => $csvRow[2]
          ];
          $refinedData[] = $tmp;
        }

        $structuredData = [];
        if (!empty($refinedData)) {
            foreach($refinedData as $refinedIndex => $refinedValue) {
                foreach ($refinedValue as $itemKey => $itemValue) {
                    $this->unqiueDevices[$itemKey] = $itemKey;
                    $structuredData[$itemKey][key($itemValue)] = $itemValue[key($itemValue)];
                }
            }
        }

        return $structuredData;
    }

}
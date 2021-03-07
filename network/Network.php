<?php

/**
 * Class Network is a dataset to easily work with a simulated network.
 */

namespace NetworkTest\Network;

require_once 'NetworkInterface.php';

class Network implements NetworkInterface {

     /**
     * All the Devices in the int the network
     *
     * @var array
     */
    protected $devices = array();

    /**
     * Adds a new device to the current network.
     * 
     * @param DeviceInterface $device
     */
    public function add(DeviceInterface $device) {

        if (array_key_exists($device->getId(), $this->getDevices())) {
            echo 'Unable to insert multiple devices with the same id in a network';
        }

        $this->devices[$device->getId()] = $device;

        return $this;
    }

    /**
     * Returns the device identified with the $id associated to this network.
     * 
     * @param int $id device id
     */
    public function getDevice($id)
    {
        $devices = $this->getDevices();

        if (!array_key_exists($id, $devices)) {
            echo 'Unable to find ' . $id . ' in the graph';
        }

        return $devices[$id];
    }

    /**
     * Returns all the devices that belong to this network.
     * 
     * @return array list of devices
     */
    public function getDevices() {
        return $this->devices;
    }

}
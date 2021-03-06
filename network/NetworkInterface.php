<?php

namespace NetworkTest\Network;

interface NetworkInterface {

    /**
     * Adds a new device to the current network.
     *
     * @param   DeviceInterface $device
     * @return  NetworkInterface
     */
    public function add(DeviceInterface $device);

    /**
     * Returns the device identified with the $id associated to this network.
     *
     * @param   mixed $id
     * @return  DeviceInterface
     */
    public function getDevice($id);

    /**
     * Returns all the devices that belong to this network.
     *
     * @return Array
     */
    public function getDevices();
}
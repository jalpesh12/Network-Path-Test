<?php

/**
 * Class Device is the foundation of a network entity.
 */

namespace NetworkTest\Network;

class Device implements DeviceInterface {
    protected $id;
    protected $potential;
    protected $potentialFrom;
    protected $connections = array();
    protected $passed = false;

    /**
     * Instantiates a new Device, requiring a ID to avoid collisions.
     *
     * @param mixed $id
     */
    public function __construct($id) {
        $this->id = $id;
    }


    /**
     * Connects the Device to another $device.
     * A $distance, to balance the connection, can be specified.
     *
     * @param Device $device
     * @param integer $distance
     */
    public function connect(DeviceInterface $device, $distance = 1) {
        $this->connections[$device->getId()] = $distance;
    }

    /**
     * Returns the connections of the current Device.
     *
     * @return Array
     */
    public function getConnections() {
        return $this->connections;
    }

    /**
     * Returns the identifier of this vertex.
     *
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }



    /**
     * Returns device's potential.
     *
     * @return integer
     */
    public function getPotential() {
        return $this->potential;
    }

    /**
     * Returns the device which gave to the current device its potential.
     *
     * @return NetworkTest\Network\Device
     */
    public function getPotentialFrom() {
        return $this->potentialFrom;
    }

    /**
     * Returns whether the device has passed or not.
     *
     * @return boolean
     */
    public function isPassed() {
        return $this->passed;
    }

    /**
     * Marks this device as passed, meaning that, in the scope of a network,
     * has already been processed in order to calculate its potential.
     */
    public function markPassed()
    {
        $this->passed = true;
    }

    /**
     * Sets the potential for the device, if the device has no potential or the
     * one it has is higher than the new one.
     *
     * @param   integer $potential
     * @param   Device $from
     * @return  boolean
     */
    public function setPotential($potential, DeviceInterface $from) {
        $potential = (int) $potential;

        if (!$this->getPotential() || $potential < $this->getPotential()) {
            $this->potential = $potential;
            $this->potentialFrom = $from;

            return true;
        }

        return false;
    }



}
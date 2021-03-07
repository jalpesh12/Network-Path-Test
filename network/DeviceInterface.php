<?php

/**
 * Interface Device
 */
namespace NetworkTest\Network;

interface DeviceInterface {

    public function connect(DeviceInterface $device, $distance = 1);

    /**
     * Returns the connections of the current device.
     *
     * @return Array
     */
    public function getConnections();

    /**
     * Returns the identifier of this device.
     *
     * @return mixed
     */
    public function getId();

    /**
     * Returns device's potential.
     *
     * @return integer
     */
    public function getPotential();

    /**
     * Returns the Device which gave to the current Device its potential.
     *
     * @return Device
     */
    public function getPotentialFrom();

    /**
     * Returns whether the Device has passed or not.
     *
     * @return boolean
     */
    public function isPassed();

    /**
     * Marks this device as passed, meaning that, in the scope of a network, he
     * has already been processed in order to calculate its potential.
     */
    public function markPassed();

    /**
     * Sets the potential for the device, if the device has no potential or the
     * one it has is higher than the new one.
     *
     * @param   integer $potential
     * @param   Device $from
     * @return  boolean
     */
    public function setPotential($potential, DeviceInterface $from);

}
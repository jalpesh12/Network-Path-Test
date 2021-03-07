<?php

namespace NetworkTest\Network\Algorithm;

require_once 'AlgorithmInterface.php';

use NetworkTest\Network\NetworkInterface;
use NetworkTest\Network\DeviceInterface;


class NetworkPath implements AlgorithmInterface {

    protected $startingDevice;
    protected $endingDevice;
    protected $network;
    protected $paths = array();
    protected $solution = false;
    protected $maxLatencey;

    /**
     * Instantiates a new algorithm, requiring a network to work with.
     *
     * @param NetworkInterface $network
     */
    public function __construct(NetworkInterface $network) {
        $this->network = $network;
    }

    /**
     * Returns the distance between the starting and the ending point.
     *
     * @return integer
     */
    public function getDistance() {
        if (!$this->isSolved()) {
            echo 'Cannot calculate the distance of a non-solved algorithm:\nDid you forget to call ->solve()?';
        }

        if ($this->getMaximumLatency() > $this->getEndingDevice()->getPotential()) {
            return $this->getEndingDevice()->getPotential();
        } else {
            return 'Path Not found';
        }
        
    }

    /**
     * Gets the device which we are pointing to.
     *
     * @return DeviceInterface
     */
    public function getEndingDevice() {
        return $this->endingDevice;
    }

    /**
     * Returns the solution in a human-readable style.
     *
     * @return string
     */
    public function getLiteralShortestPath() {
        $path = $this->solve();
        $literal = '';

        foreach ($path as $p) {
            $literal .= "{$p->getId()} => ";
        }

        if ($this->getMaximumLatency() > $this->getEndingDevice()->getPotential()) {
            return substr($literal, 0, -3) . '=> ' . $this->getEndingDevice()->getPotential();
        } else {
            return 'Path Not found';
        }
        
    }

    /**
     * Reverse-calculates the shortest path of the graph thanks the potentials
     * stored in the devices.
     *
     * @return Array
     */
    public function getShortestPath() {
        $path   = array();
        $device = $this->getEndingDevice();

        while ($device->getId() != $this->getStartingDevice()->getId()) {
            $path[] = $device;
            $device = $device->getPotentialFrom();
        }

        $path[] = $this->getStartingDevice();

        return array_reverse($path);
    }

    /**
     * Retrieves the device which we are starting from to calculate the shortest path.
     *
     * @return DeviceInterface
     */
    public function getStartingDevice() {
        return $this->startingDevice;
    }

    /**
     * Retrives the latency set by input console
     */
    public function getMaximumLatency() {
        return $this->maxLatencey;
    }

    /**
     * Sets the device which we are pointing to.
     *
     * @param DeviceInterface $device
     */
    public function setEndingDevice(DeviceInterface $device) {
        $this->endingDevice = $device;
        // print_r($this->endingDevice);
        // // echo $this->endingDevice;
        // die();
    }

    /**
     * Sets the device which we are starting from to calculate the shortest path.
     *
     * @param DeviceInterface $device
     */
    public function setStartingDevice(DeviceInterface $device) {
        $this->paths[] = array($device);
        $this->startingDevice = $device;
    }

    /**
     * Set the max latency allowed for the path which we get from the user input
     */
    public function setMaximumLatency($maxLatencey) {
        $this->maxLatencey = $maxLatencey;
    }

    public function solve()
    {
        if (!$this->getStartingDevice() || !$this->getEndingDevice()) {
            echo 'Cannot solve the algorithm without both starting and ending devices';
        }

        $this->calculatePotentials($this->getStartingDevice());

        $this->solution = $this->getShortestPath();

        return $this->solution;
    }

    /**
     * Recursively calculates the potentials of the network, from the
     * starting point you specify with ->setStartingDevice(), traversing
     * the network due to Device's $connections attribute.
     *
     * @param DeviceInterface $device
     */
    protected function calculatePotentials(DeviceInterface $device) {
        $connections = $device->getConnections();
  
        $sorted = array_flip($connections);

        krsort($sorted);

        foreach ($connections as $id => $distance) {
            $v = $this->getNetwork()->getDevice($id);
            $v->setPotential($device->getPotential() + $distance, $device);
            foreach ($this->getPaths() as $path) {
                $count = count($path);

                if ($path[$count - 1]->getId() === $device->getId()) {
                    $this->paths[] = array_merge($path, array($v));
                }
            }
        }


        $device->markPassed();

        // Get loop through the current device's nearest connections
        // to calculate their potentials.
        foreach ($sorted as $id) {
            $device = $this->getNetwork()->getDevice($id);

            if (!$device->isPassed()) {
                $this->calculatePotentials($device);
            }
        }

    }

    /**
     * Returns the network associated with this Network path instance.
     *
     * @return NetworkInterface
     */
    protected function getNetwork() {
        return $this->network;
    }

    /**
     * Returns the possible paths registered in the network.
     *
     * @return Array
     */
    protected function getPaths()
    {
        return $this->paths;
    }

    /**
     * Checks wheter the current Network path has been solved or not.
     *
     * @return boolean
     */
    protected function isSolved()
    {
        return (bool) $this->solution;
    }



}
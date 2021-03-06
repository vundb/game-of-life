<?php

namespace GameOfLife;

/**
 * Class Cell
 *
 * @package GameOfLife
 */
class Cell
{
    /**
     * @var bool
     */
    private $state;

    /**
     * @var array
     */
    private $neighbours;

    /**
     * Cell constructor.
     *
     * @param boolean $state
     */
    public function __construct($state = false)
    {
        $this->state = $state;
        $this->neighbours = [];
    }

    /**
     * @return bool
     */
    public function isAlive()
    {
        return $this->state;
    }

    /**
     * @return int
     */
    public function countNeighbours()
    {
        return count($this->neighbours);
    }

    /**
     * @param Cell $n
     */
    public function addNeighbour(Cell $n)
    {
        $this->neighbours[] = $n;
    }

    /**
     * @param array $neighbours
     */
    public function setNeighbours(array $neighbours)
    {
        $this->neighbours = [];

        foreach ($neighbours as $neighbour) {
            if (null !== $neighbour) {
                array_push($this->neighbours, $neighbour);
            }
        }
    }

    /**
     * @return int
     */
    public function countLivingNeighbours()
    {
        $living = 0;

        foreach ($this->neighbours as $n) {
            $living += $n->isAlive() == true ? 1 : 0;
        }

        return $living;
    }

    /**
     * @return bool
     */
    public function calculateNextState()
    {
        $livingNeighbours = $this->countLivingNeighbours();

        if ($this->isAlive() && $livingNeighbours < 2) {
            return false;
        }

        if ($this->isAlive() && $livingNeighbours > 3) {
            return false;
        }

        if ($this->isAlive() && $livingNeighbours >= 2 && $livingNeighbours <= 3) {
            return true;
        }

        if (!$this->isAlive() && $livingNeighbours === 3) {
            return true;
        }

        return false;
    }

    /**
     * @param Cell $cell
     *
     * @return bool
     */
    public function isCellYourNeighbour(Cell $cell)
    {
        return in_array($cell, $this->neighbours);
    }

    /**
     * Set cell's state to true.
     *
     * @return $this
     */
    public function setAlive()
    {
        $this->state = true;
        return $this;
    }

    /**
     * Set cell's state to false.
     *
     * @return $this
     */
    public function setDead()
    {
        $this->state = false;
        return $this;
    }
}

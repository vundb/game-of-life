<?php

namespace GameOfLifeTest;

use GameOfLife\Cell;

/**
 * Class GameOfLifeTest
 *
 * @package GameOfLifeTest
 */
class CellTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \GameOfLife\Cell
     */
    public function testIsAlive()
    {
        $cell = new Cell(true);

        $this->assertTrue($cell->isAlive());
    }

    /**
     * @covers \GameOfLife\Cell
     */
    public function testCountNeighbours()
    {
        $cell = new Cell();

        $this->assertEquals(0, $cell->countNeighbours());
    }

    /**
     * @covers \GameOfLife\Cell
     */
    public function testCountOneNewNeighbour()
    {
        $cell = new Cell();

        $cell->addNeighbour(new Cell());

        $this->assertEquals(1, $cell->countNeighbours());
    }

    /**
     * @covers \GameOfLife\Cell
     */
    public function testSetNeighbours()
    {
        $cell = new Cell();

        $neighbours = $this->createNeighbours(8);
        $cell->setNeighbours($neighbours);

        $this->assertEquals(count($neighbours), $cell->countNeighbours());
    }

    /**
     * @covers \GameOfLife\Cell
     */
    public function testSetNeighboursWithNullValues()
    {
        $cell = new Cell();

        $neighbours = $this->createNeighbours(8);
        array_push($neighbours, null);
        array_push($neighbours, null);
        $cell->setNeighbours($neighbours);

        $this->assertEquals(count($neighbours) - 2, $cell->countNeighbours());
    }

    /**
     * @covers \GameOfLife\Cell
     */
    public function testCountAliveNeighbours()
    {
        $cell = new Cell();

        $neighbours = [
            new Cell(true),
            new Cell(true),
            new Cell(true),
            new Cell(),
            new Cell(),
            new Cell(),
            new Cell(),
            new Cell()
        ];

        $cell->setNeighbours($neighbours);

        $this->assertEquals(3, $cell->countLivingNeighbours());
    }

    /**
     * @covers \GameOfLife\Cell
     */
    public function testLivingCellWithoutLivingNeighbourWillDie()
    {
        $cell = new Cell(true);

        $cell->setNeighbours($this->createNeighbours(8, 0));

        $this->assertFalse($cell->calculateNextState());
    }

    /**
     * @covers \GameOfLife\Cell
     */
    public function testLivingCellWithOneLivingNeighbourWillDie()
    {
        $cell = new Cell(true);

        $cell->setNeighbours($this->createNeighbours(7, 1));

        $this->assertFalse($cell->calculateNextState());
    }

    /**
     * @covers \GameOfLife\Cell
     */
    public function testLivingCellwithFourLivingNeighboursWillDie()
    {
        $cell = new Cell(true);

        $cell->setNeighbours($this->createNeighbours(4, 4));

        $this->assertFalse($cell->calculateNextState());
    }

    /**
     * @covers \GameOfLife\Cell
     */
    public function testLivingCellWithFiveLivingNeighboursWillDie()
    {
        $cell = new Cell(true);

        $cell->setNeighbours($this->createNeighbours(3, 5));

        $this->assertFalse($cell->calculateNextState());
    }

    /**
     * @covers \GameOfLife\Cell
     */
    public function testLivingCellWithTwoLivingNeighboursWillSurvive()
    {
        $cell = new Cell(true);

        $cell->setNeighbours($this->createNeighbours(6, 2));

        $this->assertTrue($cell->calculateNextState());
    }

    /**
     * @covers \GameOfLife\Cell
     */
    public function testLivingCellWithThreeLivingNeighboursWillSurvive()
    {
        $cell = new Cell(true);

        $cell->setNeighbours($this->createNeighbours(5, 3));

        $this->assertTrue($cell->calculateNextState());
    }

    /**
     * @covers \GameOfLife\Cell
     */
    public function testDeadCellWithThreeLivingNeighboursWillBeBorn()
    {
        $cell = new Cell(false);

        $cell->setNeighbours($this->createNeighbours(5, 3));

        $this->assertTrue($cell->calculateNextState());
    }

    /**
     * @covers \GameOfLife\Cell
     */
    public function testIsCellYourNeighbour()
    {
        $cell = new Cell();

        $neighbours = [new Cell()];
        $cell->setNeighbours($neighbours);

        $this->assertTrue($cell->isCellYourNeighbour($neighbours[0]));
    }

    /**
     * @covers \GameOfLife\Cell
     */
    public function testSetAlive()
    {
        $cell = new Cell(false);

        $cell->setAlive();

        $this->assertTrue($cell->isAlive());
    }

    /**
     * @covers \GameOfLife\Cell
     */
    public function testSetDead()
    {
        $cell = new Cell(true);

        $cell->setDead();

        $this->assertFalse($cell->isAlive());
    }

    ########

    /**
     * @param int $deadAmount
     * @param int $aliveAmount
     *
     * @return Cell[]
     */
    private function createNeighbours($deadAmount, $aliveAmount = 0)
    {
        $result = [];

        for ($i = 0; $i < $deadAmount; $i++) {
            array_push($result, new Cell());
        }

        for ($i = 0; $i < $aliveAmount; $i++) {
            array_push($result, new Cell(true));
        }

        return $result;
    }
}

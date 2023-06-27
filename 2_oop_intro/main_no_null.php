<?php

abstract class Transport
{
    protected string $name;
    protected int $speed;

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setSpeed(int $speed): self
    {
        $this->speed = $speed;
        return $this;
    }

    public function getSpeed(): int
    {
        return $this->speed;
    }

    abstract public function displayInfo(): void;
}

class Car extends Transport
{
    private int $numDoors;

    public function setNumDoors(int $numDoors): self
    {
        $this->numDoors = $numDoors;
        return $this;
    }

    public function getNumDoors(): int
    {
        return $this->numDoors;
    }

    public function startEngine(): string
    {
        return "{$this->getName()} - запускає двигун.";
    }

    public function displayInfo(): void
    {
        echo "Назва: {$this->getName()}" . PHP_EOL;
        echo "Кількість дверей: {$this->getNumDoors()}" . PHP_EOL;
        echo "Максимальна швидкість: {$this->getSpeed()} км/год" . PHP_EOL;
        echo $this->startEngine() . PHP_EOL;
        echo PHP_EOL;
    }
}

class Bicycle extends Transport
{
    private int $numGears;

    public function setNumGears(int $numGears): self
    {
        $this->numGears = $numGears;
        return $this;
    }

    public function getNumGears(): int
    {
        return $this->numGears;
    }

    public function ringBell(): string
    {
        return "{$this->getName()} - дзвенить у дзвінок!";
    }

    public function displayInfo(): void
    {
        echo "Назва: {$this->getName()}" . PHP_EOL;
        echo "Кількість передач: {$this->getNumGears()}" . PHP_EOL;
        echo "Максимальна швидкість: {$this->getSpeed()} км/год" . PHP_EOL;
        echo $this->ringBell() . PHP_EOL;
        echo PHP_EOL;
    }
}

class Boat extends Transport
{
    private string $boatType;
    private bool $anchorDropped = false;

    public function setBoatType(string $boatType): self
    {
        $this->boatType = $boatType;
        return $this;
    }

    public function getBoatType(): string
    {
        return $this->boatType;
    }

    public function dropAnchor(): void
    {
        $this->anchorDropped = true;
        echo "{$this->getName()} - опускаємо якір!" . PHP_EOL;
    }

    public function raiseAnchor(): void
    {
        $this->anchorDropped = false;
        echo "{$this->getName()} - підіймаємо якір!" . PHP_EOL;
    }

    public function displayInfo(): void
    {
        echo "Назва: {$this->getName()}" . PHP_EOL;
        echo "Тип судна: {$this->getBoatType()}" . PHP_EOL;
        echo "Максимальна швидкість: {$this->getSpeed()} км/год" . PHP_EOL;
        echo ($this->anchorDropped ? "{$this->getName()} - якір опущено." : "{$this->getName()} - якір піднято.") . PHP_EOL;
        echo PHP_EOL;
    }
}

function displayTransportInfo(array $transports): void
{
    echo PHP_EOL;
    foreach ($transports as $transport) {
        $transport->displayInfo();
    }
}

$car = new Car();
$car->setName('Автомобіль')->setSpeed(200)->setNumDoors(4);

$bicycle = new Bicycle();
$bicycle->setName('Велосипед')->setSpeed(30)->setNumGears(6);

$boat = new Boat();
$boat->setName('Човен')->setSpeed(40)->setBoatType('Моторний');
$boat->dropAnchor();

$transports = [$car, $bicycle, $boat];
displayTransportInfo($transports);
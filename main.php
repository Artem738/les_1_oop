<?php

abstract class Transport
{
    protected ?string $name;
    protected ?int $speed;

    protected function validateNegativeNumber($number, $errorMessage): void
    {
        if ($number < 0) {
            echo $errorMessage;
            exit();
        }
    }

    public function __construct(?string $name, ?int $speed)
    {
        $this->name = $name;
        $this->validateNegativeNumber($speed, 'Швидкість не може бути від\'ємною.');
        $this->speed = $speed;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getSpeed(): ?int
    {
        return $this->speed;
    }

    public function setName($name): static
    {
        $this->name = $name;
        return $this;
    }

    public function setSpeed($speed): static
    {
        $this->validateNegativeNumber($speed, 'Швидкість не може бути від\'ємною.');
        $this->speed = $speed;
        return $this;
    }

    abstract public function displayInfo(): void;
}

class Car extends Transport
{
    private ?int $numDoors;

    public function __construct($name = null, $speed = null, $numDoors = null)
    {
        parent::__construct($name, $speed);
        $this->validateNegativeNumber($numDoors, 'Кількість дверей не може бути від\'ємною.');
        $this->numDoors = $numDoors;
    }

    public function getNumDoors(): int
    {
        return $this->numDoors;
    }

    public function setNumDoors($numDoors): Car
    {
        $this->validateNegativeNumber($numDoors, 'Кількість дверей не може бути від\'ємною.');
        $this->numDoors = $numDoors;
        return $this;
    }

    public function startEngine(): string
    {
        return "{$this->name} - запускає двигун.";
    }

    public function displayInfo(): void
    {
        if (!isset($this->name, $this->speed, $this->numDoors)) {
            echo "Інформація про автомобіль недоступна. Будь ласка, встановіть назву, швидкість та інші дані." . PHP_EOL;
        } else {
            echo "Назва: " . $this->getName() . PHP_EOL;
            echo "Кількість дверей: " . $this->getNumDoors() . PHP_EOL;
            echo "Максимальна швидкість: " . $this->getSpeed() . " км/год " . PHP_EOL;
            echo $this->startEngine() . PHP_EOL;
        }
        echo PHP_EOL;
    }
}

class Bicycle extends Transport
{
    private ?int $numGears;

    public function __construct($name = null, $speed = null, $numGears = null)
    {
        parent::__construct($name, $speed);
        $this->validateNegativeNumber($numGears, 'Кількість передач не може бути від\'ємною.');
        $this->numGears = $numGears;
    }

    public function getNumGears(): ?int
    {
        return $this->numGears;
    }

    public function setNumGears($numGears): static
    {
        $this->validateNegativeNumber($numGears, 'Кількість передач не може бути від\'ємною.');
        $this->numGears = $numGears;
        return $this;
    }

    public function ringBell(): string
    {
        return "{$this->name} - дзвонить у дзвіночок!";
    }

    public function displayInfo(): void
    {
        if (!isset($this->name, $this->speed, $this->numGears)) {
            echo "Інформація про велосипед недоступна. Будь ласка, встановіть назву, швидкість та інші дані." . PHP_EOL;
        } else {
            echo "Назва: " . $this->getName() . PHP_EOL;
            echo "Кількість передач: " . $this->getNumGears() . PHP_EOL;
            echo "Максимальна швидкість: " . $this->getSpeed() . " км/год" . PHP_EOL;
            echo $this->ringBell() . PHP_EOL;
        }
        echo PHP_EOL;
    }
}

class Boat extends Transport
{
    private ?string $boatType;
    private bool $anchorDropped;

    public function __construct($name = null, $speed = null, $boatType = null)
    {
        parent::__construct($name, $speed);
        $this->boatType = $boatType;
        $this->anchorDropped = false;
    }

    public function setBoatType($boatType): static
    {
        $this->boatType = $boatType;
        return $this;
    }

    public function getBoatType(): string
    {
        return $this->boatType;
    }

    public function dropAnchor(): string
    {
        $this->anchorDropped = true;
        return "{$this->name} - опускаємо якір!";
    }

    public function raiseAnchor(): string
    {
        $this->anchorDropped = false;
        return "{$this->name} - підіймаємо якір!";
    }

    public function isAnchorDropped(): bool
    {
        return $this->anchorDropped;
    }

    public function displayInfo(): void
    {
        if (!isset($this->name, $this->speed, $this->boatType)) {
            echo "Інформація про човен недоступна. Будь ласка, встановіть назву, швидкість та інші дані." . PHP_EOL;
        } else {
            echo "Назва: " . $this->getName() . PHP_EOL;
            echo "Тип: " . $this->getBoatType() . PHP_EOL;
            echo "Максимальна швидкість: " . $this->getSpeed() . " км/год" . PHP_EOL;
            echo ($this->isAnchorDropped() ? $this->getName() . " - Якір кинуто" : $this->getName() . " - Якір не кинуто") . PHP_EOL;
        }
        echo PHP_EOL;
    }
}

function displayTransportInfo(array $transports): void
{
    foreach ($transports as $transport) {
        $transport->displayInfo();
    }
}

// Створення об'єктів транспорту без даних
echo PHP_EOL;
$car = new Car();
$bicycle = new Bicycle();
$boat = new Boat();
$transports = [$car, $bicycle, $boat];
displayTransportInfo($transports);


// Створення об'єктів транспорту з даними
$car = new Car("Автомобіль", 200, 4);
$bicycle = new Bicycle("Велосипед", 30);
$bicycle->displayInfo();
$bicycle->setNumGears(5);
$boat->setName("Човен")->setSpeed(60)->setBoatType("Моторний");



// Використання геттерів
echo PHP_EOL;
echo "Назва автомобіля: " . $car->getName() . PHP_EOL;
echo "Максимальна швидкість велосипеду: " . $bicycle->getSpeed() . " км/год" . PHP_EOL;
echo "Тип човна: " . $boat->getBoatType() . PHP_EOL;

// Використання сеттерів
echo PHP_EOL;
$car->setNumDoors(2)->setName("Маленький автомобіль")->setSpeed(140);
$bicycle->setSpeed(40);
$boat->setBoatType("Парусний")->setSpeed(40);

// Виведення інформації про конкретний транспортний засіб
echo PHP_EOL;
$boat->displayInfo();

// Виклик методів
echo PHP_EOL;
echo $car->startEngine() . PHP_EOL;
echo $bicycle->ringBell() . PHP_EOL;
echo $boat->dropAnchor() . PHP_EOL;

//Загальна функція з інформацією
echo PHP_EOL;
$transports = [$car, $bicycle, $boat];
displayTransportInfo($transports);




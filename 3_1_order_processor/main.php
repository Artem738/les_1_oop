<?php

class Order
{
    public function __construct(
        protected int    $id,
        protected string $type,
        protected string $data
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getData(): string
    {
        return $this->data;
    }

    public function setData(string $data): void
    {
        $this->data = $data;
    }
}

class OrderProcessor
{
    private OrderHandlerInterface $orderHandler;     // Обробник замовлення
    private ReportGeneratorInterface $reportGenerator;  // Генератор звіту

    public function setOrderHandler(OrderHandlerInterface $orderHandler): void
    {
        $this->orderHandler = $orderHandler;
    }

    public function setReportGenerator(ReportGeneratorInterface $reportGenerator): void
    {
        $this->reportGenerator = $reportGenerator;
    }

    public function processOrder(Order $order): void
    {
        // Обробка замовлення за допомогою хендлера
        $this->orderHandler->processOrder($order);
        // Генерація звіту за допомогою генератора
        $this->reportGenerator->generateReport($order);
    }

    public function displayOrderInfo(Order $order): void
    {
        echo 'Інформація про замовлення:' . PHP_EOL;
        echo 'ID: ' . $order->getId() . PHP_EOL;
        echo 'Тип: ' . $order->getType() . PHP_EOL;
        echo 'Дані: ' . $order->getData() . PHP_EOL;
    }
}

interface OrderHandlerInterface
{
    public function processOrder(Order $order): void;
}

class ProductOrderHandler implements OrderHandlerInterface
{
    public function processOrder(Order $order): void
    {
        echo "Обробка замовлення №" . $order->getId() . " на товар з типом " . $order->getType() . PHP_EOL;
    }
}

class ServiceOrderHandler implements OrderHandlerInterface
{
    public function processOrder(Order $order): void
    {
        echo "Обробка замовлення №" . $order->getId() . " на послугу з типом " . $order->getType() . PHP_EOL;
    }
}

class DeliveryOrderHandler implements OrderHandlerInterface
{
    public function processOrder(Order $order): void
    {
        echo "Обробка замовлення на доставку з типом " . $order->getType() . PHP_EOL;
    }
}

interface ReportGeneratorInterface
{
    public function generateReport(Order $order): void;
}

class PDFReportGenerator implements ReportGeneratorInterface
{
    public function generateReport(Order $order): void
    {
        echo 'Звіт - №' . $order->getId() . ' - відображено у форматі PDF.' . PHP_EOL;
    }
}

class CSVReportGenerator implements ReportGeneratorInterface
{
    public function generateReport(Order $order): void
    {
        echo 'Звіт - №' . $order->getId() . ' - відображено у форматі CSV.' . PHP_EOL;
    }
}

// Функція для автоматичної обробки процесів яку треба налаштовувати у разі змін.
function processOrder(Order $order): void
{
    // Масив з відповідностями типів замовлення обробникам та генераторам звіту
    $handlers = [
        'product' => new ProductOrderHandler(),
        'service' => new ServiceOrderHandler(),
        'delivery' => new DeliveryOrderHandler()
    ];

    $generators = [
        'product' => new PDFReportGenerator(),
        'service' => new CSVReportGenerator(),
        'delivery' => new PDFReportGenerator()
    ];

    // Вибираємо обробник замовлення залежно від типу замовлення
    $orderType = $order->getType();
    $orderHandler = $handlers[$orderType] ?? exit('Помилка! Тип замовлення не визначено або не знайдено відповідного обробника.');

    // Вибираємо генератор звіту залежно від типу замовлення
    $reportGenerator = $generators[$orderType] ?? exit('Помилка! Тип замовлення не визначено або не знайдено відповідного генератора.');

    // Обробка замовлення за допомогою хендлера
    $orderHandler->processOrder($order);

    // Генерація звіту за допомогою генератора
    $reportGenerator->generateReport($order);
}

// Приклади

$order1 = new Order(1, 'product', 'Дані про замовлення на товар');
$order2 = new Order(2, 'service', 'Дані про замовлення на послугу');
$order3 = new Order(3, 'delivery', 'Дані про замовлення на доставку');

processOrder($order1);
processOrder($order2);
processOrder($order3);

<?php

/* USER */

class User
{
    public function __construct(
        protected int    $id,
        protected string $username,
        protected string $password,
        protected string $role,
        protected string $email
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
}

class UserAuthenticator
{
    public static function authenticate(string $email, string $password, User $user): bool
    {
        if ($user->getEmail() === $email && $user->getPassword() === $password) {
            echo 'Успішна аутентифікація.' . PHP_EOL;
            return true;
        } else {
            echo 'Невдала аутентифікація.' . PHP_EOL;
            return false;
        }
    }
}

class UserProfile
{
    public static function displayProfileInfo(User $user): void
    {
        echo PHP_EOL;
        echo "Інформація про користувача:" . PHP_EOL;
        echo "ID: " . $user->getId() . PHP_EOL;
        echo "Ім'я користувача: " . $user->getUsername() . PHP_EOL;
        echo "Роль: " . $user->getRole() . PHP_EOL;
        echo "Email: " . $user->getEmail() . PHP_EOL;
    }
}


/* FILE */

interface FileReaderInterface
{
    public function readFile(string $filename): string;
}

class TextFileReader implements FileReaderInterface
{
    public function readFile(string $filename): string
    {
        return "Дані після читання з файлу типу txt: $filename" . PHP_EOL;
    }
}

class CSVFileReader implements FileReaderInterface
{
    public function readFile(string $filename): string
    {
        return "Дані після читання з файлу типу csv: $filename" . PHP_EOL;
    }
}

interface FileWriterInterface
{
    public function writeFile(string $filename, string $data): bool;
}

class TextFileWriter implements FileWriterInterface
{
    public function writeFile(string $filename, string $data): bool
    {
        echo "Запись данных в файл типа txt: $filename" . PHP_EOL;
        return true;
    }
}

class CSVFileWriter implements FileWriterInterface
{
    public function writeFile(string $filename, string $data): bool
    {
        echo "Запись данных в файл типа csv: $filename" . PHP_EOL;
        return true;
    }
}

class FileReader
{
    public static function readFile($fileReader, string $filename): string
    {
        return $fileReader->readFile($filename);
    }
}

class FileWriter
{
    public static function writeFile($fileWriter, string $filename, string $data): bool
    {
        return $fileWriter->writeFile($filename, $data);
    }
}


/* ORDER */

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
    public static function processOrder(Order $order): void
    {
        switch ($order->getType()) {
            case 'product':
                ProductOrderHandler::processOrder($order);
                PDFReportGenerator::generateReport($order);
                break;
            case 'service':
                ServiceOrderHandler::processOrder($order);
                CSVReportGenerator::generateReport($order);
                break;
            case 'delivery':
                DeliveryOrderHandler::processOrder($order);
                PDFReportGenerator::generateReport($order);
                break;
            default:
                echo "Невідомий тип заказу";
                break;
        }
    }

    public static function displayOrderInfo(Order $order): void
    {
        echo 'Інформація про замовлення:' . PHP_EOL;
        echo 'ID: ' . $order->getId() . PHP_EOL;
        echo 'Тип: ' . $order->getType() . PHP_EOL;
        echo 'Дані: ' . $order->getData() . PHP_EOL;
    }

}

interface OrderHandlerInterface
{
    public static function processOrder(Order $order): void;
}

class ProductOrderHandler implements OrderHandlerInterface
{
    public static function processOrder(Order $order): void
    {
        echo "Обробка замовлення №" . $order->getId() . " на товар з типом " . $order->getType() . PHP_EOL;
    }
}

class ServiceOrderHandler implements OrderHandlerInterface
{
    public static function processOrder(Order $order): void
    {
        echo "Обробка замовлення №" . $order->getId() . " на послугу з типом " . $order->getType() . PHP_EOL;
    }
}

class DeliveryOrderHandler implements OrderHandlerInterface
{
    public static function processOrder(Order $order): void
    {
        echo "Обробка замовлення на доставку з типом " . $order->getType() . PHP_EOL;
    }
}

/* ORDER REPORT  */

interface ReportGeneratorInterface
{
    public static function generateReport(Order $order): void;
}

class PDFReportGenerator implements ReportGeneratorInterface
{
    public static function generateReport(Order $order): void
    {
        echo 'Звіт - №' . $order->getId() . ' - відображен у форматі PDF.' . PHP_EOL;
    }
}

class CSVReportGenerator implements ReportGeneratorInterface
{
    public static function generateReport(Order $order): void
    {
        echo 'Звіт - №' . $order->getId() . ' - відображен у форматі CSV.' . PHP_EOL;
    }
}

/* DATA */

class DataManager
{
    public static function saveData($data): void
    {
        echo 'Дані - "' . mb_substr($data, 0, 20) . '" успішно збережені в базі даних.' . PHP_EOL;
    }

    public static function displayData($data): void
    {
        echo 'Дані - "' . mb_substr($data, 0, 20) . '" успішно відображені на веб-сторінці.' . PHP_EOL;
    }
}

/* Приклади використання */
$firstOrder = new Order(1, "product", "Якісь данні щодо замовленя продукту");
$secondOrder = new Order(2, "service", "Якісь данні щодо замовленя сервісу");

//Показуємо інформацію по замовленню
OrderProcessor::displayOrderInfo($firstOrder);

// Робимо звіт без замовлення
PDFReportGenerator::generateReport($secondOrder);

// Обробляємо завомлення
OrderProcessor::processOrder($firstOrder);
OrderProcessor::processOrder($secondOrder);

// Читаємо із файлу
echo PHP_EOL;
echo FileReader::readFile(new CSVFileReader(), "data.csv");

// Запис у файл, перевіряємо результат запису.
if (FileWriter::writeFile(new TextFileWriter(), "output.txt", $firstOrder->getData())) {
    echo "Запис даних у файл пройшов успішно." . PHP_EOL;
} else {
    echo "Помилка під час запису даних у файл." . PHP_EOL;
}


DataManager::saveData($firstOrder->getData());
DataManager::displayData($secondOrder->getData());


$user = new User(1, "Vasiliy", "12345", "user", "vasvas12345@gmail.com");
UserProfile::displayProfileInfo($user);
echo UserAuthenticator::authenticate("vasvas12345@gmail.com", "12345", $user);

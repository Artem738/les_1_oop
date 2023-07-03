<?php

class UserData
{
    public function __construct(
        protected int    $id,
        protected string $name,
        protected string $password,
        protected string $email,
        protected string $phone,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }
}

interface UserRepositoryInterface
{
    public function insert(UserData $userData): bool;

    public function findById(int $id): ?UserData;

    public function update(UserData $userData): bool;

    public function delete(int $id): bool;
}

class Database implements UserRepositoryInterface
{
    protected string $dbName = 'users';

    public function __construct()
    {
        echo 'Підєднуємся до Бази Даних - ' . $this->dbName . PHP_EOL; // Тимчасове рішення.
    }

    public function insert(UserData $userData): bool
    {
        // Логіка вставки користувача в базу даних
        echo 'Користувача з ім\'ям ' . $userData->getName() . ' додано до бази даних.' . PHP_EOL;
        return true;
    }

    public function findById(int $id): ?UserData
    {
        // Логіка пошуку, повертає об'єкт UserData або null, якщо користувач не знайдений
        return null;
    }

    public function update(UserData $userData): bool
    {
        // Логіка оновлення даних користувача в базі даних
        return true;
    }

    public function delete(int $id): bool
    {
        // Логіка видалення користувача з бази даних
        return true;
    }
}

interface EmailServiceInterface
{
    public function sendWelcomeEmail(UserData $userData): bool;

    public function sendAccountDeletedEmail(UserData $userData): bool;
}

class EmailService implements EmailServiceInterface
{
    public function sendWelcomeEmail(UserData $userData): bool
    {
        echo 'Лист "ласкаво просимо" відправлено на адресу: ' . $userData->getEmail() . PHP_EOL;
        return true;
    }

    public function sendAccountDeletedEmail(UserData $userData): bool
    {
        echo 'Лист "акаунт видалено" відправлено на адресу: ' . $userData->getEmail() . PHP_EOL;
        return true;
    }
}

interface SMSServiceInterface
{
    public function sendSMS(UserData $userData, string $message): bool;
}

class SMSService implements SMSServiceInterface
{
    public function sendSMS(UserData $userData, string $message): bool
    {
        echo 'SMS  "' . $message . '" відправлено на номер ' . $userData->getPhone() . PHP_EOL;
        return true;
    }
}

class UserService
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
        protected EmailServiceInterface   $emailService,
        protected SMSServiceInterface     $smsService,
    ) {
    }

    public function registerUser(UserData $userData): bool
    {
        $isUserInserted = $this->userRepository->insert($userData);
        $isEmailSent = $this->emailService->sendWelcomeEmail($userData);
        $isSMSSent = $this->smsService->sendSMS($userData, 'Вітаємо з реєстрацією!');

        return $isUserInserted && $isEmailSent && $isSMSSent;
    }

    public function deleteUser(UserData $userData): bool
    {
        $isUserDeleted = $this->userRepository->delete($userData->getId());
        $isEmailSent = $this->emailService->sendAccountDeletedEmail($userData);
        $isSMSSent = $this->smsService->sendSMS($userData, 'Ваш обліковий запис було видалено.');

        return $isUserDeleted && $isEmailSent && $isSMSSent;
    }
}


$userData = new UserData(1, 'Vasiliy', 'password123', 'vasvas111@gmail.com', '+380631234567');

$userService = new UserService(
    new Database(),
    new EmailService(),
    new SMSService(),
);
$result = $userService->registerUser($userData);

if ($result) {
    echo 'Користувача зареєстровано.' . PHP_EOL;
} else {
    echo 'Помилка у системі реєстрації користувача. Дивіться у логи...' . PHP_EOL;
}


$result = $userService->deleteUser($userData);

if ($result) {
    echo 'Користувача видалено.' . PHP_EOL;
} else {
    echo 'Помилка у системі видалення користувача. Дивіться у логи...' . PHP_EOL;
}



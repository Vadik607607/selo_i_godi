<?php
// Новий токен та chat_id
$botToken = 'ТУТ_НОВИЙ_ТОКЕН'; // ← встав сюди новий токен, виданий BotFather
$chatId = '-1002635554466';

// Дані з форми
$fullname = $_POST['fullname'] ?? '';
$phone = $_POST['phone'] ?? '';
$address = $_POST['address'] ?? '';
$quantity = $_POST['quantity'] ?? '';
$product = $_POST['product'] ?? '';
$messageText = $_POST['message'] ?? '';

// Перевірка
if (!$fullname || !$phone || !$address || !$quantity || !$product) {
  http_response_code(400);
  echo "Будь ласка, заповніть всі обов’язкові поля.";
  exit;
}

// Повідомлення
$message = "Нове замовлення:\n"
         . "📦 Продукт: $product\n"
         . "🔢 Кількість: $quantity кг\n"
         . "👤 Ім’я та прізвище: $fullname\n"
         . "📞 Телефон: $phone\n"
         . "📍 Адреса: $address\n"
         . ($messageText ? "✏️ Коментар: $messageText\n" : "");

// Надсилання
$apiUrl = "https://api.telegram.org/bot$botToken/sendMessage";

$response = file_get_contents($apiUrl . '?' . http_build_query([
  'chat_id' => $chatId,
  'text' => $message
]));

if ($response) {
  echo "OK";
} else {
  http_response_code(500);
  echo "Помилка при надсиланні повідомлення.";
}

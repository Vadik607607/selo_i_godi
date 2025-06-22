<?php
$botToken = '7977927826:AAGdEOP3vJ6gsCLBTaxcwxfk1sEpVI7tQqc';
$chatId = '-1002635554466'; // правильний ID групи

$fullname = $_POST['fullname'] ?? '';
$phone = $_POST['phone'] ?? '';
$address = $_POST['address'] ?? '';
$quantity = $_POST['quantity'] ?? '';
$product = $_POST['product'] ?? '';
$messageText = $_POST['message'] ?? '';

if (!$fullname || !$phone || !$address || !$quantity || !$product) {
  http_response_code(400);
  echo "Будь ласка, заповніть всі обов’язкові поля.";
  exit;
}

$message = "Нове замовлення:\n"
         . "📦 Продукт: $product\n"
         . "🔢 Кількість: $quantity кг\n"
         . "👤 Ім’я та прізвище: $fullname\n"
         . "📞 Телефон: $phone\n"
         . "📍 Адреса: $address\n"
         . ($messageText ? "✏️ Коментар: $messageText\n" : "");

$apiUrl = "https://api.telegram.org/bot$botToken/sendMessage";

$response = @file_get_contents($apiUrl . '?' . http_build_query([
  'chat_id' => $chatId,
  'text' => $message
]));

if ($response === false) {
  http_response_code(500);
  echo "Помилка при надсиланні запиту до Telegram.";
} else {
  $result = json_decode($response, true);
  if ($result && isset($result['ok']) && $result['ok']) {
    echo "OK";
  } else {
    http_response_code(500);
    echo "Telegram API error: " . ($result['description'] ?? 'Невідома помилка');
  }
}
?>

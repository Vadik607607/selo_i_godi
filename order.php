<?php
$botToken = '7977927826:AAGdEOP3vJ6gsCLBTaxcwxfk1sEpVI7tQqc';
$chatId = '-1002635554466'; // УВАГА! має бути з -100

$fullname = $_POST['fullname'] ?? '';
$phone = $_POST['phone'] ?? '';
$address = $_POST['address'] ?? '';
$quantity = $_POST['quantity'] ?? '';
$product = $_POST['product'] ?? '';
$messageText = $_POST['message'] ?? '';

// Обов'язкові поля
if (!$fullname || !$phone || !$address || !$quantity || !$product) {
  http_response_code(400);
  echo "Будь ласка, заповніть всі обов’язкові поля.";
  exit;
}

// Формування повідомлення
$message = "Нове замовлення:\n"
         . "📦 Продукт: $product\n"
         . "🔢 Кількість: $quantity кг\n"
         . "👤 Ім’я та прізвище: $fullname\n"
         . "📞 Телефон: $phone\n"
         . "📍 Адреса: $address\n"
         . ($messageText ? "✏️ Коментар: $messageText\n" : "");

// Надсилання запиту в Telegram
$apiUrl = "https://api.telegram.org/bot$botToken/sendMessage";
$response = file_get_contents($apiUrl . '?' . http_build_query([
  'chat_id' => $chatId,
  'text' => $message
]));

echo $response;
exit;
}

$result = json_decode($response, true);
if ($result['ok']) {
  echo "OK";
} else {
  http_response_code(500);
  echo "Помилка Telegram API: " . ($result['description'] ?? 'Невідома помилка');
}
?>

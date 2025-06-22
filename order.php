<?php
$botToken = '7977927826:AAGdEOP3vJ6gsCLBTaxcwxfk1sEpVI7tQqc';
$chatId = '-4914702502';

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

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, [
  'chat_id' => $chatId,
  'text' => $message
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode === 200) {
  echo "OK";
} else {
  http_response_code(500);
  echo "Помилка при надсиланні повідомлення.";
}

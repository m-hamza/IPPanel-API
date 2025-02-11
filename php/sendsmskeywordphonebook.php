<?php
// تنظیمات API
$apiKey = "your_api_key_here"; // 🔑 جایگزین با کلید API معتبر
$apiUrl = "https://api2.ippanel.com/api/v1/sms/send/panel/keyword/phonebook";

// اطلاعات پیامک
$data = [
    "sender" => "+983000505", // 📤 شماره ارسال‌کننده (باید تأیید شده باشد)
    "message" => "سلام {ex_name}", // 📝 متن پیامک (شامل کلیدواژه)
    "phonebook_id" => "523642", // 📖 شناسه دفترچه تلفن
    "description" => [
        "summary" => "ارسال کلیدواژه‌ای به دفترچه تلفن", // 📌 توضیح پیامک
        "count_recipient" => "2" // 🔢 تعداد گیرندگان
    ]
];

// تبدیل آرایه به JSON
$jsonData = json_encode($data);

// مقداردهی اولیه cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: AccessKey $apiKey", // 🛡️ احراز هویت
    "Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

// ارسال درخواست و دریافت پاسخ
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// پردازش پاسخ API
if ($httpCode === 200) {
    $responseData = json_decode($response, true);
    echo "✅ پیامک کلیدواژه‌ای با موفقیت ارسال شد! 📨 شناسه پیامک: " . implode(", ", $responseData["data"]);
} else {
    echo "❌ خطا در ارسال پیامک کلیدواژه‌ای! ⛔ کد وضعیت: $httpCode \n";
    echo "🔍 جزئیات خطا: $response \n";
}
?>

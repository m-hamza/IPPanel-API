<?php
// تنظیمات API
$apiKey = "your_api_key_here"; // 🔑 جایگزین با کلید API معتبر
$apiUrl = "https://api2.ippanel.com/api/v1/sms/pattern/normal/send";

// اطلاعات پیامک
$data = [
    "code" => "zd7xxxxf5h", // 🆔 کد الگو (از پنل IPPanel دریافت کنید)
    "sender" => "+983000505", // 📤 شماره فرستنده (باید تأیید شده باشد)
    "recipient" => "+989120000000", // 📥 شماره گیرنده
    "variable" => [
        "code" => "123456" // 📝 مقدار متغیرها در پیامک
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
    echo "✅ پیامک با موفقیت ارسال شد! 📨 شناسه پیامک: " . $responseData["data"]["message_id"];
} else {
    echo "❌ خطا در ارسال پیامک! ⛔ کد وضعیت: $httpCode \n";
    echo "🔍 جزئیات خطا: $response \n";
}
?>


<?php
// تنظیمات API
$apiKey = "your_api_key_here"; // 🔑 جایگزین با کلید API معتبر
$apiUrl = "https://api2.ippanel.com/api/v1/sms/send/webservice/phonebook";

// اطلاعات پیامک
$data = [
    "sender" => "+983000505", // 📤 شماره ارسال‌کننده (باید تأیید شده باشد)
    "message" => "ارسال پیامک از دفترچه تلفن", // 📝 متن پیامک
    "phonebook_ids" => [
        [
            "phonebook_id" => 523642, // 📖 شناسه دفترچه تلفن اول
            "is_random" => false, // 🔀 آیا شماره‌ها به‌صورت تصادفی انتخاب شوند؟
            "offset" => 0, // 🔢 نقطه شروع لیست
            "limit" => 50 // 🔢 تعداد شماره‌ها
        ],
        [
            "phonebook_id" => 523643, // 📖 شناسه دفترچه تلفن دوم
            "is_random" => false,
            "offset" => 0,
            "limit" => 100
        ]
    ],
    "time" => "2025-03-21T09:12:50.824Z" // ⏳ زمان ارسال (اختیاری)
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
    echo "✅ پیامک گروهی با موفقیت ارسال شد! 📨 شناسه پیامک: " . $responseData["data"]["message_id"];
} else {
    echo "❌ خطا در ارسال پیامک گروهی! ⛔ کد وضعیت: $httpCode \n";
    echo "🔍 جزئیات خطا: $response \n";
}
?>

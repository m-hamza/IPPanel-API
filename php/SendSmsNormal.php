<?php

// اطلاعات مربوط به API
$apiUrl = "https://api2.ippanel.com/api/v1/sms/send/webservice/single";
$apiKey = "YOUR_API_KEY"; // جایگزین با کلید API معتبر

// اطلاعات پیامک
$data = [
    "recipient" => ["+989120000000"], // شماره گیرنده پیامک (به فرمت بین‌المللی)
    "sender" => "+983000505", // شماره فرستنده پیامک (باید در سامانه تأیید شده باشد)
    // "time" => "2025-03-21T09:12:50.824Z", // (اختیاری) زمان ارسال پیامک در آینده
    "message" => "ارسال به سازید. IPPanel" // متن پیامک
];

// تبدیل آرایه به فرمت JSON
$jsonData = json_encode($data);

// مقداردهی اولیه درخواست cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: AccessKey $apiKey"
]);

// اجرای درخواست و دریافت پاسخ
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// بررسی وضعیت پاسخ API
if ($httpCode == 200) {
    $responseData = json_decode($response, true);
    echo "پیامک با موفقیت ارسال شد. کد پیامک: " . $responseData['data']['message_id'];
} else {
    echo "خطا در ارسال پیامک. کد وضعیت: " . $httpCode . "\n";
    echo "پاسخ API: " . $response;
}

?>

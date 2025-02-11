<?php
// تنظیمات API
$apiKey = "your_api_key_here"; // 🔑 جایگزین با کلید API معتبر
$apiUrl = "https://api2.ippanel.com/api/v1/sms/accounting/credit/show";

// مقداردهی اولیه cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: AccessKey $apiKey", // 🛡️ احراز هویت
    "Content-Type: application/json"
]);

// ارسال درخواست و دریافت پاسخ
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// پردازش پاسخ API
if ($httpCode === 200) {
    $responseData = json_decode($response, true);
    if (!empty($responseData["data"]["credit"])) {
        echo "💰 اعتبار حساب شما: " . number_format($responseData["data"]["credit"]) . " ریال\n";
    } else {
        echo "❌ مقدار اعتبار حساب یافت نشد.\n";
    }
} else {
    echo "❌ خطا در دریافت اعتبار حساب! ⛔ کد وضعیت: $httpCode \n";
    echo "🔍 جزئیات خطا: $response \n";
}
?>

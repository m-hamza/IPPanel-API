<?php
// تنظیمات API
$apiKey = "your_api_key_here"; // 🔑 جایگزین با کلید API معتبر
$messageId = "529108936"; // 🆔 شناسه پیامک که از ارسال پیامک دریافت شده است
$apiUrl = "https://api2.ippanel.com/api/v1/sms/message/show-recipient/message-id/$messageId";

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
    if (!empty($responseData["data"])) {
        foreach ($responseData["data"] as $sms) {
            echo "📤 پیامک به شماره: " . $sms["recipient"] . "\n";
            echo "📜 متن پیامک: " . $sms["message"] . "\n";
            echo "⏳ زمان ارسال: " . $sms["time"] . "\n";
            
            // تبدیل کد وضعیت به متن
            $statusText = [
                0 => "📩 در حال ارسال",
                1 => "⌛ در صف ارسال",
                2 => "✅ تحویل داده شده",
                3 => "❌ ارسال ناموفق",
                4 => "🚫 رد شده"
            ];
            echo "📊 وضعیت: " . ($statusText[$sms["status"]] ?? "نامشخص") . "\n\n";
        }
    } else {
        echo "❌ هیچ پیامکی با این شناسه یافت نشد.\n";
    }
} else {
    echo "❌ خطا در دریافت وضعیت پیامک! ⛔ کد وضعیت: $httpCode \n";
    echo "🔍 جزئیات خطا: $response \n";
}
?>

<?php
// تنظیمات API
$apiKey = "your_api_key_here"; // 🔑 جایگزین با کلید API معتبر
$page = 1; // 📄 شماره صفحه
$perPage = 10; // 🔢 تعداد پیامک‌ها در هر صفحه
$apiUrl = "https://api2.ippanel.com/api/v1/inbox?page=$page&per_page=$perPage";

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
        echo "📩 لیست پیامک‌های دریافتی:\n";
        foreach ($responseData["data"] as $sms) {
            echo "🆔 شناسه پیامک: " . $sms["message_id"] . "\n";
            echo "📤 فرستنده: " . $sms["sender"] . "\n";
            echo "📥 گیرنده: " . $sms["receiver"] . "\n";
            echo "📜 متن پیامک: " . $sms["message"] . "\n";
            echo "⏳ زمان دریافت: " . $sms["time"] . "\n";
            echo "--------------------------\n";
        }
    } else {
        echo "❌ هیچ پیامکی دریافت نشده است.\n";
    }
} else {
    echo "❌ خطا در دریافت پیامک‌های دریافتی! ⛔ کد وضعیت: $httpCode \n";
    echo "🔍 جزئیات خطا: $response \n";
}
?>

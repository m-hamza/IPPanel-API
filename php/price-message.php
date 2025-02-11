<?php
// تنظیمات API
$apiKey = "your_api_key_here"; // 🔑 جایگزین با کلید API معتبر
$lineNum = "983000505"; // 📤 شماره خط ارسال‌کننده
$sendingType = "keyword"; // 📌 نوع ارسال (اختیاری، می‌توانید حذف کنید)
$charset = "fa"; // 📝 نوع کدگذاری (اختیاری، برای زبان فارسی "fa")

// ساخت URL با پارامترهای ارسالی
$apiUrl = "https://api2.ippanel.com/api/v1/sms/accounting/price-message/sender/$lineNum";
$queryParams = http_build_query([
    "sending_type" => $sendingType,
    "charset" => $charset
]);
$apiUrl .= "?" . $queryParams;

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
    if (!empty($responseData["data"]["price"])) {
        echo "💰 هزینه ارسال پیامک از خط $lineNum: " . number_format($responseData["data"]["price"]) . " ریال\n";
    } else {
        echo "❌ اطلاعات مربوط به هزینه ارسال یافت نشد.\n";
    }
} else {
    echo "❌ خطا در دریافت هزینه ارسال پیامک! ⛔ کد وضعیت: $httpCode \n";
    echo "🔍 جزئیات خطا: $response \n";
}
?>

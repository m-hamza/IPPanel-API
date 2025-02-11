<?php
// تنظیمات API
$apiKey = "your_api_key_here"; // 🔑 جایگزین با کلید API معتبر
$apiUrl = "https://api2.ippanel.com/api/v1/sms/send/panel/file";

// اطلاعات پیامک
$postData = [
    "sender" => "+983000505", // 📤 شماره ارسال‌کننده (باید تأیید شده باشد)
    "message" => "این یک پیامک گروهی است.", // 📝 متن پیامک
    "description[summary]" => "ارسال گروهی از فایل", // 📌 توضیح پیامک
    "description[count_recipient]" => "3" // 🔢 تعداد گیرندگان
];

// مسیر فایل CSV (باید در سرور موجود باشد)
$filePath = "contacts.csv"; // 📁 فایل شامل شماره‌های گیرنده
if (!file_exists($filePath)) {
    die("❌ فایل CSV یافت نشد. لطفاً بررسی کنید.\n");
}

// آماده‌سازی فایل برای ارسال
$file = new CURLFile($filePath, "text/csv", basename($filePath));
$postData["file"] = $file;

// مقداردهی اولیه cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: AccessKey $apiKey", // 🛡️ احراز هویت
    "Content-Type: multipart/form-data"
]);

// ارسال درخواست و دریافت پاسخ
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// پردازش پاسخ API
if ($httpCode === 200) {
    echo "✅ پیامک گروهی با موفقیت ارسال شد!\n";
} else {
    echo "❌ خطا در ارسال پیامک گروهی! ⛔ کد وضعیت: $httpCode \n";
    echo "🔍 جزئیات خطا: $response \n";
}
?>

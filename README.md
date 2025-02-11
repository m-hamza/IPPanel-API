# IPPanel-API

برای شروع، ابتدا یک **لیست کامل از سرویس‌های موجود در مستندات IPPanel** را با لینک هر مورد و توضیحات مربوط به ورودی‌ها و خروجی‌های آن‌ها تهیه می‌کنم. این اطلاعات به شما کمک می‌کند که درک درستی از تمامی قابلیت‌های این API داشته باشید.

---

### **لیست کامل سرویس‌های IPPanel**
مستندات API بر پایه نسخه `v1` طراحی شده است و آدرس پایه آن:
```plaintext
https://api2.ippanel.com/api/v1
```
می‌باشد.

#### **۱. ارسال پیامک‌های مختلف**
| سرویس | توضیح | لینک مستندات |
|------|------|------|
| **ارسال پیامک به کدپستی (Bank PostalCode)** | ارسال پیامک به کاربرانی که در یک محدوده‌ی کدپستی خاص قرار دارند. | [`/sms/post-code-bank/send-overall`](https://docs.ippanel.com) |
| **ارسال پیامک به محدوده جغرافیایی (Send district bank)** | ارسال پیامک به کاربران یک محدوده‌ی شهری خاص بر اساس جنسیت و سن. | [`/sms/district-bank/send`](https://docs.ippanel.com) |
| **ارسال پیامک عادی (Normal SMS)** | ارسال پیامک به یک شماره خاص. | [`/sms/send/webservice/single`](https://docs.ippanel.com) |
| **ارسال پیامک از فایل (Send SMS from a file)** | ارسال پیامک به شماره‌های داخل یک فایل. | [`/sms/send/panel/file`](https://docs.ippanel.com) |
| **ارسال پیامک نظیر به نظیر (Peer-to-Peer SMS)** | ارسال پیامک‌های مختلف به چندین شماره به‌صورت جفت‌شده. | [`/sms/send/webservice/peer-to-peer`](https://docs.ippanel.com) |
| **ارسال پیامک نظیر به نظیر از فایل (Peer-to-Peer by File)** | ارسال پیامک‌های مختلف به شماره‌های داخل فایل. | [`/sms/send/panel/peer-to-peer-by-file`](https://docs.ippanel.com) |
| **ارسال پیامک از دفترچه تلفن (Phonebook SMS)** | ارسال پیامک به شماره‌های موجود در دفترچه تلفن. | [`/sms/send/webservice/phonebook`](https://docs.ippanel.com) |
| **ارسال پیامک الگوی آماده (Send Pattern SMS)** | ارسال پیامک با الگوهای از پیش تعریف‌شده. | [`/sms/pattern/normal/send`](https://docs.ippanel.com) |
| **ارسال پیامک از طریق کلیدواژه‌ها (Keyword SMS from a File)** | ارسال پیامک با استفاده از کلیدواژه‌های موجود در فایل. | [`/sms/send/panel/keyword/file`](https://docs.ippanel.com) |
| **ارسال پیامک کلیدواژه‌ای از دفترچه تلفن (Keyword SMS from Phonebook)** | ارسال پیامک از طریق دفترچه تلفن با کلیدواژه. | [`/sms/send/panel/keyword/phonebook`](https://docs.ippanel.com) |

---

#### **۲. بررسی وضعیت پیامک‌های ارسال‌شده**
| سرویس | توضیح | لینک مستندات |
|------|------|------|
| **دریافت لیست پیامک‌های ارسال‌شده (Get Sent Messages List)** | مشاهده پیامک‌های ارسال‌شده با اطلاعات کامل. | [`/sms/message/all`](https://docs.ippanel.com) |
| **دریافت لیست پیامک‌های دریافتی (Get Received Messages List)** | مشاهده پیامک‌های دریافت‌شده. | [`/inbox`](https://docs.ippanel.com) |

---

#### **۳. مدیریت حساب و اعتبارات**
| سرویس | توضیح | لینک مستندات |
|------|------|------|
| **نمایش اعتبار حساب (Show Credit)** | نمایش میزان اعتبار باقی‌مانده در حساب. | [`/sms/accounting/credit/show`](https://docs.ippanel.com) |
| **بررسی هزینه ارسال پیامک (Show SMS Cost)** | نمایش هزینه‌ی ارسال پیامک از یک خط مشخص. | [`/sms/accounting/price-message/sender/{lineNum}`](https://docs.ippanel.com) |

---

#### **۴. بررسی وضعیت تحویل پیامک**
| سرویس | توضیح | لینک مستندات |
|------|------|------|
| **بررسی وضعیت تحویل پیامک (Show Delivery Status of Message)** | مشاهده‌ی آخرین وضعیت پیامک‌های ارسال‌شده. | [`/sms/message/show-recipient/message-id/{messageId}`](https://docs.ippanel.com) |

---

### **مشخصات ورودی و خروجی هر سرویس**
هر کدام از این سرویس‌ها دارای ورودی‌های مشخصی هستند که در ادامه توضیح داده می‌شود.

#### **۱. ارسال پیامک عادی (Normal SMS)**
- **متد:** `POST`
- **آدرس:** `/sms/send/webservice/single`
- **ورودی‌ها (JSON):**
  ```json
  {
    "recipient": ["+989120000000"],
    "sender": "+983000505",
    "time": "2025-03-21T09:12:50.824Z",
    "message": "ارسال به سازید. IPPanel"
  }
  ```
- **خروجی موفقیت‌آمیز (HTTP 200):**
  ```json
  {
    "status": "OK",
    "code": 200,
    "errorMessage": "",
    "data": {
      "message_id": 399397747
    }
  }
  ```
- **کدهای خطا:**
  - `400`: درخواست نامعتبر (`Bad Request`)
  - `401`: دسترسی غیرمجاز (`Permission Denied`)
  - `403`: عدم اجازه‌ی ارسال (`Forbidden`)
  - `500`: خطای داخلی سرور (`Internal Server Error`)

---

#### **۲. بررسی اعتبار حساب (Show Credit)**
- **متد:** `GET`
- **آدرس:** `/sms/accounting/credit/show`
- **ورودی:** ندارد
- **خروجی موفقیت‌آمیز (HTTP 200):**
  ```json
  {
    "status": "OK",
    "code": 200,
    "errorMessage": "",
    "data": {
      "credit": 150000
    }
  }
  ```

---

### **مرحله بعدی**
حالا می‌توانیم برای هر سرویس یک فایل `PHP` مجزا ایجاد کنیم که شامل موارد زیر باشد:
1. **یک کلاس PHP برای ارتباط با API و ارسال درخواست‌ها**
2. **یک نمونه از ارسال درخواست برای هر سرویس**
3. **یک فایل جداگانه برای هر متد، همراه با توضیحات کدها**

آیا می‌خواهید برای شروع یک فایل نمونه از ارسال پیامک عادی (`Normal SMS`) ایجاد کنم؟
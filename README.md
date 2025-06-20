# Yaqoot - Laravel + React

## ⚙️ متطلبات التشغيل

قبل بدء العمل، تأكد من توفر المتطلبات التالية:

- PHP >= 8.1
- Composer
- Node.js (يفضّل الإصدار 16 أو أحدث)
- npm
- قاعدة بيانات MySQL
- Git
- Git Bash (ضروري لمستخدمي Windows لتشغيل السكربت `setup.sh`)

---

## 🚀 إعداد المشروع لأول مرة

```bash
git clone https://github.com/yaqootsy/Yaqoot-Platform.git
cd Yaqoot-Platform
git remote -v
```

### إذا أردت التأكد أو تغيير الريموت:

```bash
git remote set-url origin https://github.com/yaqootsy/Yaqoot-Platform.git
```

> تأكد من أنك تعمل ضمن المستودع الرسمي التابع للمنظمة `yaqootsy`.

---

## ⚖️ تشغيل سكربت الإعداد

نفّذ السكربت التالي باستخدام Git Bash:

```bash
./setup.sh
```

### ماذا يفعل `setup.sh`

- يتحقق من وجود `.env.example`
- يثبت مكتبات Laravel (backend) باستخدام Composer
- يثبت مكتبات React (frontend) باستخدام npm
- ينشئ ملف `.env` ويولّد مفتاح التطبيق
- يشغّل الهجرات لإنشاء الجداول
- يجهّز ملفات React للإنتاج
- يتراجع تلقائيًا في حال حصول خطأ لتفادي مشاكل الإعداد

---

## 🧪 التشغيل المحلي

بعد نجاح الإعداد:

```bash
php artisan serve
```

ثم افتح في المتصفح:

```
http://localhost:8000
```

---

## 👨‍💻 أسلوب العمل الجماعي

### ✨ آلية العمل

| المبرمج | الفرع الخاص في المستودع الأصلي |
| ------- | ------------------------------ |
| نديم    | `nadim`                        |
| محمود   | `mahmoud`                      |
| يوسف    | `yousef`                       |
| أحمد    | `ahmad`                        |

### ✅ خطوات العمل

1. اعمل على التعديلات المطلوبة، ثم:

```bash
git add .
git commit -m "feat: وصف التعديلات"
git push origin اسم_فرعك
```

2. افتح Pull Request إلى الفرع المناسب في المستودع ضمن المنظمة:
   - Base repository: `yaqootsy/Yaqoot-Platform`
   - Base branch: `nadim` (أو اسمك)
   - Compare branch: الفرع الذي عملت عليه

> كل مبرمج يدفع إلى فرعه الخاص داخل المستودع الرئيسي.

---

## 📂 تعليمات مهمة

- لا ترفع الملفات التالية:

  - `.env`
  - `node_modules/`
  - `vendor/`
  - أي ملفات خاصة بجهازك

- استخدم رسائل `commit` واضحة:

```bash
fix: حل مشكلة في تسجيل الدخول
feat: إضافة صفحة إعدادات
```

---

## ⚙️ إعداد Git المحلي

```bash
git config user.name "اسمك"
git config user.email "you@yaqootsy.com"
```

---

## 📞 فريق العمل

- نديم الزعبي — [nadim@yaqootsy.com](mailto\:nadim@yaqootsy.com)
- محمود — [mahmoud@yaqootsy.com](mailto\:mahmoud@yaqootsy.com)
- يوسف — [yousef@yaqootsy.com](mailto\:yousef@yaqootsy.com)
- أحمد — [ahmad@yaqootsy.com](mailto\:ahmad@yaqootsy.com)


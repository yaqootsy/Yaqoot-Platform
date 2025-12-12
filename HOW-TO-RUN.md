حتى يتمكن أصدقاؤك من تشغيل النظام **بنفس الشكل 100% الذي يعمل عندك** هناك طريقتان فقط، وسأشرح لك للأسلوب الصحيح والمضمون، والخطوات العملية الدقيقة.

---

# ✔️ **أولاً: مهم جداً أن تفهم قاعدة أساسية**

كل تثبيت قمت به داخل الحاوية (apt-get install ffmpeg, exif, ghostscript, imagick…)
لن يتوفر عند أصدقائك إلا إذا كان موجودًا في **Dockerfile**.

يعني:

* عندك يعمل لأنك ثبّت يدويًا داخل الحاوية
* عندهم لن يعمل لأن الـ image ستبنى من Dockerfile فقط
  → لذلك يجب تضمين كل شيء داخل Dockerfile قبل مشاركته.

بعد تجهيز Dockerfile و docker-compose correctly، يصبح تشغيل المشروع عند أي شخص:

```
docker compose up -d
```

فقط.

---

# ✔️ **طريقة المشاركة الصحيحة (الأفضل + القياسية)**

هذه الطريقة لا تحتاج مشاركة "الحاوية" نفسها، بل مشاركة **المشروع بالكامل + الملفات المتعلقة بـ Docker فقط**.

## 1) جهّز مشروعك قبل الإرسال

### أ) تأكد أن Dockerfile يحتوي على:

* كل المكتبات system packages
* كل PHP extensions
* ffmpeg
* ghostscript
* exif
* supervisor (لتشغيل queue)
* imagick
* gd
* intl

### ب) تأكد أن docker-compose.yml يحتوي على:

* app
* nginx
* mysql
* typesense
* phpmyadmin
* queue worker (مهم أن يكون service منفصل)

### ج) ضع ملف `.env.example` جاهز، بدون معلومات حساسة.

---

# ✔️ 2) أرسل لأصدقائك الملفات التالية:

ارسِل المشروع كاملًا، لكن المهم:

### يجب أن يتضمن:

* Dockerfile
* docker-compose.yml
* مجلد docker/nginx
* مجلد supervisord (إن وجد)
* مجلد storage فارغ (لكن التحويل permissions سهل)
* مجلد bootstrap/cache

### لا ترسل:

* vendor
* node_modules
  (سيتم إنشاؤها داخل الـ container)

---

# ✔️ 3) صديقك يقوم بهذه الخطوات:

### الخطوة 1 — تنزيل المشروع:

```bash
git clone https://github.com/YOUR-REPO/yaqoot.git
cd yaqoot
```

### الخطوة 2 — إنشاء ملف .env

```bash
cp .env.example .env
```

وإضافة:

```
APP_KEY=
```

### الخطوة 3 — تشغيل Docker (أول مرة)

```bash
docker compose up --build -d
```

إذا Dockerfile مضبوطة 100%، سيحصل صديقك على نفس البيئة التي عندك.

### الخطوة 4 — داخل حاوية app:

```bash
docker exec -it yaqoot_app bash
composer install
npm install
npm run build
php artisan key:generate
php artisan migrate --seed
exit
```

### الخطوة 5 — تصاريح

```bash
sudo chmod -R 777 storage bootstrap/cache
```

---

# ✔️ 4) انتهى — الموقع يعمل فورًا على:

```
http://localhost:8080
```

phpMyAdmin:

```
http://localhost:8081
```

Typesense dashboard (API only):

```
http://localhost:8108
```

Queue worker يعمل تلقائيًا بفضل supervisord.

---

# ✔️ **هل يمكن مشاركة "الحاوية" نفسها؟**

نعم، ولكن لا أنصح به، لأن:

* حجمها ضخم جدًا
* ستفقد قابلية التحديث
* Dockerfile يصبح بلا قيمة
* أي تغيير بسيط لازم تعمل export جديد

لكن إذا تريد:
يمكنك عمل export لـ image وتشغيلها عندهم، ولكن هذا *ليس عمليًا أبدًا*.

---

# ✔️ **أفضل طريقة ممكنة لك ولهم؟**

## اجمع كل ما قمت به من تعديلات داخل Dockerfile ثم شارك المشروع فقط.

وبذلك:

* أي شخص سيشغل المشروع فورًا بدون مشاكل.
* كل شيء يعمل بنفس الشكل.
* لا داعي لتثبيت شيء على الجهاز.
* لا أحد يحتاج Composer أو Node أو PHP أو MySQL.

# Yaqoot Platform — Dockerized Setup

Multi-vendor e-commerce platform built with **Laravel 11 + Inertia + React (SSR)**

---

## المتطلبات

يجب توفر التالي فقط على جهازك:

* Docker >= 24
* Docker Compose (مدمج مع Docker Desktop)
* Git

---

## طريقة التشغيل الصحيحة (Docker فقط)

### 1) تنزيل المشروع

```bash
git clone https://github.com/yaqootsy/Yaqoot-Platform.git
cd Yaqoot-Platform
```

---

### 2) إنشاء ملف البيئة

```bash
cp .env.example .env
```

ثم افتح `.env` وأضف البيانات المطلوبة مثل تفاصيل البريد الإلكتروني


---

### 3) بناء وتشغيل المشروع لأول مرة

```bash
docker compose up --build -d
```

---

### 4) الدخول إلى حاوية التطبيق

```bash
docker exec -it yaqoot_app bash
```

داخل الحاوية نفّذ:

```bash
composer install
npm install
npm run build
php artisan key:generate
php artisan migrate --seed
exit
```

---

## الروابط بعد التشغيل

| الخدمة        | الرابط                                         |
| ------------- | ---------------------------------------------- |
| الموقع        | [http://localhost:8080](http://localhost:8080) |
| phpMyAdmin    | [http://localhost:8081](http://localhost:8081) |
| Typesense API | [http://localhost:8108](http://localhost:8108) |

---

## أوامر Docker الأساسية

تشغيل المشروع:

```bash
docker compose up -d
```

إيقاف المشروع:

```bash
docker compose down
```

إعادة تشغيل:

```bash
docker compose restart
```

الدخول للحاوية لتنفيذ أوامر php:

```bash
docker exec -it yaqoot_app bash
```

عرض اللوجات:

```bash
docker compose logs -f app
```

---

## إعادة بناء المشروع بعد تعديل Dockerfile

```bash
docker compose build app
docker compose up -d
```

أو بدون كاش:

```bash
docker compose build --no-cache app
docker compose up -d
```

---

## ملاحظة مهمة

* كل المكتبات يجب أن تكون داخل **Dockerfile**
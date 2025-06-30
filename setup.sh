#!/bin/bash

set -e  # يوقف السكربت فور حدوث أي خطأ

function rollback {
  echo "❌ فشل في الإعداد، جاري التراجع..."
  # حذف ملف .env إذا تم إنشاؤه
  if [ -f ".env" ]; then
    rm .env
    echo "تم حذف ملف .env"
  fi
  # يمكن إضافة حذف ملفات مؤقتة أخرى هنا إذا رغبت
  exit 1
}

trap rollback ERR  # تفعيل rollback عند حدوث خطأ

echo "بدء إعداد المشروع..."

# تحقق من وجود composer.json
if [ ! -f "composer.json" ]; then
  echo "خطأ: ملف composer.json غير موجود في هذا المجلد!"
  exit 1
fi

echo "تثبيت مكتبات Composer..."
composer install

echo "تثبيت مكتبات npm..."
npm install

# نسخة من ملف البيئة
if [ ! -f ".env.example" ]; then
  echo "خطأ: ملف .env.example غير موجود!"
  exit 1
fi

cp .env.example .env

echo "تشغيل الهجرات وإدراج البيانات الإفتراضية..."
php artisan migrate --seed

echo "تشغيل السيرفر..."
composer run dev

echo "✅ تم الإعداد بنجاح"

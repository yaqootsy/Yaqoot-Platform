<?php

if (! function_exists('slugArabic')) {
    /**
     * تحويل النص إلى slug مع الحفاظ على الأحرف العربية
     */
    function slugArabic(string $string): string
    {
        // إزالة الرموز الغريبة مع الاحتفاظ بالحروف والأرقام والمسافات
        $string = preg_replace('/[^\p{L}\p{N}\s]+/u', '', $string);
        // استبدال المسافات بـ "-"
        $string = preg_replace('/\s+/u', '-', $string);
        // تحويل الأحرف إلى صغيرة
        return mb_strtolower($string, 'UTF-8');
    }
}

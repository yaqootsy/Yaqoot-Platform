import React from "react";
import {
  EnvelopeIcon,
  InformationCircleIcon,
} from "@heroicons/react/24/outline";
import { PageProps, Department } from "@/types";
import { usePage } from "@inertiajs/react";
import facebookIcon from "@/assets/images/facebook.svg";
import instagramIcon from "@/assets/images/instagram.svg";
import linkedinIcon from "@/assets/images/linkedin.svg";
import GetItOnGooglePlay from "@/assets/images/GetItOnGooglePlay.png";
import GetItOnAppStore from "@/assets/images/GetItOnAppStore.png";
import xIcon from "@/assets/images/x.svg";

// بيانات الفئات
const footerSections = [
  {
    title: "الإلكترونيات",
    links: [
      "الهواتف المتحركة",
      "أجهزة التابلت",
      "أجهزة الكمبيوتر المحمولة",
      "الأجهزة المنزلية",
      "الكاميرات والصور وتسجيل الفيديو",
      "التلفزيونات",
      "سماعات الرأس",
      "ألعاب الفيديو",
    ],
  },
  {
    title: "الأزياء",
    links: [
      "أزياء نسائية",
      "أزياء رجالية",
      "أزياء البنات",
      "أزياء الأولاد",
      "الساعات",
      "المجوهرات",
      "حقائب اليد النسائية",
      "نظارات الرجال",
    ],
  },
  {
    title: "المطبخ والأجهزة المنزلية",
    links: [
      "مستلزمات الحمام",
      "ديكورات المنازل",
      "المطبخ وأدوات الطعام",
      "الأدوات وتحسين المنزل",
      "أجهزة الصوت والفيديو",
      "الأثاث",
      "مستلزمات الحدائق",
      "مستلزمات الحيوانات الأليفة",
    ],
  },
  {
    title: "الجمال",
    links: [
      "العطور",
      "المكياج",
      "العناية بالشعر",
      "العناية بالبشرة",
      "الجسم والإستحمام",
      "أدوات الجمال الإلكترونية",
      "منتجات العناية بالرجال",
      "منتجات الرعاية الصحية",
    ],
  },
  {
    title: "المواليد والألعاب",
    links: [
      "الحفاضات",
      "تنقل الأطفال",
      "الرضاعة والتغذية",
      "أزياء البيبي والاطفال",
      "ألعاب البيبي",
      "السكوترات",
      "ألعاب الورق والطاولة",
      "الأنشطة الخارجية",
    ],
  },
  {
    title: "شوف أكثر",
    links: [
      "التسويق بالعمولة مع نون",
      "دليل الماركات",
      "البحث الشائع",
      "نون الكويت",
      "نون البحرين",
      "نون عُمان",
      "نون قطر",
      "برنامج تجار دبي",
      "تسوق أينما كنت",
    ],
  },
];

// بيانات الحقوق القانونية
const legalLinks = [
  { label: "© 2025 YaqootMarket. كل الحقوق محفوظة", href: "#" },
  { label: "الوظائف", href: "#" },
  { label: "سياسة الضمان", href: "#" },
  { label: "بِع معنا", href: "#" },
  { label: "شروط الاستخدام", href: "#" },
  { label: "شروط البيع", href: "#" },
  { label: "سياسة الخصوصية", href: "#" },
  { label: "حقوق المستهلك", href: "#" },
];

export default function Footer() {
  const { departments } = usePage<PageProps>().props;

  if (!departments) return null; // حماية إذا لم يتم تحميل الأقسام بعد

  return (
    <footer className="bg-gray-100 shadow-2xl text-gray-800 pt-10">
      <div className="max-w-7xl mx-auto px-4 md:px-6">
        {/* قسم الدعم */}
        <div className="mb-8 flex flex-col md:flex-row md:justify-between md:items-center">
          <div className="mb-4 md:mb-0">
            <p className="text-lg font-semibold">نحن دائماً جاهزون لمساعدتك</p>
            <p className="text-gray-600">
              تواصل معنا من خلال أي من قنوات الدعم التالية:
            </p>
          </div>
          <div className="flex flex-col sm:flex-row gap-4">
            <a
              href="/help"
              target="_blank"
              rel="nofollow noopener noreferrer"
              className="flex items-center gap-3 p-3 bg-white rounded-lg shadow hover:bg-gray-50 transition"
            >
              <InformationCircleIcon className="w-6 h-6" />
              <div>
                <p className="font-medium">مركز المساعدة</p>
                <p className="text-gray-500 text-sm">YaqootMarket.com/help</p>
              </div>
            </a>
            <a
              href="mailto:support@YaqootMarket.com"
              target="_blank"
              rel="nofollow noopener noreferrer"
              className="flex items-center gap-3 p-3 bg-white rounded-lg shadow hover:bg-gray-50 transition"
            >
              <EnvelopeIcon className="w-6 h-6" />
              <div>
                <p className="font-medium">الدعم عبر البريد الإلكتروني</p>
                <p className="text-gray-500 text-sm">support@YaqootMarket.com</p>
              </div>
            </a>
          </div>
        </div>

        {/* أقسام الفئات */}
        <div className="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4 mb-4 text-sm">
          {departments?.map((dep: Department) => (
            <div key={dep.id}>
              <a
                href={`/d/${dep.slug}`}
                className="font-semibold mb-2 hover:underline hover:text-blue-600"
              >
                {dep.name}
              </a>
            </div>
          ))}
        </div>

        {/* قسم الدعم */}
        <div className="mb-8 mt-10 flex flex-col md:flex-row md:justify-between md:items-center">
          <div className="mb-4 md:mb-0">
            <p className="text-md mb-2 font-semibold">
              تسوق بسهولة مع تطبيق ياقوت ماركت
            </p>
            <div className="flex items-center justify-around gap-3 p-3 bg-white rounded-lg shadow hover:bg-gray-50 transition">
              <img src={GetItOnGooglePlay} alt="Google Play" className="h-10" />
              <img src={GetItOnAppStore} alt="App Store" className="h-10" />
            </div>
          </div>

          <div className="mb-4 md:mb-0">
            <p className="text-md mb-2 font-semibold">
              تابعنا على وسائل التواصل الاجتماعي
            </p>
            <div className="flex items-center justify-around gap-3 p-3 bg-white rounded-lg shadow hover:bg-gray-50 transition">
              <img src={facebookIcon} alt="facebook" className="h-10" />
              <img src={instagramIcon} alt="instagram" className="h-10" />
              <img src={linkedinIcon} alt="linkedin" className="h-10" />
            </div>
          </div>
        </div>

        {/* قسم الحقوق القانونية */}
        <div className="border-t border-gray-300 pt-4 pb-4 text-center text-sm text-gray-600 flex flex-col md:flex-row md:justify-center md:gap-6 gap-2">
          {legalLinks.map((link, idx) => (
            <a
              key={idx}
              href={link.href}
              className="hover:text-blue-600"
              target="_blank"
              rel="noopener noreferrer"
            >
              {link.label}
            </a>
          ))}
        </div>
      </div>
    </footer>
  );
}

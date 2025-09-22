// resources/js/Pages/ShippingAddress/Partials/AddressFormModal.tsx
import React, { FormEventHandler, useEffect, useRef, useState } from "react";
import SecondaryButton from "@/Components/Core/SecondaryButton";
import PrimaryButton from "@/Components/Core/PrimaryButton";
import Modal from "@/Components/Core/Modal";
import { useForm } from "@inertiajs/react";
import InputGroup from "@/Components/Core/InputGroup";
import InputLabel from "@/Components/Core/InputLabel";
import InputError from "@/Components/Core/InputError";
import { Address, Country } from "@/types";
import "leaflet/dist/leaflet.css";

// Helper لتحميل سكربت خرائط جوجل
let googleMapsLoadPromise: Promise<any> | null = null;
function loadGoogleMaps(apiKey: string) {
  if (!apiKey)
    return Promise.reject(new Error("Google Maps API key not provided"));
  if (googleMapsLoadPromise) return googleMapsLoadPromise;

  googleMapsLoadPromise = new Promise((resolve, reject) => {
    if (typeof window !== "undefined" && (window as any).google?.maps) {
      return resolve((window as any).google);
    }

    const callbackName = `__initGoogleMaps${Date.now()}`;
    (window as any)[callbackName] = () => {
      resolve((window as any).google);
      delete (window as any)[callbackName];
    };

    const script = document.createElement("script");
    script.src = `https://maps.googleapis.com/maps/api/js?key=${encodeURIComponent(
      apiKey
    )}&libraries=places&callback=${callbackName}`;
    script.async = true;
    script.defer = true;
    script.onerror = reject;
    document.head.appendChild(script);
  });

  return googleMapsLoadPromise;
}

function AddressFormModal({
  countries,
  show,
  onHide,
  address,
}: {
  countries: Country[];
  show: boolean;
  onHide: Function;
  address: Address | null;
}) {
  const form = useForm({
    id: 0,
    country_code: "",
    latitude: null as number | null,
    longitude: null as number | null,
    full_name: "",
    phone: "",
    city: "",
    type: "shipping",
    zipcode: "",
    address1: "",
    address2: "",
    state: "",
    default: false,
    delivery_instructions: "",
  });

  // --- Refs لكائنات خرائط جوجل والحالة ---
  const mapRef = useRef<google.maps.Map | null>(null);
  const markerRef = useRef<google.maps.Marker | null>(null);
  const googleRef = useRef<any | null>(null);
  const mapContainerRef = useRef<HTMLDivElement | null>(null);
  const placesInputRef = useRef<HTMLInputElement | null>(null);

  // Flags لتجنب الكتابة فوق تعديلات المستخدم
  const userInteractedWithMap = useRef(false);

  // الإحداثيات الافتراضية (درعا)
  const DEFAULT_CENTER = { lat: 32.626444, lng: 36.103222 };

  const GOOGLE_MAPS_API_KEY =
    (import.meta as any).env?.VITE_GOOGLE_MAPS_API_KEY ?? "";

  // =================================================================
  // HOOK 1: مزامنة `address` prop مع حالة الفورم
  // =================================================================
  useEffect(() => {
    // عند فتح نافذة جديدة (لا يوجد عنوان)
    if (!address) {
      form.reset();
      userInteractedWithMap.current = false;
      return;
    }

    // عند فتح نافذة لتعديل عنوان موجود
    form.setData({
      id: address.id ?? 0,
      country_code: address.country_code ?? "",
      latitude: address.latitude ? Number(address.latitude) : null,
      longitude: address.longitude ? Number(address.longitude) : null,
      full_name: address.full_name ?? "",
      phone: address.phone ?? "",
      city: address.city ?? "",
      zipcode: address.zipcode ?? "",
      address1: address.address1 ?? "",
      address2: address.address2 ?? "",
      state: address.state ?? "",
      default: address.default ?? false,
      delivery_instructions: address.delivery_instructions ?? "",
      type: address.type ?? "shipping",
    });
    // إعادة تعيين flag تفاعل المستخدم عند تحميل عنوان جديد
    userInteractedWithMap.current = false;
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [address, show]); // الاعتماد على `show` يضمن إعادة التعيين عند كل مرة يفتح فيها الـ Modal

  // =================================================================
  // HOOK 2: تهيئة الخريطة والمستمعات عند فتح الـ Modal
  // =================================================================
  useEffect(() => {
    if (!show) {
      return;
    }

    let isMounted = true;
    loadGoogleMaps(GOOGLE_MAPS_API_KEY)
      .then((google) => {
        if (!isMounted || !mapContainerRef.current || mapRef.current) return;

        googleRef.current = google;
        const map = new google.maps.Map(mapContainerRef.current, {
          center: DEFAULT_CENTER,
          zoom: 11,
          mapTypeControl: false,
          streetViewControl: false,
          fullscreenControl: false,
        });
        mapRef.current = map;

        // --- المستمع الرئيسي: النقر على الخريطة
        map.addListener("click", (e: google.maps.MapMouseEvent) => {
          if (!e.latLng) return;
          userInteractedWithMap.current = true;
          const lat = e.latLng.lat();
          const lng = e.latLng.lng();

          // *** الإصلاح الرئيسي: استخدام functional update لمنع مسح الحقول الأخرى ***
          form.setData((prev) => ({
            ...prev,
            latitude: Number(lat.toFixed(6)),
            longitude: Number(lng.toFixed(6)),
          }));
        });

        // --- إعداد حقل البحث (Places Autocomplete)
        if (placesInputRef.current) {
          const autocomplete = new google.maps.places.SearchBox(
            placesInputRef.current
          );
          map.addListener("bounds_changed", () =>
            autocomplete.setBounds(map.getBounds()!)
          );

          autocomplete.addListener("places_changed", () => {
            const places = autocomplete.getPlaces();
            if (!places || places.length === 0 || !places[0].geometry?.location)
              return;

            userInteractedWithMap.current = true;
            const location = places[0].geometry.location;
            const lat = location.lat();
            const lng = location.lng();

            form.setData((prev) => ({
              ...prev,
              latitude: Number(lat.toFixed(6)),
              longitude: Number(lng.toFixed(6)),
            }));
          });
        }

        // تحفيز حدث `resize` للتأكد من عرض الخريطة بشكل صحيح داخل الـ Modal
        setTimeout(() => google.maps.event.trigger(map, "resize"), 200);
      })
      .catch((err) => console.error("Failed to load Google Maps:", err));

    return () => {
      isMounted = false;
    };
  }, [show]); // هذا الـ hook يعمل فقط عند تغيير `show`

  // =================================================================
  // HOOK 3: مزامنة حالة الفورم (lat/lng) مع واجهة الخريطة (الماركر والتمركز)
  // =================================================================
  useEffect(() => {
    if (!mapRef.current || !googleRef.current) return;

    const lat = form.data.latitude;
    const lng = form.data.longitude;
    const map = mapRef.current;

    if (lat != null && lng != null) {
      const position = { lat, lng };
      // إنشاء أو تحريك الماركر
      if (markerRef.current) {
        markerRef.current.setPosition(position);
      } else {
        markerRef.current = new googleRef.current.maps.Marker({
          position,
          map,
        });
      }

      // توسيط الخريطة على الماركر فقط إذا لم يكن المستخدم قد تفاعل معها
      // هذا يضمن التوسيط عند فتح الفورم للتعديل
      if (!userInteractedWithMap.current) {
        map.panTo(position);
        map.setZoom(15);
      }
    } else {
      // إذا لم تكن هناك إحداثيات، قم بإزالة الماركر
      if (markerRef.current) {
        markerRef.current.setMap(null);
        markerRef.current = null;
      }
      // توسيط الخريطة على الموقع الافتراضي
      if (!userInteractedWithMap.current) {
        map.panTo(DEFAULT_CENTER);
        map.setZoom(11);
      }
    }
  }, [form.data.latitude, form.data.longitude, show]); // يعتمد على الإحداثيات و `show`

 
  // دالة تحديد الموقع الحالي
  const handleUseMyLocation = () => {
    if (!navigator.geolocation) {
      alert("الموقع الجغرافي غير مدعوم في هذا المتصفح.");
      return;
    }
    navigator.geolocation.getCurrentPosition(
      (pos) => {
        userInteractedWithMap.current = true;
        const lat = pos.coords.latitude;
        const lng = pos.coords.longitude;
        form.setData((prev) => ({
          ...prev,
          latitude: Number(lat.toFixed(6)),
          longitude: Number(lng.toFixed(6)),
        }));

        // ==========================================================
        // هذا هو الكود الذي تمت إضافته
        // نتأكد من أن الخريطة موجودة ثم نوجهها للموقع الجديد
        if (mapRef.current) {
          const newPosition = { lat, lng };
          mapRef.current.panTo(newPosition); // تحريك الخريطة للموقع
          mapRef.current.setZoom(15); // تقريب العرض (Zoom)
        }
        // ==========================================================
      },
      (err) => alert(`تعذر الحصول على موقعك: ${err.message}`),
      { enableHighAccuracy: true }
    );
  };

  const closeModal = () => {
    onHide();
    // تنظيف موارد الخريطة عند الإغلاق
    if (markerRef.current) {
      markerRef.current.setMap(null);
      markerRef.current = null;
    }
    mapRef.current = null;
    googleRef.current = null;
    googleMapsLoadPromise = null; // السماح بإعادة التحميل في المرة القادمة
    form.reset();
  };

  const onSubmit: FormEventHandler = (ev) => {
    ev.preventDefault();
    const routeName = form.data.id
      ? "shippingAddress.update"
      : "shippingAddress.store";
    const options = {
      preserveScroll: true,
      onSuccess: () => closeModal(),
    };

    if (form.data.id) {
      form.put(route(routeName, form.data.id), options);
    } else {
      form.post(route(routeName), options);
    }
  };

  const selectedCountry = countries.find(
    (country) => country.code === form.data.country_code
  );

  return (
    <Modal show={show} onClose={closeModal}>
      <form onSubmit={onSubmit} className="p-4 md:p-8">
        <h2 className="text-xl font-medium text-gray-900 dark:text-gray-100 mb-4">
          {form.data.id ? "تحديث العنوان" : "إضافة عنوان جديد"}
        </h2>

        {/* Country Select */}
        <div className="mb-3">
          <InputLabel htmlFor="country_code">
            البلد <span className="text-error">*</span>
          </InputLabel>
          <select
            id="country_code"
            name="country_code"
            value={form.data.country_code}
            className={`select select-bordered w-full mt-1 ${
              form.errors.country_code ? "select-error" : ""
            }`}
            onChange={(e) => form.setData("country_code", e.target.value)}
          >
            <option value="">اختر بلدًا</option>
            {countries.map((country) => (
              <option key={country.code} value={country.code}>
                {country.name}
              </option>
            ))}
          </select>
          <InputError message={form.errors.country_code} className="mt-2" />
        </div>

        {/* Name & Phone */}
        <div className="flex flex-col sm:flex-row gap-4 mb-3">
          <InputGroup
            form={form}
            label="الاسم الكامل"
            field="full_name"
            className="w-full"
            required
          />
          <InputGroup
            form={form}
            label="الهاتف"
            field="phone"
            className="w-full"
            required
          />
        </div>

        {/* State, City, Zip */}
        <div className="flex flex-col sm:flex-row gap-4 mb-3">
          {selectedCountry?.states &&
            Object.keys(selectedCountry.states).length > 0 && (
              <div className="w-full">
                <InputLabel htmlFor="state">
                  المحافظة <span className="text-error">*</span>
                </InputLabel>
                <select
                  id="state"
                  name="state"
                  value={form.data.state}
                  className={
                    "select select-bordered w-full mt-1" +
                    (form.errors.state ? " select-error" : "")
                  }
                  onChange={(e) => form.setData("state", e.target.value)}
                >
                  <option value="">--اختر--</option>

                  {Object.entries(selectedCountry.states)

                    .sort((a, b) => a[1].localeCompare(b[1]))

                    .map(([code, state]) => (
                      <option key={code} value={code}>
                        {state}
                      </option>
                    ))}
                </select>

                <InputError message={form.errors.state} className="mt-2" />
              </div>
            )}

          {!selectedCountry?.states ||
          Object.keys(selectedCountry.states).length === 0 ? (
            <InputGroup
              form={form}
              label="المحافظة"
              field="state"
              className="w-full"
            />
          ) : null}

          <InputGroup
            form={form}
            label="المدينة/البلدة"
            field="city"
            required
            className="w-full"
          />
          <InputGroup
            form={form}
            label="الرمز البريدي"
            field="zipcode"
            className="w-full"
          />
        </div>

        {/* Address Lines */}
        <div className="flex flex-col sm:flex-row gap-4 mb-3">
          <InputGroup
            form={form}
            label="سطر العنوان 1"
            field="address1"
            className="w-full"
            required
          />
          <InputGroup
            form={form}
            label="سطر العنوان 2"
            field="address2"
            className="w-full"
          />
        </div>

        {/* Map Block */}
        <div className="mb-3">
          <div className="flex flex-wrap items-center justify-between gap-2 mb-2">
            <InputLabel>الموقع على الخريطة</InputLabel>
            <input
              ref={placesInputRef}
              type="text"
              placeholder="ابحث بالموقع أو اسم المكان..."
              className="input input-bordered w-full max-w-xs"
            />
            <button
              type="button"
              className="btn btn-sm btn-outline"
              onClick={handleUseMyLocation}
            >
              استخدام موقعي الحالي
            </button>
          </div>
          <div
            ref={mapContainerRef}
            style={{ height: 320, width: "100%" }}
            className="rounded-md overflow-hidden border bg-gray-200"
          />
          <small className="text-gray-500">
            انقر على الخريطة أو ابحث لاختيار موقع العنوان.
          </small>
          <InputError
            message={form.errors.latitude || form.errors.longitude}
            className="mt-2"
          />
        </div>

        <InputGroup
          type="checkbox"
          form={form}
          label="عنوان الشحن الافتراضي"
          field="default"
          className="mb-3"
        />
        <InputGroup
          type="textarea"
          form={form}
          label="تعليمات التسليم"
          placeholder="أدخل تعليمات التسليم هنا"
          field="delivery_instructions"
        />

        <div className="mt-6 flex justify-end">
          <SecondaryButton type="button" onClick={closeModal}>
            إلغاء
          </SecondaryButton>
          <PrimaryButton className="ms-3" disabled={form.processing}>
            تأكيد
          </PrimaryButton>
        </div>
      </form>
    </Modal>
  );
}

export default AddressFormModal;

import PrimaryButton from "@/Components/Core/PrimaryButton";
import SecondaryButton from "@/Components/Core/SecondaryButton";
import InputLabel from "@/Components/Core/InputLabel";
import TextInput from "@/Components/Core/TextInput";
import InputError from "@/Components/Core/InputError";
import FileInput from "@/Components/Core/FileInput";
import Modal from "@/Components/Core/Modal";
import { Link, useForm, usePage } from "@inertiajs/react";
import { Inertia } from "@inertiajs/inertia";
import React, { FormEventHandler, useState } from "react";
import toast from "react-hot-toast";

/**
 * VendorDetails - مدمج:
 * - واجهة "كن بائعاً" بمودال تأكيد ثم wizard متعدد الخطوات (اسم المتجر، العنوان، رفع ملفات الهوية والرخصة).
 * - نموذج تعديل بيانات التاجر (تحديث اسم المتجر، العنوان، صورة الغلاف مع معاينة).
 * - زر الاتصال بـ Stripe.
 *
 * ملاحظات:
 * - يستخدم نفس الـ route("vendor.store") لإرسال الإنشاء والتحديث (كما في أمثلتك).
 * - تأكد من مسارات route في تطبيقك.
 */

export default function VendorDetails({
  className = "",
}: {
  className?: string;
}) {
  const { props } = usePage();
  const user = props.auth.user;
  const token = props.csrf_token;
  const coverMedia = props.coverMedia; // رابط الغلاف من السيرفر (إن وجد)
  console.log(coverMedia);
  
  // --- واجهات الحالة ---
  const [showWizard, setShowWizard] = useState(false); // لعرض نموذج الخطوات
  const [currentStep, setCurrentStep] = useState(1);
  const [showBecomeVendorConfirmation, setShowBecomeVendorConfirmation] =
    useState(false); // مودال تأكيد البدء
  const [successMessage, setSuccessMessage] = useState("");
  const [coverImagePreview, setCoverImagePreview] = useState<string | null>(
    typeof coverMedia === "string" ? coverMedia : null
  );

  // --- form data واحد يغطي الحقول المستخدمة في الإنشاء والتعديل ---
  const { data, setData, post, errors, processing, recentlySuccessful } =
    useForm<{
      store_name: string;
      store_address: string;
      id_card: File | null;
      trade_license: File | null;
      cover_image: File | null;
    }>({
      store_name:
        user.vendor?.store_name || user.name.toLowerCase().replace(/\s+/g, "-"),
      store_address: user.vendor?.store_address || "",
      id_card: null,
      trade_license: null,
      cover_image: null,
    });

  // --- مساعدة: تغيير اسم المتجر إلى slug-like ---
  const onStoreNameChange = (ev: React.ChangeEvent<HTMLInputElement>) => {
    setData("store_name", ev.target.value.toLowerCase().replace(/\s+/g, "-"));
  };

  // --- Drag & Drop Handlers للـ id_card و trade_license و cover_image ---
  const handleDragOver = (e: React.DragEvent) => {
    e.preventDefault();
  };

  const handleDropIdCard = (e: React.DragEvent) => {
    e.preventDefault();
    e.stopPropagation();
    const file = e.dataTransfer?.files?.[0] ?? null;
    console.log("dropped id_card:", file);
    setData("id_card", file);
  };

  const handleDropTradeLicense = (e: React.DragEvent) => {
    e.preventDefault();
    e.stopPropagation();
    const file = e.dataTransfer?.files?.[0] ?? null;
    console.log("dropped trade_license:", file);
    setData("trade_license", file);
  };

  const handleDropCoverImage = (e: React.DragEvent) => {
    e.preventDefault();
    e.stopPropagation();
    const file = e.dataTransfer?.files?.[0] ?? null;
    setData("cover_image", file);
    setCoverImagePreview(file ? URL.createObjectURL(file) : null);
  };

  // --- التنقل بين خطوات الـ wizard ---
  const nextStep = () => setCurrentStep((s) => Math.min(s + 1, 3));
  const prevStep = () => setCurrentStep((s) => Math.max(s - 1, 1));

  // --- إرسال نموذج الـ wizard (إنشاء/طلب بائع) مع ملفات ---
  const handleWizardSubmit: FormEventHandler = (e) => {
    e.preventDefault();

    const formData = new FormData();
    formData.append("store_name", data.store_name);
    formData.append("store_address", data.store_address);
    if (data.id_card) formData.append("id_card", data.id_card);
    if (data.trade_license)
      formData.append("trade_license", data.trade_license);

    post(route("vendor.store"), {
      data: formData,
      headers: { "Content-Type": "multipart/form-data" },
      preserveScroll: true,
      onSuccess: () => {
        setShowWizard(false);
        setCurrentStep(1);
        setSuccessMessage("تم إرسال طلب التاجر بنجاح. سيتم مراجعة طلبك.");
        toast.success("تم إرسال طلب التاجر بنجاح.");
      },
      onError: (errs) => {
        console.error("فشل الإرسال:", errs);
        toast.error(
          "حدث خطأ أثناء إرسال الطلب. تأكد من البيانات والمحاولة مجدداً."
        );
      },
    });
  };

  // --- تحديث بيانات التاجر (يشمل cover_image) ---
  const handleUpdateVendor: FormEventHandler = (e) => {
    e.preventDefault();

    const formData = new FormData();
    formData.append("store_name", data.store_name);
    formData.append("store_address", data.store_address);
    if (data.cover_image) formData.append("cover_image", data.cover_image);

    post(route("vendor.store"), {
      data: formData,
      forceFormData: true, // 👈 مهم جداً مع الملفات
      preserveScroll: true,
      onSuccess: () => {
        setSuccessMessage("تم تحديث بيانات التاجر.");
        toast.success("تم تحديث بيانات التاجر.");
        Inertia.reload({ only: ["coverImage"] }); // يعيد جلب props.coverImage فقط
      },
      onError: (errs) => {
        console.error("فشل التحديث:", errs);
        toast.error("فشل تحديث البيانات.");
      },
    });
  };

  // --- تدفقات المودال: فتح wizard بعد التأكيد ---
  const openWizardAfterConfirm = () => {
    setShowBecomeVendorConfirmation(false);
    setShowWizard(true);
  };

  console.log(props.latestPendingChanges);

  const closeModal = () => setShowBecomeVendorConfirmation(false);

  return (
    <section className={className}>
      {/* إشعار نجاح عام */}
      {recentlySuccessful && successMessage && (
        <div className="toast toast-top toast-end">
          <div className="alert alert-success">
            <span>{successMessage}</span>
          </div>
        </div>
      )}

      <header>
        <h2 className="flex justify-between mb-8 text-lg font-medium text-gray-900 dark:text-gray-100">
          تفاصيل البائع
          {user.vendor?.status === "pending" && (
            <span className="badge badge-warning">
              {user.vendor.status_label}
            </span>
          )}
          {user.vendor?.status === "rejected" && (
            <span className="badge badge-error">
              {user.vendor.status_label}
            </span>
          )}
          {user.vendor?.status === "approved" && (
            <span className="badge badge-success">
              {user.vendor.status_label}
            </span>
          )}
        </h2>

        {props.latestPendingChanges?.length > 0 && (
          <div className="space-y-4 mt-4">
            {props.latestPendingChanges.map((change) => {
              // صياغة النص حسب نوع الحقل
              let description = "";
              if (change.field === "store_name") {
                description = `طلبك بتغيير اسم المتجر من "${change.old_value}" إلى "${change.new_value}"`;
              } else if (change.field === "cover_image") {
                description = `طلبك بتغيير صورة الغلاف.`;
              } else {
                description = `تم تعديل الحقل "${change.field}".`;
              }

              // تنسيق التاريخ بشكل مقروء
              const reviewedAtFormatted = change.reviewed_at
                ? new Date(change.reviewed_at).toLocaleString("ar-EG", {
                    weekday: "long",
                    year: "numeric",
                    month: "long",
                    day: "numeric",
                    hour: "2-digit",
                    minute: "2-digit",
                  })
                : null;

              return (
                <div
                  key={change.id}
                  className={`p-3 rounded-lg shadow-sm border ${
                    change.status === "pending"
                      ? "bg-yellow-50 border-yellow-200 text-yellow-700"
                      : change.status === "rejected"
                      ? "bg-red-50 border-red-200 text-red-700"
                      : "bg-green-50 border-green-200 text-green-700"
                  }`}
                >
                  <p className="font-medium">{description}</p>

                  <p className="mt-1">
                    {change.status === "pending" && `طلبك رقم (REQ_${change.id}) قيد المراجعة الآن ⏳`}
                    {change.status === "rejected" &&
                      `تم رفض طلبك رقم (REQ_${change.id}). يرجى التواصل معنا على الواتساب لمعرفة التفاصيل ❌`}
                    {change.status === "approved" &&
                      `تمت الموافقة على طلبك رقم (REQ_${change.id})! 🎉`}
                  </p>

                  {reviewedAtFormatted && (
                    <p className="mt-1 text-sm text-gray-500">
                      تمت المراجعة بتاريخ: {reviewedAtFormatted}
                    </p>
                  )}
                </div>
              );
            })}
          </div>
        )}
      </header>

      {/* زر التحول لبائع — يفتح مودال تأكيد أو رابط للـ wizard */}
      <div className="mb-6">
        {!user?.vendor ? (
          <PrimaryButton
            onClick={() => setShowBecomeVendorConfirmation(true)}
            disabled={processing}
          >
            كن بائعاً
          </PrimaryButton>
        ) : // لو هو بائع بالفعل نظهر تحكمات التحديث أدناه
        null}
      </div>

      {/* ------------------------
          WIZARD متعدد الخطوات (Create / Submit request)
          ------------------------- */}
      {showWizard && (
        <form
          onSubmit={handleWizardSubmit}
          className="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 space-y-6"
          encType="multipart/form-data"
        >
          {/* مؤشر الخطوات */}
          <div className="flex items-center justify-between">
            {[1, 2, 3].map((step) => (
              <div
                key={step}
                className={`flex-1 h-1 mx-1 rounded ${
                  currentStep >= step ? "bg-primary" : "bg-gray-300"
                }`}
              />
            ))}
          </div>

          {/* خطوة 1: الاسم والعنوان */}
          {currentStep === 1 && (
            <>
              <div>
                <InputLabel value="اسم المتجر" />
                <TextInput
                  className="mt-1 block w-full"
                  value={data.store_name}
                  onChange={(e) =>
                    setData(
                      "store_name",
                      e.target.value.toLowerCase().replace(/\s+/g, "-")
                    )
                  }
                  required
                />
                <InputError message={errors.store_name} className="mt-2" />
              </div>
              <div>
                <InputLabel value="عنوان المتجر" />
                <textarea
                  className="textarea textarea-bordered w-full mt-1"
                  value={data.store_address}
                  onChange={(e) => setData("store_address", e.target.value)}
                  required
                  placeholder="أدخل عنوان متجرك"
                />
                <InputError message={errors.store_address} className="mt-2" />
              </div>
            </>
          )}

          {/* خطوة 2: رفع الهوية والرخصة */}
          {currentStep === 2 && (
            <>
              <div onDrop={handleDropIdCard} onDragOver={handleDragOver}>
                <InputLabel value="رفع صورة الهوية" />
                <FileInput
                  id="id_card"
                  accept="image/*,.pdf"
                  onChange={(e) =>
                    setData("id_card", e.target.files?.[0] ?? null)
                  }
                />
                <InputError message={errors.id_card} className="mt-2" />
              </div>

              <div onDrop={handleDropTradeLicense} onDragOver={handleDragOver}>
                <InputLabel value="رفع الرخصة التجارية" />
                <FileInput
                  id="trade_license"
                  accept="image/*,.pdf"
                  onChange={(e) =>
                    setData("trade_license", e.target.files?.[0] ?? null)
                  }
                />
                <InputError message={errors.trade_license} className="mt-2" />
              </div>
            </>
          )}

          {/* خطوة 3: مراجعة */}
          {currentStep === 3 && (
            <div className="space-y-4">
              <p className="text-gray-700 dark:text-gray-200">
                يرجى مراجعة البيانات قبل إرسال الطلب:
              </p>
              <ul className="list-disc ml-6 text-sm">
                <li>اسم المتجر: {data.store_name}</li>
                <li>عنوان المتجر: {data.store_address}</li>
                <li>الهوية: {data.id_card?.name ?? "لم يتم رفع ملف"}</li>
                <li>الرخصة: {data.trade_license?.name ?? "لم يتم رفع ملف"}</li>
              </ul>
            </div>
          )}

          {/* أزرار التنقل / الإرسال */}
          <div className="flex justify-between">
            {currentStep > 1 ? (
              <SecondaryButton type="button" onClick={prevStep}>
                رجوع
              </SecondaryButton>
            ) : (
              <SecondaryButton
                type="button"
                onClick={() => setShowWizard(false)}
              >
                إلغاء
              </SecondaryButton>
            )}

            {currentStep < 3 ? (
              <button
                type="button"
                disabled={processing}
                onClick={nextStep}
                className="btn btn-primary"
              >
                التالي
              </button>
            ) : (
              <PrimaryButton type="submit" disabled={processing}>
                إرسال الطلب
              </PrimaryButton>
            )}
          </div>
        </form>
      )}

      {/* ------------------------
          نموذج تعديل بيانات التاجر (لو التاجر موجود وموافق عليه / أو موجود)
          ------------------------- */}
      {user?.vendor && (
        <div className="mt-6">
          {/* لو الحالة approved - نعرض نموذج التحديث الكامل */}
          {user.vendor.status === "approved" && (
            <>
              <form onSubmit={handleUpdateVendor}>
                <div className="mb-4">
                  <InputLabel htmlFor="goto" value="زيارة متجرك من هنا:" />
                  <Link
                    href={route("vendor.profile", user.vendor?.store_name)}
                    className="hover:underline"
                  >
                    <b>{user.vendor?.store_name.replace(/-/g, " ")}</b>
                  </Link>
                </div>

                <div className="mb-4">
                  <InputLabel htmlFor="name" value="اسم المتجر" />
                  <small className="text-yellow-600 font-medium ml-2">
                    ملحوظة: تغيير اسم المتجر يحتاج موافقة ⚠
                  </small>
                  <TextInput
                    id="name"
                    className="mt-1 block w-full"
                    value={data.store_name}
                    onChange={onStoreNameChange}
                    required
                    isFocused
                    autoComplete="name"
                  />
                  <InputError className="mt-2" message={errors.store_name} />
                </div>

                <div className="mb-4">
                  <InputLabel htmlFor="address" value="عنوان المتجر" />
                  <textarea
                    className="textarea textarea-bordered w-full mt-1"
                    value={data.store_address}
                    onChange={(e) => setData("store_address", e.target.value)}
                    placeholder="أدخل عنوان متجرك"
                  />
                  <InputError className="mt-2" message={errors.store_address} />
                </div>

                <div
                  className="mb-4"
                  onDragOver={(e) => e.preventDefault()}
                  onDrop={handleDropCoverImage}
                >
                  <InputLabel htmlFor="cover_image" value="صورة الغلاف" />
                  <small className="text-yellow-600 font-medium ml-2">
                    ملحوظة: تغيير صورة الغلاف يحتاج موافقة ⚠
                  </small>
                  <FileInput
                    id="cover_image"
                    label="انقر لاختيار صورة أو اسحبها هنا"
                    accept="image/*"
                    onChange={(e) => {
                      const file = e.target.files?.[0] ?? null;
                      setData("cover_image", file);
                      setCoverImagePreview(
                        file ? URL.createObjectURL(file) : null
                      );
                    }}
                  />
                  <InputError className="mt-2" message={errors.cover_image} />
                </div>

                {coverImagePreview && (
                  <img
                    src={coverImagePreview}
                    alt="صورة غلاف المتجر"
                    className="w-full h-64 object-cover rounded-lg mb-4"
                  />
                )}

                <div className="flex items-center gap-4">
                  <PrimaryButton disabled={processing}>تحديث</PrimaryButton>
                </div>
              </form>

              <form
                action={route("stripe.connect")}
                method={"post"}
                className={"my-8"}
              >
                <input type="hidden" name="_token" value={token} />
                {user.stripe_account_active && (
                  <div className={"text-center text-gray-600 my-4 text-sm"}>
                    لقد تم الاتصال بنجاح بـ Stripe
                  </div>
                )}
                <button
                  className="btn btn-primary w-full"
                  disabled={user.stripe_account_active}
                >
                  الاتصال بـ Stripe
                </button>
              </form>
            </>
          )}
        </div>
      )}

      {/* ------------------------
          Modal: تأكيد الرغبة في أن تصبح بائعاً
          - بعد التأكيد نفتح wizard لملء البيانات والملفات
          ------------------------- */}
      <Modal show={showBecomeVendorConfirmation} onClose={closeModal}>
        <form
          className="p-8"
          onSubmit={(e) => {
            e.preventDefault();
            openWizardAfterConfirm();
          }}
        >
          <h2 className="text-lg font-medium text-gray-900 dark:text-gray-100">
            هل أنت متأكد من أنك تريد أن تصبح بائعًا؟
          </h2>

          <p className="mt-4 text-sm text-gray-600">
            بعد التأكيد ستحتاج لإدخال اسم المتجر، العنوان، ورفع صورة الهوية
            والرخصة.
          </p>

          <div className="mt-6 flex justify-end">
            <SecondaryButton onClick={closeModal}>إلغاء</SecondaryButton>
            <PrimaryButton className="ms-3">ابدأ</PrimaryButton>
          </div>
        </form>
      </Modal>
    </section>
  );
}

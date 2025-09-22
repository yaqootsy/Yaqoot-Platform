import PrimaryButton from "@/Components/Core/PrimaryButton";
import { Link, useForm, usePage } from "@inertiajs/react";
import React, { FormEventHandler, useState } from "react";
import SecondaryButton from "@/Components/Core/SecondaryButton";
import Modal from "@/Components/Core/Modal";
import InputLabel from "@/Components/Core/InputLabel";
import TextInput from "@/Components/Core/TextInput";
import InputError from "@/Components/Core/InputError";
import FileInput from "@/Components/Core/FileInput";

export default function VendorDetails({
  className = "",
}: {
  className?: string;
}) {
  const [showBecomeVendorConfirmation, setShowBecomeVendorConfirmation] =
    useState(false);
  const [successMessage, setSuccessMessage] = useState("");
  const user = usePage().props.auth.user;
  const token = usePage().props.csrf_token;

  const coverMedia = usePage().props.coverMedia; // هذا رابط URL من السيرفر
  // const coverImage = coverMedia || null; // استخدم الرابط مباشرة
  const [coverImage, setCoverImage] = useState<string | null>(
    typeof coverMedia === "string" ? coverMedia : null
  );

  const { data, setData, errors, post, processing, recentlySuccessful } =
    useForm<{
      store_name: string;
      store_address: string;
      cover_image: File | null; // هنا
    }>({
      store_name:
        user.vendor?.store_name || user.name.toLowerCase().replace(/\s+/g, "-"),
      store_address: user.vendor?.store_address,
      cover_image: null, // القيمة الافتراضية
    });

  const onStoreNameChange = (ev: React.ChangeEvent<HTMLInputElement>) => {
    setData("store_name", ev.target.value.toLowerCase().replace(/\s+/g, "-"));
  };

  const becomeVendor: FormEventHandler = (ev) => {
    ev.preventDefault();

    post(route("vendor.store"), {
      preserveScroll: true,
      onSuccess: () => {
        closeModal();
        setSuccessMessage("يمكنك الآن إنشاء المنتجات ونشرها.");
      },
      onError: (errors) => {},
    });
  };

  const updateVendor: FormEventHandler = (ev) => {
    ev.preventDefault();

    const formData = new FormData();
    formData.append("store_name", data.store_name);
    formData.append("store_address", data.store_address);
    if (data.cover_image) {
      formData.append("cover_image", data.cover_image);
    }

    post(route("vendor.store"), {
      data: formData,
      headers: { "Content-Type": "multipart/form-data" },
      preserveScroll: true,
      onSuccess: () => {
        closeModal();
        setSuccessMessage("تم تحديث بياناتك.");
      },
      onError: (errors) => {},
    });
  };

  const closeModal = () => {
    setShowBecomeVendorConfirmation(false);
  };
  return (
    <section className={className}>
      {recentlySuccessful && (
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
            <span className={"badge badge-warning"}>
              {user.vendor.status_label}
            </span>
          )}
          {user.vendor?.status === "rejected" && (
            <span className={"badge badge-error"}>
              {user.vendor.status_label}
            </span>
          )}
          {user.vendor?.status === "approved" && (
            <span className={"badge badge-success"}>
              {user.vendor.status_label}
            </span>
          )}
        </h2>
      </header>

      <div>
        {!user.vendor && (
          <PrimaryButton
            onClick={(ev) => setShowBecomeVendorConfirmation(true)}
            disabled={processing}
          >
            كن بائعاً
          </PrimaryButton>
        )}

        {user.vendor && (
          <>
            <form onSubmit={updateVendor}>
              <div className="mb-4">
                <InputLabel htmlFor="goto" value="زيارة متجرك من هنا: " />
                <Link
                  href={route("vendor.profile", user.vendor?.store_name)}
                  className="hover:underline"
                >
                  <b>{user.vendor?.store_name.replace(/-/g, " ")}</b>
                </Link>
              </div>
              <div className="mb-4">
                <InputLabel htmlFor="name" value="اسم المتجر" />

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
                <InputLabel htmlFor="name" value="عنوان المتجر" />

                <textarea
                  className="textarea textarea-bordered w-full mt-1"
                  value={data.store_address}
                  onChange={(e) => setData("store_address", e.target.value)}
                  placeholder="أدخل عنوان متجرك"
                ></textarea>

                <InputError className="mt-2" message={errors.store_address} />
              </div>
              <div
                className="mb-4"
                onDragOver={(e) => e.preventDefault()}
                onDrop={(e) => {
                  e.preventDefault();
                  const file = e.dataTransfer.files?.[0] ?? null;
                  setData("cover_image", file);
                  setCoverImage(file ? URL.createObjectURL(file) : null);
                }}
              >
                <InputLabel htmlFor="cover_image" value="صورة الغلاف" />

                <FileInput
                  id="cover_image"
                  label="انقر لاختيار صورة أو اسحبها هنا"
                  accept="image/*"
                  onChange={(e) => {
                    const file = e.target.files?.[0] ?? null;
                    setData("cover_image", file);
                    setCoverImage(file ? URL.createObjectURL(file) : null);
                  }}
                />

                <InputError className="mt-2" message={errors.cover_image} />
              </div>

              {typeof coverImage === "string" && coverImage && (
                <img
                  src={coverImage}
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

      <Modal show={showBecomeVendorConfirmation} onClose={closeModal}>
        <form onSubmit={becomeVendor} className="p-8">
          <h2 className="text-lg font-medium text-gray-900 dark:text-gray-100">
            هل أنت متأكد من أنك تريد أن تصبح بائعًا؟
          </h2>

          <div className="mt-6 flex justify-end">
            <SecondaryButton onClick={closeModal}>إلغاء</SecondaryButton>

            <PrimaryButton className="ms-3" disabled={processing}>
              تأكيد
            </PrimaryButton>
          </div>
        </form>
      </Modal>
    </section>
  );
}

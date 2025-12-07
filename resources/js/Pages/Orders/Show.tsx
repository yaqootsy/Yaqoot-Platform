import React from "react";
import { Link, Head, router } from "@inertiajs/react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { formatPrice } from "@/helpers";

interface VariationType {
  id: number;
  name: string;
}
interface VariationOption {
  id: number;
  name: string;
  variationType: VariationType;
}
interface OrderItem {
  id: number;
  product: {
    id: number;
    title: string;
    slug: string;
    featured_image_url?: string;
    variationTypes?: {
      id: number;
      name: string;
      options?: { id: number; name: string }[];
    }[];
  };
  price: number | string;
  quantity: number;
  variationOptions?: VariationOption[];
  variation_type_option_ids?: number[];
}
interface Country {
  id: number;
  name: string;
}
interface ShippingAddress {
  id: number;
  full_name: string;
  address1: string;
  address2?: string;
  city: string;
  state: string;
  zipcode: string;
  phone: string;
  country: Country;
}
interface Order {
  id: number;
  created_at: string;
  status: string;
  cancelled_by?: string | null;
  cancelled_at?: string | null;
  total_price: number | string;
  tracking_code?: string;
  tracking_code_added_at?: string | null;
  orderItems?: OrderItem[];
  shippingAddress?: ShippingAddress;
}

// ---------- helpers ----------
const getStatusLabel = (status: string) => {
  switch (status.toLowerCase()) {
    case "pending":
      return "بانتظار الموافقة";
    case "processing":
      return "جارٍ التجهيز";
    case "shipped":
      return "في الطريق";
    case "delivered":
      return "تم التسليم";
    case "cancelled":
      return "ملغى";
    default:
      return status;
  }
};

// status step index for visual progress (adjust keys to your statuses)
const statusStepIndex = (status: string) => {
  switch (status.toLowerCase()) {
    case "pending":
      return 0;
    case "processing":
      return 1;
    case "shipped":
      return 2;
    case "delivered":
      return 3;
    case "cancelled":
      return 4;
    default:
      return 0;
  }
};

const niceDate = (iso?: string | null) => {
  if (!iso) return "-";
  try {
    return new Date(iso).toLocaleString();
  } catch {
    return iso;
  }
};

const formatNumberPrice = (value: number | string) =>
  formatPrice(
    typeof value === "string" ? parseFloat(value || "0") : value || 0
  );

// extract variation options (same logic you had)
const getVariationOptionsFromItem = (item: OrderItem): VariationOption[] => {
  if (item.variationOptions && item.variationOptions.length)
    return item.variationOptions;
  const selectedIds = item.variation_type_option_ids || [];
  const types = item.product?.variationTypes || [];
  const res: VariationOption[] = [];
  for (const vt of types) {
    for (const opt of vt.options || []) {
      if (selectedIds.includes(opt.id)) {
        res.push({
          id: opt.id,
          name: opt.name,
          variationType: { id: vt.id, name: vt.name },
        });
      }
    }
  }
  return res;
};

// ---------- component ----------
export default function Show({ order }: { order: Order }) {
  const items = order.orderItems || [];
  const subtotal = items.reduce((acc, it) => {
    const price =
      typeof it.price === "string" ? parseFloat(it.price) || 0 : it.price || 0;
    return acc + price * (it.quantity || 0);
  }, 0);

  const step = statusStepIndex(order.status);

  const canCancel = ["pending", "processing"].includes(
    order.status.toLowerCase()
  );

  const handleCancel = () => {
    if (!confirm("هل أنت متأكد من إلغاء الطلب؟ لا يمكن التراجع.")) return;
    router.post(`/orders/${order.id}/cancel`);
  };

  const copyTracking = async () => {
    if (!order.tracking_code) return;
    try {
      await navigator.clipboard.writeText(order.tracking_code);
      alert("تم نسخ رمز التتبع إلى الحافظة");
    } catch {
      // fallback
      alert("تعذر نسخ رمز التتبع — الرجاء نسخه يدوياً");
    }
  };

  return (
    <AuthenticatedLayout>
      <Head title={`الطلب #${order.id}`} />
      <div className="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
        {/* Header */}
        <div className="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6">
          <div>
            <h1 className="text-2xl md:text-3xl font-semibold">
              الطلب #{order.id}
            </h1>
            <p className="text-sm text-base-content/70 mt-1">
              تم الإنشاء: {niceDate(order.created_at)}
            </p>
            {order.tracking_code && (
              <p className="text-sm text-base-content/70 mt-1">
                رمز التتبع:{" "}
                <span className="font-medium">{order.tracking_code}</span>
                <button
                  onClick={copyTracking}
                  className="btn btn-xs btn-ghost ml-2"
                >
                  نسخ
                </button>
              </p>
            )}
          </div>

          <div className="flex items-center gap-2">
            <Link
              href={`/orders/${order.id}/invoice`}
              target="_blank"
              className="btn btn-outline btn-sm"
            >
              طباعة الفاتورة
            </Link>

            <Link href="/orders" className="btn btn-ghost btn-sm">
              العودة
            </Link>

            {canCancel && (
              <button onClick={handleCancel} className="btn btn-error btn-sm">
                إلغاء الطلب
              </button>
            )}
          </div>
        </div>

        {/* Main layout: left content + right summary on large screens */}
        <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
          {/* Left: content (spans 2 cols on large) */}
          <div className="lg:col-span-2 space-y-6">
            {/* Status timeline */}
            <div className="card bg-base-100 p-4">
              <div className="mb-2">
                <h3 className="text-lg font-medium">مراحل الطلب</h3>
              </div>

              <div className="w-full">
                <ol className="flex items-center justify-between">
                  {[
                    { key: "pending", label: "تم الطلب" },
                    { key: "processing", label: "قيد التجهيز" },
                    { key: "shipped", label: "تم الشحن" },
                    { key: "delivered", label: "تم التسليم" },
                  ].map((s, idx) => {
                    const active =
                      idx <= step && order.status.toLowerCase() !== "cancelled";
                    return (
                      <li key={s.key} className="flex-1 text-center">
                        <div className="flex flex-col items-center">
                          <div
                            className={`w-9 h-9 rounded-full flex items-center justify-center ${
                              active
                                ? "bg-primary text-white"
                                : "bg-base-200 text-base-content/70"
                            }`}
                          >
                            {active ? (
                              <svg
                                xmlns="http://www.w3.org/2000/svg"
                                className="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                              >
                                <path
                                  strokeLinecap="round"
                                  strokeLinejoin="round"
                                  strokeWidth={2}
                                  d="M5 13l4 4L19 7"
                                />
                              </svg>
                            ) : (
                              <span className="text-sm font-medium">
                                {idx + 1}
                              </span>
                            )}
                          </div>
                          <span className="mt-2 text-xs">{s.label}</span>
                        </div>

                        {/* connector */}
                        {idx < 3 && (
                          <div
                            className={`absolute left-0 right-0 top-6 z-0 pointer-events-none`}
                            style={{ height: 2 }}
                          >
                            {/* We'll use a pseudo connector via background gradient on the parent, simpler approach below */}
                          </div>
                        )}
                      </li>
                    );
                  })}
                </ol>

                {/* small description */}
                <div className="mt-4 text-sm text-base-content/70">
                  <div className="font-medium">
                    {getStatusLabel(order.status)}
                  </div>
                  <div className="mt-1">
                    {(() => {
                      switch (order.status.toLowerCase()) {
                        case "pending":
                          return "لقد تم تسجيل طلبك وهو الآن بانتظار تأكيد التاجر.";
                        case "processing":
                          return "يتم حالياً تجهيز طلبك استعداداً للشحن.";
                        case "shipped":
                          return "طلبك في الطريق — يمكنك متابعة رمز التتبع إذا كان متوفراً.";
                        case "delivered":
                          return "تم تسليم طلبك. شكراً لتسوقك معنا!";
                        case "cancelled":
                          return "تم إلغاء الطلب.";
                        default:
                          return "";
                      }
                    })()}
                  </div>
                </div>
              </div>
            </div>

            {/* Shipping address */}
            {order.shippingAddress && (
              <div className="card bg-base-100 p-4">
                <h3 className="text-lg font-medium mb-2">عنوان الشحن</h3>
                <div className="text-sm text-base-content/80 space-y-1">
                  <div className="font-medium">
                    {order.shippingAddress.full_name}
                  </div>
                  <div>
                    {order.shippingAddress.address1}{" "}
                    {order.shippingAddress.address2 ?? ""}
                  </div>
                  <div>
                    {order.shippingAddress.city}, {order.shippingAddress.state}{" "}
                    {order.shippingAddress.zipcode}
                  </div>
                  <div>{order.shippingAddress.country?.name}</div>
                  <div className="mt-1">
                    هاتف: {order.shippingAddress.phone}
                  </div>
                </div>
              </div>
            )}

            {/* Items list */}
            <div className="card bg-base-100 p-0">
              <div className="p-4 border-b border-base-200">
                <h3 className="text-lg font-medium">
                  عناصر الطلب ({items.length})
                </h3>
              </div>

              <div className="p-4 space-y-4">
                {items.map((item) => {
                  const variations = getVariationOptionsFromItem(item);
                  const priceNum =
                    typeof item.price === "string"
                      ? parseFloat(item.price) || 0
                      : item.price || 0;
                  return (
                    <div key={item.id} className="flex gap-4 items-center">
                      <div className="w-20 h-20 flex-shrink-0 rounded-md overflow-hidden border bg-base-200">
                        {item.product?.featured_image_url ? (
                          <img
                            src={item.product.featured_image_url}
                            alt={item.product.title}
                            className="w-full h-full object-cover"
                          />
                        ) : (
                          <div className="flex items-center justify-center h-full text-sm text-base-content/60">
                            No image
                          </div>
                        )}
                      </div>

                      <div className="flex-1">
                        <Link
                          href={`/product/${item.product.slug}`}
                          className="font-medium hover:underline"
                        >
                          {item.product.title}
                        </Link>
                        <div className="text-sm text-base-content/70 mt-1">
                          {variations.length > 0 ? (
                            <div className="flex flex-wrap gap-2 text-xs">
                              {variations.map((v) => (
                                <span
                                  key={v.id}
                                  className="px-2 py-0.5 bg-base-200 rounded text-xs"
                                >
                                  {v.variationType.name}: {v.name}
                                </span>
                              ))}
                            </div>
                          ) : (
                            <span className="text-xs">—</span>
                          )}
                        </div>
                      </div>

                      <div className="text-right w-36">
                        <div className="text-sm text-base-content/70">
                          السعر
                        </div>
                        <div className="font-medium">
                          {formatNumberPrice(priceNum)}
                        </div>

                        <div className="text-sm text-base-content/70 mt-2">
                          كمية
                        </div>
                        <div>{item.quantity}</div>

                        <div className="text-sm text-base-content/70 mt-2">
                          الإجمالي
                        </div>
                        <div className="font-medium">
                          {formatNumberPrice(priceNum * (item.quantity || 0))}
                        </div>
                      </div>
                    </div>
                  );
                })}
              </div>

              {/* totals */}
              <div className="p-4 border-t border-base-200 bg-base-100">
                <div className="flex justify-end gap-4 items-center">
                  <div className="text-sm text-base-content/70">
                    المجموع الفرعي:
                  </div>
                  <div className="font-medium">
                    {formatNumberPrice(subtotal)}
                  </div>
                </div>

                <div className="flex justify-end gap-4 items-center mt-2">
                  <div className="text-sm text-base-content/70">الإجمالي:</div>
                  <div className="text-lg font-semibold">
                    {formatNumberPrice(order.total_price)}
                  </div>
                </div>
              </div>
            </div>
          </div>

          {/* Right: summary card */}
          <aside className="space-y-4">
            <div className="sticky top-24">
              <div className="card bg-base-100 p-4 shadow">
                <h4 className="text-lg font-medium mb-2">ملخّص الطلب</h4>

                <div className="text-sm text-base-content/70 space-y-2">
                  <div className="flex justify-between">
                    <div>رقم الطلب</div>
                    <div className="font-medium">#{order.id}</div>
                  </div>
                  <div className="flex justify-between">
                    <div>تاريخ الطلب</div>
                    <div>{niceDate(order.created_at)}</div>
                  </div>
                  <div className="flex justify-between">
                    <div>عدد المنتجات</div>
                    <div>{items.length}</div>
                  </div>
                  <div className="flex justify-between">
                    <div>حالة الدفع</div>
                    <div className="font-medium">
                      {getStatusLabel(order.status)}
                    </div>
                  </div>

                  {order.tracking_code && (
                    <div className="mt-2">
                      <div className="text-xs text-base-content/70">
                        رمز التتبع
                      </div>
                      <div className="font-medium">{order.tracking_code}</div>
                      <div className="mt-2 flex gap-2">
                        <button
                          onClick={copyTracking}
                          className="btn btn-xs btn-ghost"
                        >
                          نسخ
                        </button>
                        <Link
                          href={`/tracking/${order.tracking_code}`}
                          className="btn btn-xs btn-outline"
                        >
                          عرض تتبع
                        </Link>
                      </div>
                    </div>
                  )}

                  <div className="mt-4 border-t pt-3">
                    <div className="flex justify-between text-sm text-base-content/70">
                      <div>المجموع الفرعي</div>
                      <div>{formatNumberPrice(subtotal)}</div>
                    </div>
                    <div className="flex justify-between text-sm text-base-content/70 mt-1">
                      <div>الشحن</div>
                      <div>{/* احتمالي: قيمة الشحن */}—</div>
                    </div>
                    <div className="flex justify-between text-lg font-semibold mt-3">
                      <div>الإجمالي</div>
                      <div>{formatNumberPrice(order.total_price)}</div>
                    </div>
                  </div>

                  <div className="mt-4 flex flex-col gap-2">
                    <Link
                      href={`/orders/${order.id}/invoice`}
                      target="_blank"
                      className="btn btn-primary btn-sm w-full"
                    >
                      طباعة الفاتورة
                    </Link>
                    {canCancel && (
                      <button
                        onClick={handleCancel}
                        className="btn btn-error btn-sm w-full"
                      >
                        إلغاء الطلب
                      </button>
                    )}
                  </div>
                </div>
              </div>

              {/* optional: timeline of events / history */}
              <div className="card bg-base-100 p-4 mt-4">
                <h4 className="text-sm font-medium mb-2">سجل الأحداث</h4>
                <div className="text-sm text-base-content/70">
                  <div className="py-1">
                    إنشاء الطلب: {niceDate(order.created_at)}
                  </div>
                  {order.tracking_code_added_at && (
                    <div className="py-1">
                      أضيف رمز التتبع: {niceDate(order.tracking_code_added_at)}
                    </div>
                  )}
                  {order.cancelled_at && (
                    <div className="py-1 text-red-600">
                      تم الإلغاء: {niceDate(order.cancelled_at)}
                    </div>
                  )}
                </div>
              </div>
            </div>
          </aside>
        </div>
      </div>
    </AuthenticatedLayout>
  );
}

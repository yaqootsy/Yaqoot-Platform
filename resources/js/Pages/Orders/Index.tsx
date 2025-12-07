import React from "react";
import { Link } from "@inertiajs/react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";
import { formatPrice } from "@/helpers";
import Pagination from "@/Components/Core/Pagination";

interface OrderItem {
  id: number;
  product: {
    id: number;
    title: string;
    slug: string;
  };
  price: number;
  quantity: number;
}

interface ShippingAddress {
  full_name: string;
  address1: string;
  address2?: string;
  city: string;
  state: string;
  zipcode: string;
  country: {
    id: number;
    name: string;
  };
}

interface PaginationMeta {
  current_page: number;
  from: number;
  last_page: number;
  links: Array<{
    url: string | null;
    label: string;
    active: boolean;
  }>;
  path: string;
  per_page: number;
  to: number;
  total: number;
}

interface Paginator<T> {
  data: T[];
  links: {
    first: string | null;
    last: string | null;
    prev: string | null;
    next: string | null;
  };
  meta: PaginationMeta;
}

interface Order {
  id: number;
  created_at: string;
  status: string;
  total_price: number;
  tracking_code?: string;
  tracking_code_added_at?: string;
  orderItems: OrderItem[];
  shippingAddress?: ShippingAddress;
}

const getStatusBadgeClass = (status: string): string => {
  switch (status.toLowerCase()) {
    case "pending":
      return "bg-yellow-100 text-yellow-800";
    case "processing":
      return "bg-sky-100 text-sky-800";
    case "shipped":
      return "bg-indigo-100 text-indigo-800";
    case "delivered":
      return "bg-green-100 text-green-800";
    case "cancelled":
      return "bg-red-100 text-red-800";
    default:
      return "bg-gray-100 text-gray-800";
  }
};

const getStatusLabel = (status: string): string => {
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
      return "ملغي";
    default:
      return status;
  }
};

export default function Index({ orders }: { orders: Paginator<Order> }) {
  return (
    <AuthenticatedLayout>
      <Head title="طلباتي" />

      <div className="container mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div className="mb-6">
          <h1 className="text-2xl md:text-3xl font-semibold text-base-content">طلباتي</h1>
          <p className="mt-2 text-sm text-base-content/70">
            اعرض سجل طلباتك، تحقق من الحالة، وقم بإدارة مشترياتك.
          </p>
        </div>

        {orders.data.length === 0 ? (
          <div className="text-center py-12">
            <svg
              className="mx-auto h-16 w-16 text-base-content opacity-30"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                strokeLinecap="round"
                strokeLinejoin="round"
                strokeWidth={1.5}
                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"
              />
            </svg>
            <h3 className="mt-4 text-lg font-medium text-base-content">لا توجد طلبات</h3>
            <p className="mt-1 text-sm text-base-content/70">لم تقم بإجراء أي طلبات حتى الآن.</p>
            <div className="mt-6">
              <Link href="/" className="btn btn-primary btn-md">
                متابعة التسوق
              </Link>
            </div>
          </div>
        ) : (
          <>
            {/* Desktop table (visible on lg and above) */}
            <div className="hidden lg:block">
              <div className="overflow-x-auto bg-white shadow-sm rounded-lg">
                <table className="min-w-full divide-y divide-base-200">
                  <thead className="bg-base-100">
                    <tr>
                      <th className="px-4 py-3 text-center text-sm font-medium text-base-content/80">رقم الطلب</th>
                      <th className="px-4 py-3 text-center text-sm font-medium text-base-content/80">التاريخ</th>
                      <th className="px-4 py-3 text-center text-sm font-medium text-base-content/80">الحالة</th>
                      <th className="px-4 py-3 text-center text-sm font-medium text-base-content/80">الإجمالي</th>
                      <th className="px-4 py-3 text-center text-sm font-medium text-base-content/80">العناصر</th>
                      <th className="px-4 py-3 text-center text-sm font-medium text-base-content/80">الإجراءات</th>
                    </tr>
                  </thead>
                  <tbody className="bg-white divide-y divide-base-200">
                    {orders.data.map((order) => (
                      <tr key={order.id} className="hover:bg-base-200/40">
                        <td className="px-4 py-4 text-center text-sm text-base-content">#{order.id}</td>
                        <td className="px-4 py-4 text-center text-sm text-base-content">
                          {new Date(order.created_at).toLocaleString()}
                        </td>
                        <td className="px-4 py-4 text-center text-sm">
                          <span className={`inline-flex items-center px-3 py-1 rounded-full text-xs font-medium ${getStatusBadgeClass(order.status)}`}>
                            {getStatusLabel(order.status)}
                          </span>
                        </td>
                        <td className="px-4 py-4 text-center text-sm text-base-content">{formatPrice(order.total_price)}</td>
                        <td className="px-4 py-4 text-center text-sm text-base-content">{order.orderItems?.length ?? 0}</td>
                        <td className="px-4 py-4 text-center text-right text-sm">
                          <div className="flex items-center justify-end gap-2">
                            <Link href={`/orders/${order.id}`} className="btn btn-sm btn-primary">
                              عرض
                            </Link>
                            <Link href={`/orders/${order.id}/invoice`} className="btn btn-sm btn-outline btn-secondary" target="_blank">
                              فاتورة
                            </Link>
                          </div>
                        </td>
                      </tr>
                    ))}
                  </tbody>
                </table>
              </div>
            </div>

            {/* Mobile cards (visible on small screens) */}
            <div className="space-y-4 lg:hidden">
              {orders.data.map((order) => (
                <div key={order.id} className="bg-white shadow rounded-lg p-4">
                  <div className="flex items-start justify-between">
                    <div>
                      <div className="flex items-center gap-2">
                        <h3 className="text-sm font-semibold text-base-content">طلب #{order.id}</h3>
                        <span className={`text-xs px-2 py-0.5 rounded ${getStatusBadgeClass(order.status)}`}>
                          {getStatusLabel(order.status)}
                        </span>
                      </div>
                      <p className="text-xs text-base-content/70 mt-1">{new Date(order.created_at).toLocaleString()}</p>
                    </div>

                    <div className="text-right">
                      <p className="text-sm font-medium">{formatPrice(order.total_price)}</p>
                      <p className="text-xs text-base-content/70">{order.orderItems?.length ?? 0} عناصر</p>
                    </div>
                  </div>

                  {/* optional shipping address preview */}
                  {order.shippingAddress && (
                    <div className="mt-3 text-sm text-base-content/70">
                      <div>{order.shippingAddress.full_name}</div>
                      <div className="truncate">{order.shippingAddress.address1} {order.shippingAddress.address2 ?? ''}</div>
                      <div>{order.shippingAddress.city} — {order.shippingAddress.country?.name}</div>
                    </div>
                  )}

                  <div className="mt-3 flex gap-2">
                    <Link href={`/orders/${order.id}`} className="btn btn-sm btn-primary flex-1">
                      عرض التفاصيل
                    </Link>
                    <Link href={`/orders/${order.id}/invoice`} target="_blank" className="btn btn-sm btn-outline btn-secondary">
                      فاتورة
                    </Link>
                  </div>
                </div>
              ))}
            </div>
          </>
        )}

        {/* Pagination Controls */}
        {orders.data.length > 0 && (
          <div className="mt-6">
            <Pagination links={orders.meta.links} />
          </div>
        )}
      </div>
    </AuthenticatedLayout>
  );
}

import React from 'react';
import { Link } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import { formatPrice } from '@/helpers';
import Pagination from '@/Components/Core/Pagination';

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

// Pagination meta data interface
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

// Paginator interface
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

// Helper function to get badge class based on order status
const getStatusBadgeClass = (status: string): string => {
  switch (status.toLowerCase()) {
    case 'completed':
      return 'badge-success';
    case 'processing':
      return 'badge-info';
    case 'pending':
      return 'badge-warning';
    case 'cancelled':
      return 'badge-error';
    case 'shipped':
      return 'badge-primary';
    case 'draft':
      return 'badge-ghost';
    default:
      return 'badge-neutral';
  }
};

export default function Index({ orders }: { orders: Paginator<Order> }) {
  return (
    <AuthenticatedLayout>
      <Head title="My Orders" />

      <div className="container mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div className="mb-8">
          <h1 className="text-3xl font-semibold text-base-content">طلبياتي</h1>
          <p className="mt-2 text-sm text-base-content/70">
            اعرض سجل طلباتك، وتحقق من الحالة، وقم بإدارة مشترياتك.
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
            <p className="mt-1 text-sm text-base-content/70">
              لم تقم بإجراء أي طلبات حتى الآن.
            </p>
            <div className="mt-6">
              <Link
                href="/"
                className="btn btn-primary btn-md"
              >
                متابعة التسوق
              </Link>
            </div>
          </div>
        ) : (
          <div className="overflow-x-auto">
            <table className="table table-zebra w-full">
              <thead>
                <tr>
                  <th>رقم الطلب</th>
                  <th>التاريخ</th>
                  <th>الحالة</th>
                  <th>الإجمالي</th>
                  <th>العناصر</th>
                  <th className="text-right">الإجراءات</th>
                </tr>
              </thead>
              <tbody>
                {orders.data.map((order) => (
                  <tr key={order.id} className="hover">
                    <td>
                      #{order.id}
                    </td>
                    <td>
                      {new Date(order.created_at).toLocaleDateString()}
                    </td>
                    <td>
                      <span
                        className={`badge ${getStatusBadgeClass(order.status)}`}
                      >
                        {order.status}
                      </span>
                    </td>
                    <td>
                      {formatPrice(order.total_price)}
                    </td>
                    <td>
                      {order.orderItems ? order.orderItems.length : 0}
                    </td>
                    <td className="text-right">
                      <div className="flex justify-end space-x-2">
                        <Link
                          href={`/orders/${order.id}`}
                          className="btn btn-sm btn-primary"
                        >
                          عرض التفاصيل
                        </Link>
                        <Link
                          href={`/orders/${order.id}/invoice`}
                          target="_blank"
                          className="btn btn-sm btn-outline btn-secondary"
                        >
                          الفاتورة
                        </Link>
                      </div>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
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

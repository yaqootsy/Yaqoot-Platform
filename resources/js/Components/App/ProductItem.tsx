import { Product, ProductListItem } from "@/types";
import { Link, useForm } from "@inertiajs/react";
import CurrencyFormatter from "@/Components/Core/CurrencyFormatter";
import placeholderImage from "@/assets/images/placeholder.png";
export default function ProductItem({ product }: { product: ProductListItem }) {
  const isVendorClosed = product.is_temporarily_closed === true;  
  const form = useForm<{
    option_ids: Record<string, number>;
    quantity: number;
  }>({
    option_ids: {},
    quantity: 1,
  });

  const addToCart = () => {
    if (isVendorClosed) return; // منع الإضافة من الواجهة

    form.post(route("cart.store", product.id), {
      preserveScroll: true,
      preserveState: true,
      onError: (err) => {
        console.error(err);
      },
    });
  };
  
  return (
    <div className={`card bg-base-100 shadow ${isVendorClosed ? "opacity-50" : ""}`}>
      <Link className="p-3" href={route("product.show", product.slug)}>
        <figure>
          <img
            src={product.image ? product.image : placeholderImage}
            alt={product.title}
            className="w-full h-48 aspect-square object-contain"
          />
        </figure>
      </Link>
      <div className="card-body p-6">
        {isVendorClosed && (
          <div className="text-red-600 text-xs mb-2">
            المتجر مغلق — لا يمكن الشراء الآن
          </div>
        )}
        <Link href={route("product.show", product.slug)}>
          <h2 className="card-title text-sm">
            {product.title && product.title.length > 50
              ? product.title.substring(0, 90) + "..."
              : product.title}
          </h2>
        </Link>
        <p className={"text-sm"}>
          بواسطة{" "}
          <Link
            href={route("vendor.profile", product.user_store_name)}
            className="hover:underline"
          >
            <b>{product.user_store_name.replace(/-/g, " ")}</b>
          </Link>
          &nbsp; في{" "}
          <Link
            href={route("product.byDepartment", product.department_slug)}
            className="hover:underline"
          >
            <b>{product.department_name}</b>
          </Link>
        </p>

        {product.distance && (
          <p className="text-gray-500 text-sm">
            📍 يبعد {product.distance} — ⏱ {product.duration}
          </p>
        )}

        <div className="card-actions items-center justify-between mt-3">
          <button
            onClick={addToCart}
            disabled={isVendorClosed}
            className={`btn btn-light btn-sm ${isVendorClosed ? "btn-disabled cursor-not-allowed" : ""}`}
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="20"
              height="20"
              viewBox="0 0 18 18"
              fill="none"
            >
              <path
                d="M1.125 4.56689H3.18573L3.803 7.31653L5.13521 13.2495H14.7469L16.3343 7.87281"
                stroke="#454956"
                stroke-width="1.3"
                stroke-linecap="round"
                stroke-linejoin="round"
              />
              <path
                d="M6.94436 16.5C7.50644 16.5 7.96209 16.0444 7.96209 15.4823C7.96209 14.9202 7.50644 14.4646 6.94436 14.4646C6.38229 14.4646 5.92664 14.9202 5.92664 15.4823C5.92664 16.0444 6.38229 16.5 6.94436 16.5Z"
                fill="#454956"
              />
              <path
                d="M13.3427 16.5C13.9048 16.5 14.3604 16.0444 14.3604 15.4823C14.3604 14.9202 13.9048 14.4646 13.3427 14.4646C12.7806 14.4646 12.325 14.9202 12.325 15.4823C12.325 16.0444 12.7806 16.5 13.3427 16.5Z"
                fill="#454956"
              />
              <path
                d="M10.162 3V8.97255"
                stroke="#454956"
                stroke-width="1.5"
                stroke-linecap="round"
              />
              <path
                d="M13.1483 5.98631H7.17544"
                stroke="#454956"
                stroke-width="1.5"
                stroke-linecap="round"
              />
            </svg>
          </button>
          <span className="text-xl">
            <CurrencyFormatter amount={product.price} />
          </span>
        </div>
      </div>
    </div>
  );
}

import React from "react";
import {
  PageProps,
  PaginationProps,
  Product,
  ProductListItem,
  Vendor,
} from "@/types";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, usePage } from "@inertiajs/react";
import { Configure, Pagination, SortBy, useHits } from "react-instantsearch";
import ProductItem from "@/Components/App/ProductItem";
import FilterPanel from "@/Components/App/FilterPanel";
import NumberFormatter from "@/Components/Core/NumberFormatter";
import ProductListing from "@/Components/App/ProductListing";
import BannerSlider from "@/Components/App/BannerSlider";

function CustomHits() {
  const { hits, results } = useHits();

  if (!results || results.nbHits === 0) {
    return (
      <div className="w-full py-8 text-center">
        <div className="card bg-base-100 shadow-xl">
          <div className="card-body">
            <h2 className="text-xl font-semibold">
              لم يتم العثور على أي منتجات
            </h2>
            <p>حاول تعديل عوامل التصفية أو معايير البحث</p>
          </div>
        </div>
      </div>
    );
  }

  return (
    <>
      <div className="mb-4 flex justify-between items-center">
        <p className="text-gray-500">
          عرض{" "}
          <span className="font-bold">
            <NumberFormatter amount={results.nbHits} />
          </span>{" "}
          منتجات في{" "}
          <span className="font-bold">{results.processingTimeMS}ms</span>
        </p>

        <div className="flex items-center justify-end">
          ترتيب حسب:
          <SortBy
            classNames={{
              root: "flex ml-4 justify-end",
              select: "select select-bordered",
            }}
            items={[
              { label: "الأكثر رواجاً", value: "products_index" },
              {
                label: "العنوان تصاعدي",
                value: "products_index/sort/title:asc",
              },
              {
                label: "العنوان التنازلي",
                value: "products_index/sort/title:desc",
              },
              {
                label: "السعر: من الأقل إلى الأعلى",
                value: "products_index/sort/price:asc",
              },
              {
                label: "السعر: من الأعلى إلى الأقل",
                value: "products_index/sort/price:desc",
              },
              // {
              //   label: "الأفضل تقييماً",
              //   value: "products_index/sort/rate:desc",
              // },
            ]}
          />
        </div>
      </div>
      <div className="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3">
        {hits.map((hit: any) => (
          <ProductItem product={hit} key={hit.id} />
        ))}
      </div>
    </>
  );
}

function Profile({
  vendor,
  products,
  coverImage,
}: PageProps<{
  vendor: Vendor;
  products: PaginationProps<ProductListItem>;
  coverImage: string | null;
}>) {
  return (
    <AuthenticatedLayout
      searchPlaceholder={`بحث في متجر ${vendor.store_name.replace(/-/g, " ")}`}
    >
      <Head title={vendor.store_name} />

      <div
        className="hero min-h-[400px]"
        style={{
          backgroundImage: `url(${coverImage})`,
        }}
      >
        <div className="hero-overlay bg-opacity-60"></div>
        <div className="hero-content text-neutral-content text-center">
          <div className="max-w-[700px]">
            <h1 className="mb-5 text-5xl font-bold">
              <b>{vendor.store_name.replace(/-/g, " ")}</b>
            </h1>
          </div>
        </div>
      </div>

      {/* <ProductListing products={products} /> */}

      <div className="container py-8 px-4 mx-auto">
        <div className="flex flex-col md:flex-row gap-8">
          <FilterPanel />

          <div className="flex-1">
            <Configure hitsPerPage={24} filters={`user_id:${vendor.user_id}`} />

            <CustomHits />
            <Pagination
              classNames={{
                root: "hidden justify-center md:flex",
                list: "join mt-8",
                item: "join-item btn",
                pageItem: "",
                link: "",
                selectedItem: "btn-primary",
              }}
            />
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  );
}

export default Profile;

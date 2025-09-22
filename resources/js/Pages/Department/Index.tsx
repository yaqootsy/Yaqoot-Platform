import React from "react";
import {
  Department,
  PageProps,
  PaginationProps,
  Product,
  ProductListItem,
} from "@/types";
import { Head } from "@inertiajs/react";
import ProductListing from "@/Components/App/ProductListing";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import ProductItem from "@/Components/App/ProductItem";
import { Configure, Pagination, SortBy, useHits } from "react-instantsearch";
import NumberFormatter from "@/Components/Core/NumberFormatter";
import FilterPanel from "@/Components/App/FilterPanel";

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

function Index({
  appName,
  department,
  products,
}: PageProps<{
  department: Department;
  products: PaginationProps<ProductListItem>;
}>) {
  return (
    <AuthenticatedLayout searchPlaceholder={`بحث في قسم ${department.name}`}>
      <Head>
        <title>{department.name}</title>
        <meta name="title" content={department.meta_title} />
        <meta name="description" content={department.meta_description} />
        <link
          rel="canonical"
          href={route("product.byDepartment", department.slug)}
        />

        <meta property="og:title" content={department.name} />
        <meta property="og:description" content={department.meta_description} />
        <meta
          property="og:url"
          content={route("product.byDepartment", department.slug)}
        />
        <meta property="og:type" content="website" />
        <meta property="og:site_name" content={appName} />
      </Head>

      <div className="container mx-auto">
        <div className="hero bg-base-200 min-h-[120px]">
          <div className="hero-content text-center">
            <div className="max-w-lg">
              <h1 className="text-5xl font-bold">قسم "{department.name}"</h1>
            </div>
          </div>
        </div>

        {/* <ProductListing products={products} /> */}

        <div className="container py-8 px-4 mx-auto">
          <div className="flex flex-col md:flex-row gap-8">
            <FilterPanel />

            <div className="flex-1">
              <Configure
                hitsPerPage={24}
                filters={`department_name:${department.name}`}
              />

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
      </div>
    </AuthenticatedLayout>
  );
}

export default Index;

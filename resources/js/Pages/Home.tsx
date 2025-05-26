import {PageProps, PaginationProps, Product} from '@/types';
import {Head} from '@inertiajs/react';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import React from "react";
import {
  Configure,
  Pagination, SortBy,
  useHits
} from "react-instantsearch";
import ProductItem from "@/Components/App/ProductItem";
import FilterPanel from "@/Components/App/FilterPanel";
import NumberFormatter from "@/Components/Core/NumberFormatter";


function CustomHits() {
  const {hits, results} = useHits();

  if (!results || results.nbHits === 0) {
    return (
      <div className="w-full py-8 text-center">
        <div className="card bg-base-100 shadow-xl">
          <div className="card-body">
            <h2 className="text-xl font-semibold">No products found</h2>
            <p>Try adjusting your filters or search criteria</p>
          </div>
        </div>
      </div>
    );
  }

  return (
    <>
      <div className="mb-4 flex justify-between items-center">
        <p className="text-gray-500">
          Showing <span className="font-bold">
          <NumberFormatter amount={results.nbHits}/>
        </span> products in <span className="font-bold">{results.processingTimeMS}ms</span>
        </p>

        <div className="flex items-center justify-end">
          Sort By:
          <SortBy
            classNames={{
              root: "flex ml-4 justify-end",
              select: "select select-bordered",
            }}
            items={[
              {label: "Relevance", value: "products_index"},
              {
                label: "Title Ascending",
                value: "products_index/sort/title:asc",
              },
              {
                label: "Title Descending",
                value: "products_index/sort/title:desc",
              },
              {
                label: "Price Ascending",
                value: "products_index/sort/price:asc",
              },
              {
                label: "Price Descending",
                value: "products_index/sort/price:desc",
              },
            ]}
          />
        </div>
      </div>
      <div className="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3">
        {hits.map((hit: any) => (
          <ProductItem product={hit} key={hit.id}/>
        ))}
      </div>
    </>
  );
}

export default function Home({
                               products
                             }: PageProps<{ products: PaginationProps<Product> }>) {

  return (
    <AuthenticatedLayout>
      <Head title="Home"/>
      <div className="hero bg-base-200 h-[300px]">
        <div className="hero-content text-center">
          <div className="max-w-md">
            <h1 className="text-5xl font-bold">Hello there</h1>
            <p className="py-6">
              Provident cupiditate voluptatem et in. Quaerat fugiat ut assumenda excepturi exercitationem
              quasi. In deleniti eaque aut repudiandae et a id nisi.
            </p>
            <button className="btn btn-primary">Get Started</button>
          </div>
        </div>
      </div>

      {/*<ProductListing products={products}/>*/}

      <div className="container py-8 px-4 mx-auto">
        <div className="flex flex-col md:flex-row gap-8">
          <FilterPanel/>

          <div className="flex-1">

            <Configure hitsPerPage={24}/>
            <CustomHits/>
            <Pagination
              classNames={{
                root: 'hidden justify-center md:flex',
                list: 'join mt-8',
                item: 'join-item btn',
                pageItem: '',
                link: '',
                selectedItem: 'btn-primary',
              }}
            />
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  );
}

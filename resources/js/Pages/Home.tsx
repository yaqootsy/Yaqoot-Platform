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
import ProductListing from "@/Components/App/ProductListing";
import BannerSlider from "@/Components/App/BannerSlider";

function CustomHits() {
  const {hits, results} = useHits();

  if (!results || results.nbHits === 0) {
    return (
      <div className="w-full py-8 text-center">
        <div className="card bg-base-100 shadow-xl">
          <div className="card-body">
            <h2 className="text-xl font-semibold">لم يتم العثور على أي منتجات</h2>
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
          عرض <span className="font-bold">
          <NumberFormatter amount={results.nbHits}/>
        </span> منتجات في <span className="font-bold">{results.processingTimeMS}ms</span>
        </p>

        <div className="flex items-center justify-end">
          ترتيب حسب:
          <SortBy
            classNames={{
              root: "flex ml-4 justify-end",
              select: "select select-bordered",
            }}
            items={[
              { 
                label: "الأحدث", 
                value: "products_index"},
              {
                label: "الأكثر رواجاً", 
                value: "products_index"
              },
              {
                label: "الأفضل تقييماً",
                value: "products_index/sort/rate:desc",
              },
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
const sampleBanners = [
  {
    id: 1,
    title: "أهلا وسهلا بكم في سوق ياقوت",
    subtitle: "اكتشف أفضل المنتجات لدينا",
    image: "https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80",
    link: "/products",
    buttonText: "تسوق الآن"
  },
  {
    id: 2,
    title: "المنتجات الجديدة",
    subtitle: "تسوق أحدث الإضافات إلى مجموعتنا",
    image: "https://f.nooncdn.com/mpcms/EN0001/assets/45dfb5bb-033b-492c-940e-54530ac856dd.png",
    link: "/products?sort=newest",
    buttonText: "تسوق الجديد"
  },
  {
    id: 3,
    title: "تخفيضات كبيرة",
    subtitle: "وفر على أفضل المنتجات لدينا",
    image: "https://f.nooncdn.com/mpcms/EN0001/assets/d0643997-89bd-4bbb-90f8-f0a434f35eff.png",
    link: "/products?sort=discount",
    buttonText: "تسوق التخفيضات"
  }
];

export default function Home({
                               products
                             }: PageProps<{ products: PaginationProps<Product> }>) {

  return (
    <AuthenticatedLayout>
      <Head title="Home"/>
      <BannerSlider banners={sampleBanners}/>
      {/* <ProductListing products={products}/> */}

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

import {PageProps, PaginationProps, Product} from '@/types';
import {Head} from '@inertiajs/react';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import React from "react";
import ProductListing from "@/Components/App/ProductListing";
import BannerSlider from "@/Components/App/BannerSlider";

const sampleBanners = [
  {
    id: 1,
    title: "Welcome to LaraStore",
    subtitle: "Discover amazing products at great prices",
    image: "https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80",
    link: "/products",
    buttonText: "Shop Now"
  },
  {
    id: 2,
    title: "New Arrivals",
    subtitle: "Check out our latest collection",
    image: "https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80",
    link: "/products?sort=newest",
    buttonText: "View New Arrivals"
  },
  {
    id: 3,
    title: "Special Offers",
    subtitle: "Up to 50% off on selected items",
    image: "https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80",
    link: "/products?sort=discount",
    buttonText: "View Deals"
  }
];

export default function Home({
                               products
                             }: PageProps<{ products: PaginationProps<Product> }>) {

  return (
    <AuthenticatedLayout>
      <Head title="Home"/>
      <BannerSlider banners={sampleBanners}/>
      <ProductListing products={products}/>
    </AuthenticatedLayout>
  );
}

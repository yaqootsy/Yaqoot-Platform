import {Link, usePage} from '@inertiajs/react';
import {PropsWithChildren, ReactNode, useEffect, useRef, useState} from 'react';
import Navbar from "@/Components/App/Navbar";
import ToastList from "@/Components/Core/ToastList";

export default function AuthenticatedLayout(
  {
    header,
    children,
  }: PropsWithChildren<{ header?: ReactNode }>) {
  const props = usePage().props;

  return (
    <div className="min-h-screen bg-base-200">
      <Navbar/>

      {props.error && (
        <div className="container mx-auto px-8 mt-8 ">
          <div className="alert alert-error">
            {props.error}
          </div>
        </div>
      )}

      {props.success && (
        <div className="container mx-auto px-8 mt-8 ">
          <div className="alert alert-success">
            {props.success}
          </div>
        </div>
      )}

      <ToastList alertVariant='error' pageProp="errorToast" />

      <ToastList alertVariant='success' pageProp="successToast" />

      <main>{children}</main>
    </div>
  );
}

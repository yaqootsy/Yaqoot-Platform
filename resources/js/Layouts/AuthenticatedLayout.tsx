import {Link, usePage} from '@inertiajs/react';
import {PropsWithChildren, ReactNode, useEffect, useRef, useState} from 'react';
import Navbar from "@/Components/App/Navbar";
import ToastList from "@/Components/Core/ToastList";
import TypesenseInstantsearchAdapter from "typesense-instantsearch-adapter";
import {InstantSearch} from "react-instantsearch";


const typesenseInstantsearchAdapter = new TypesenseInstantsearchAdapter({
  server: {
    apiKey: "xyz", // Be sure to use an API key that only allows search operations
    nodes: [
      {
        host: "localhost",
        port: 8108,
        path: "", // Optional. Example: If you have your typesense mounted in localhost:8108/typesense, path should be equal to '/typesense'
        protocol: "http",
      },
    ],
    cacheSearchResultsForSeconds: 2 * 60, // Cache search results from server. Defaults to 2 minutes. Set to 0 to disable caching.
  },
  // The following parameters are directly passed to Typesense's search API endpoint.
  //  So you can pass any parameters supported by the search endpoint below.
  //  query_by is required.
  additionalSearchParameters: {
    query_by: "title,description",
  },
});
const searchClient = typesenseInstantsearchAdapter.searchClient;

export default function AuthenticatedLayout(
  {
    header,
    children,
  }: PropsWithChildren<{ header?: ReactNode }>) {
  const props = usePage().props;

  return (
    <div className="min-h-screen bg-base-200">
      <InstantSearch routing={true} indexName="products_index" searchClient={searchClient}>
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

        <ToastList alertVariant='error' pageProp="errorToast"/>

        <ToastList alertVariant='success' pageProp="successToast"/>

        <main>{children}</main>
      </InstantSearch>
    </div>
  );
}

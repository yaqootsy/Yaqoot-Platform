import React from 'react';
import ProductItem from "@/Components/App/ProductItem";
import {Link} from "@inertiajs/react";
import {PaginationProps, Product} from "@/types";

function ProductListing({products}: { products: PaginationProps<Product> }) {
  return (
    <div className="container py-8 mx-auto">
      {products.data.length === 0 && (
        <div className={"py-16 px-8 text-center text-gray-300 text-3xl"}>
          No products found
        </div>
      )}
      <div className="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5">
        {products.data.map(product => (
          <ProductItem product={product} key={product.id}/>
        ))}
      </div>
      {/*<pre>{JSON.stringify(products, undefined, 2)}</pre>*/}

      {products.meta.total > products.meta.per_page && <div className={"flex justify-center"}>
        <div className="join mt-8">
          {products.meta.links.map((link, ind) => (
            <Link href={link.url}
                  key={ind}
                  preserveScroll
                  preserveState
                  className={[
                    `join-item btn`,
                    (link.active ? 'btn-primary' : ''),
                    (!link.url ? 'btn-disabled' : '')
                  ]
                    .join(' ')}
                  dangerouslySetInnerHTML={{__html: link.label}}></Link>
          ))}
        </div>
      </div>}
    </div>
  );
}

export default ProductListing;

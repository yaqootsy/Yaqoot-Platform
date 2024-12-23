import React from 'react';
import {Address} from "@/types";
import {router} from "@inertiajs/react";

function AddressItem({address, onEdit}: { address: Address, onEdit?: Function }) {
  const makeDefault = () => {
    if (!confirm('Are you sure you want to make this address your default shipping address?')) {
      return;
    }
    router.put(route('shippingAddress.makeDefault', address.id), {}, {
      preserveScroll: true,
      preserveState: true,
    });
  }

  const deleteAddress = () => {
    if (address.default) {
      alert('You cannot delete your default address. Please make another address default before deleting this one.');
      return;
    }
    if (!confirm('Are you sure you want to delete this address?')) {
      return;
    }
    router.delete(route('shippingAddress.destroy', address.id), {
      preserveScroll: true,
      preserveState: true,
    });
  }

  const showEditAddress = () => {
    if (!onEdit) {
      return;
    }
    onEdit(address);
  }

  return (
    <div
      className={'text-sm p-4 border-2 rounded-xl w-[280px] relative overflow-hidden pr-16 ' + (address.default ? ' border-primary' : '')}>
      <h3 className="font-black">{address.full_name}</h3>
      <div>{address.address1} <br/>
        {address.address2} <br/>
        {address.city}, {address.state} {address.zipcode} <br/>
        {address.country.name} <br/>
        Phone Number: {address.phone} <br/>
        <hr className="my-2"/>
        <em>{address.delivery_instructions}</em>
      </div>
      {address.default && <div
        className="absolute transform rotate-45 bold bg-primary py-1 px-3 text-white top-[20px] -right-[60px] w-48 text-center">
        Default
      </div>}
      <div className="flex gap-2 mt-4 whitespace-nowrap">
        {!address.default && <>
          <button onClick={ev => makeDefault()}
                  className="text-primary hover:underline">Make Default
          </button>
          |
        </>}
        <button onClick={ev => showEditAddress()}
                className="text-primary hover:underline">Edit
        </button>
        |
        <button onClick={ev => deleteAddress()}
                className="text-error hover:underline">Delete</button>
      </div>
    </div>
  );
}

export default AddressItem;

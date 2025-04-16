import React, {FormEventHandler} from 'react';
import {Link, useForm, usePage} from "@inertiajs/react";
import MiniCartDropdown from "@/Components/App/MiniCartDropdown";
import {MagnifyingGlassIcon} from "@heroicons/react/24/outline";
import {hasAnyRole, hasRole} from "@/helpers";

function Navbar() {
  const {auth, departments, keyword} = usePage().props;
  const {user} = auth;

  const searchForm = useForm<{
    keyword: string;
  }>({
    keyword: keyword || '',
  })
  const {url} = usePage();

  const searchFormComponent = (className = 'hidden md:flex') => {
    return (
      <form onSubmit={onSubmit} className={'join flex-1 ' + className}>
        <div className="flex-1">
          <input
            value={searchForm.data.keyword}
            onChange={(e) =>
              searchForm.setData('keyword', e.target.value)}
            onBlur={onSubmit}
            className="input input-bordered join-item w-full" placeholder="Search"/>
        </div>
        <div className="indicator">
          <button className="btn join-item">
            <MagnifyingGlassIcon className={'size-4'}/>
            <span className={"hidden md:inline-flex"}>Search</span>
          </button>
        </div>
      </form>
    )
  }

  const onSubmit: FormEventHandler = (e) => {
    e.preventDefault();

    searchForm.get(url, {
      preserveScroll: true,
      preserveState: true,
    });
  };

  return (
    <>
      <div className="navbar bg-base-100">
        <div className="flex-1">
          <Link href="/" className="btn btn-ghost text-xl">LaraStore</Link>
        </div>
        <div className="flex-none gap-4">
          {searchFormComponent()}
          <MiniCartDropdown/>
          {user && <div className="dropdown dropdown-end">
            <div tabIndex={0} role="button" className="btn btn-ghost btn-circle avatar">
              <div className="w-10 rounded-full">
                <img
                  alt="Tailwind CSS Navbar component"
                  src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp"/>
              </div>
            </div>
            <ul
              tabIndex={0}
              className="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
              <li>
                <Link href={route('profile.edit')} className="justify-between">
                  Profile
                </Link>
              </li>
              {hasAnyRole(auth.user, ['Admin', 'Vendor']) &&
                <li>
                  <a href="/admin" className="justify-between">
                    {hasRole(auth.user, 'Admin') ? 'Admin Area' : 'Vendor Area'}
                  </a>
                </li>
              }
              <li>
                <Link href={route('orders.index')} className="justify-between">
                  My Orders
                </Link>
              </li>
              <li>
                <Link href={route('shippingAddress.index')} className="justify-between">
                  My Addresses
                </Link>
              </li>
              <li>
                <Link href={route('logout')} method={"post"} as="button">
                  Logout
                </Link>
              </li>
            </ul>
          </div>}
          {!user && <>
            <Link href={route('login')} className={"btn"}>Login</Link>
            <Link href={route('register')} className={"btn btn-primary"}>
              Register
            </Link>
          </>}
        </div>
      </div>
      <div className="navbar bg-base-100">
        <div className="navbar-center flex justify-between flex-1">
          <div className="dropdown md:hidden">
            <div tabIndex={0} role="button" className="btn btn-ghost">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                className="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor">
                <path
                  strokeLinecap="round"
                  strokeLinejoin="round"
                  strokeWidth="2"
                  d="M4 6h16M4 12h8m-8 6h16"/>
              </svg>
            </div>
            <ul
              tabIndex={0}
              className="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
              {departments.map((department) => (
                <li key={department.id}>
                  {<Link href={route('product.byDepartment', department.slug)}>
                    {department.name}
                  </Link>}
                </li>
              ))}
            </ul>
          </div>
          <ul className="menu menu-horizontal px-1 hidden md:flex">
            {departments.map((department) => (
              <li key={department.id}>
                {<Link href={route('product.byDepartment', department.slug)}>
                  {department.name}
                </Link>}
              </li>
            ))}
          </ul>
          {searchFormComponent('flex md:hidden')}
        </div>
      </div>
    </>
  );
}

export default Navbar;

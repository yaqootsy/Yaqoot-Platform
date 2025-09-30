import React, { FormEventHandler, useState, useEffect, useRef } from "react";
import { Link, usePage } from "@inertiajs/react";
import MiniCartDropdown from "@/Components/App/MiniCartDropdown";
import {
  ChevronDownIcon,
  MagnifyingGlassIcon,
  ShoppingBagIcon,
  MapPinIcon,
  UserIcon,
  BuildingStorefrontIcon,
  ArrowRightStartOnRectangleIcon,
  ArrowLeftEndOnRectangleIcon,
} from "@heroicons/react/24/outline";

import { hasAnyRole, hasRole } from "@/helpers";
import { useSearchBox } from "react-instantsearch";
import ThemeToggle from "../Core/ThemeToggle";
import yaqootLogo from "@/assets/images/d.png";
import { Department, Address } from "@/types";

function Navbar({ searchPlaceholder }: { searchPlaceholder?: string }) {
  const placeholder = searchPlaceholder || "بحث";
  const params = new URLSearchParams(window.location.search);
  const query = params.get("products_index[query]");
  const { auth, departments, userAddress } = usePage().props;
  const typedUserAddress = userAddress as Address | undefined;
  const { user } = auth;
  const { refine } = useSearchBox();
  const [value, setValue] = useState(query || "");
  const detailsRef = useRef<HTMLDetailsElement | null>(null);
  const searchFormComponent = (className = "hidden md:flex") => {
    return (
      <form onSubmit={onSubmit} className={"join flex-1 " + className}>
        <div className="flex-1">
          <input
            value={value}
            onChange={(e) => setValue(e.target.value)}
            onBlur={onSubmit}
            className="input input-bordered join-item w-full md:w-[300px]"
            placeholder={placeholder} // استخدم الـ prop هنا
          />
        </div>
        <div className="indicator">
          <button className="btn join-item">
            <MagnifyingGlassIcon className={"size-4"} />
            <span className={"hidden md:inline-flex"}>بحث</span>
          </button>
        </div>
      </form>
    );
  };
  const onSubmit: FormEventHandler = (e) => {
    e.preventDefault();
    refine(value);
  };

  useEffect(() => {
    const onPointerDown = (e: PointerEvent) => {
      const el = detailsRef.current;
      if (!el) return;
      // إذا النقر خارج عنصر details -> أغلقه
      if (!el.contains(e.target as Node)) {
        el.open = false; // أو: el.removeAttribute('open')
      }
    };

    // pointerdown يعمل جيد ويعالج اللمس/الماوس والقلم
    document.addEventListener("pointerdown", onPointerDown);
    return () => document.removeEventListener("pointerdown", onPointerDown);
  }, []);

  return (
    <>
      <div className="navbar bg-base-100">
        <div className="flex-1">
          <Link href="/" className="btn btn-ghost text-xl">
            <img
              src={yaqootLogo}
              alt="Yaqoot Market"
              style={{ width: "3rem" }}
            />
            ياقوت
          </Link>
        </div>
        <div className="flex-none gap-4">
          {searchFormComponent()}
          {typedUserAddress ? (
            <Link
              href={route("shippingAddress.index")}
              className="btn btn-ghost shadow-md flex flex-col items-start gap-1"
              title={`${typedUserAddress.address1}, ${typedUserAddress.address2}, ${typedUserAddress.city}`}
            >
              <span className="text-xs text-gray-500">توصيل إلى:</span>
              <div className="text-sm block truncate max-w-[300px] sm:max-w-[250px] md:max-w-[200px] lg:max-w-[150px] hover:underline dark:text-white">
                {typedUserAddress.address1}, {typedUserAddress.address2},{" "}
                {typedUserAddress.city}
              </div>
            </Link>
          ) : (
            <Link
              href={route("shippingAddress.index")}
              className="text-sm text-gray-500 hover:underline"
            >
              اختر عنوان التوصيل
            </Link>
          )}
          <MiniCartDropdown />
          <ThemeToggle />
          {user && (
            <details ref={detailsRef} className="dropdown dropdown-end">
              <summary
                className="btn btn-ghost shadow-md flex items-center gap-3"
                role="button"
              >
                <span className="hidden sm:inline">
                  هلا {user.name.split(" ")[0]}
                </span>
                <ChevronDownIcon className="w-4 h-4" />
              </summary>

              <ul className="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1000] mt-3 w-52 p-2 shadow">
                <li>
                  <Link
                    href={route("orders.index")}
                    className="justify-between flex items-center gap-2"
                  >
                    <span className="inline-flex items-center gap-2">
                      <ShoppingBagIcon className="w-4 h-4" />
                      الطلبات
                    </span>
                  </Link>
                </li>

                <li>
                  <Link
                    href={route("shippingAddress.index")}
                    className="justify-between flex items-center gap-2"
                  >
                    <span className="inline-flex items-center gap-2">
                      <MapPinIcon className="w-4 h-4" />
                      العناوين
                    </span>
                  </Link>
                </li>

                <li>
                  <Link
                    href={route("profile.edit")}
                    className="justify-between flex items-center gap-2"
                  >
                    <span className="inline-flex items-center gap-2">
                      <UserIcon className="w-4 h-4" />
                      الحساب
                    </span>
                  </Link>
                </li>

                {hasAnyRole(auth.user, ["Vendor"]) &&
                  user.vendor.status == "approved" && (
                    <>
                      <li>
                        <Link
                          href={route(
                            "vendor.profile",
                            user.vendor?.store_name
                          )}
                          className="justify-between flex items-center gap-2"
                        >
                          <span className="inline-flex items-center gap-2">
                            <BuildingStorefrontIcon className="w-4 h-4" />
                            متجري
                          </span>
                        </Link>
                      </li>

                      <li>
                        <a
                          href="/admin"
                          className="justify-between flex items-center gap-2"
                        >
                          <span className="inline-flex items-center gap-2">
                            <ArrowLeftEndOnRectangleIcon className="w-4 h-4" />
                            منطقة البائعين
                          </span>
                        </a>
                      </li>
                    </>
                  )}

                {hasAnyRole(auth.user, ["Admin"]) && (
                  <li>
                    <a
                      href="/admin"
                      className="justify-between flex items-center gap-2"
                    >
                      <span className="inline-flex items-center gap-2">
                        <ArrowLeftEndOnRectangleIcon className="w-4 h-4" />
                        منطقة الإدارة
                      </span>
                    </a>
                  </li>
                )}

                <li>
                  <Link
                    href={route("logout")}
                    method={"post"}
                    as="button"
                    className="justify-between flex items-center gap-2"
                  >
                    <span className="inline-flex items-center gap-2">
                      <ArrowRightStartOnRectangleIcon className="w-4 h-4" />
                      تسجيل الخروج
                    </span>
                  </Link>
                </li>
              </ul>
            </details>
          )}
          {!user && (
            <>
              <Link href={route("login")} className={"btn"}>
                تسجيل الدخول
              </Link>
              <Link href={route("register")} className={"btn btn-primary"}>
                تسجيل حساب جديد
              </Link>
            </>
          )}
        </div>
      </div>

      {/* أقسام الفئات */}
      <div className="bg-base-100 min-h-10 flex items-center shadow px-4 md:px-6 py-2">
        <div className="flex gap-4 text-sm overflow-x-auto whitespace-nowrap no-scrollbar">
          {departments?.map((dep: Department) => (
            <a
              key={dep.id}
              href={`/d/${dep.slug}`}
              className="font-semibold hover:underline flex-shrink-0"
            >
              {dep.name}
            </a>
          ))}
        </div>
      </div>

      <div className="md:hidden navbar bg-base-100">
        <div className="navbar-center flex justify-between flex-1">
          {searchFormComponent("flex")}
        </div>
      </div>
    </>
  );
}

export default Navbar;

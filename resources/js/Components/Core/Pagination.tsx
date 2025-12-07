// resources/js/Components/Core/Pagination.jsx
import React from "react";
import { Link } from "@inertiajs/react";

interface PaginationLink {
  url: string | null;
  label: string;
  active: boolean;
}

interface PaginationProps {
  links: PaginationLink[] | Record<string, string | null>;
}

function isLinksArray(links: any): links is PaginationLink[] {
  return Array.isArray(links);
}

function normalizeLinks(linksProp: any): PaginationLink[] {
  if (!linksProp) return [];

  // already array form (usual Laravel meta.links)
  if (isLinksArray(linksProp)) return linksProp;

  // object form { first, last, prev, next } -> construct minimal array
  const arr: PaginationLink[] = [];

  arr.push({
    url: (linksProp as any).prev ?? null,
    label: "pagination.previous",
    active: false,
  });

  if (
    (linksProp as any).first &&
    (linksProp as any).last &&
    (linksProp as any).first !== (linksProp as any).last
  ) {
    arr.push({ url: (linksProp as any).first, label: "1", active: false });
    arr.push({
      url: (linksProp as any).last,
      label: "pagination.last",
      active: false,
    });
  }

  arr.push({
    url: (linksProp as any).next ?? null,
    label: "pagination.next",
    active: false,
  });

  return arr;
}

function getRenderedLabel(label: string) {
  // If it's translation key like pagination.previous => convert to arrows
  if (typeof label === "string" && label.startsWith("pagination.")) {
    if (label.includes("previous")) return "‹"; // or '«'
    if (label.includes("next")) return "›"; // or '»'
    if (label.includes("first")) return "«";
    if (label.includes("last")) return "»";
  }

  // If it contains HTML entity like &laquo; or &raquo; -> render as HTML
  if (typeof label === "string" && /&[a-zA-Z]+;/.test(label)) {
    return <span dangerouslySetInnerHTML={{ __html: label }} />;
  }

  // dots or numbers or plain text
  return <span>{label}</span>;
}

export default function Pagination({ links }: PaginationProps) {
  const normalized = normalizeLinks(links);

  if (!normalized || normalized.length <= 3) return null;

  return (
    <div className="flex items-center justify-center my-4">
      <div className="join">
        {normalized.map((link, i) => {
          // if label contains '...' keep it (Laravel sometimes returns <span> ...)
          if (typeof link.label === "string" && link.label.includes("...")) {
            return (
              <span
                key={i}
                className="join-item btn btn-disabled"
                dangerouslySetInnerHTML={{ __html: link.label }}
              />
            );
          }

          // compute rendered label (arrow, html entity or text)
          const rendered = getRenderedLabel(link.label);

          // previous/next/first/last as arrows handled in getRenderedLabel
          const isDisabled = !link.url;
          const isArrow =
            typeof link.label === "string" &&
            (link.label.includes("&laquo;") ||
              link.label.includes("&raquo;") ||
              link.label.startsWith("pagination."));

          if (isDisabled) {
            return (
              <button key={i} className="join-item btn btn-disabled" disabled>
                {rendered}
              </button>
            );
          }

          // Regular page link (numbers) or arrow link
          return (
            <Link
              key={i}
              href={link.url ?? "#"}
              className={`join-item btn ${link.active ? "btn-active" : ""}`}
              preserveScroll
            >
              {rendered}
            </Link>
          );
        })}
      </div>
    </div>
  );
}

import React from 'react';

function CurrencyFormatter({
  amount,
  currency = 'SYP',
  locale = 'en',
}: {
  amount: number;
  currency?: string;
  locale?: string;
}) {
  if (currency === 'SYP') {
    // نستخدم NumberFormat لكن بدون عملة، ثم نضيف "ل.س" يدويًا
    return `${new Intl.NumberFormat(locale).format(amount)} ل.س.`;
  }

  return new Intl.NumberFormat(locale, {
    style: 'currency',
    currency,
  }).format(amount);
}

export default CurrencyFormatter;

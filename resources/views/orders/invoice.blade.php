<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>فاتورة رقم #{{ $order->id }}</title>
    <style>
        body {
            font-family: 'Tahoma', Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f7f7f7;
            color: #333;
        }

        .invoice-container {
            max-width: 850px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #eee;
            margin-bottom: 25px;
            padding-bottom: 15px;
        }

        .invoice-header h1 {
            font-size: 1.8rem;
            margin: 0;
            color: #2c3e50;
        }

        .invoice-header img {
            max-height: 70px;
        }

        .invoice-meta {
            text-align: right;
            font-size: 0.95rem;
            color: #555;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.85em;
            font-weight: bold;
            text-transform: uppercase;
            color: white;
            background-color: #4a5568;
        }

        .status-badge.pending {
            background-color: #ed8936;
        }

        .status-badge.processing {
            background-color: #3182ce;
        }

        .status-badge.completed {
            background-color: #38a169;
        }

        .status-badge.cancelled {
            background-color: #e53e3e;
        }

        .address-details {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 30px;
        }

        .address-block {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            flex: 1;
        }

        .address-block h3 {
            margin-top: 0;
            margin-bottom: 10px;
            color: #444;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            font-size: 0.95rem;
        }

        table thead {
            background: #f0f0f0;
        }

        table th,
        table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        .totals-table {
            width: 40%;
            margin-left: auto;
            background: #f9f9f9;
            border-radius: 8px;
            overflow: hidden;
        }

        .totals-table th,
        .totals-table td {
            padding: 10px;
            text-align: right;
        }

        .totals-table tr:nth-child(even) {
            background: #f3f3f3;
        }

        .grand-total td,
        .grand-total th {
            font-weight: bold;
            font-size: 1.1rem;
            border-top: 2px solid #ccc;
        }

        .footer {
            text-align: center;
            font-size: 0.85rem;
            color: #666;
            margin-top: 30px;
        }

        .print-button {
            text-align: left;
            margin-bottom: 15px;
        }

        .print-button button {
            padding: 8px 20px;
            background: #27ae60;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: background 0.3s;
        }

        .print-button button:hover {
            background: #219150;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .invoice-container {
                box-shadow: none;
                border-radius: 0;
            }

            .print-button {
                display: none;
            }

        }
    </style>
    <script>
        function printInvoice() {
            window.print();
        }
    </script>
</head>

<body>
    <div class="invoice-container">
        <div class="print-button">
            <button onclick="printInvoice()">🖨️ طباعة الفاتورة</button>
        </div>

        <div class="invoice-header">
            <div>
                <h1>فاتورة</h1>
                <p>{{ config('app.name') }}</p>
            </div>
            <div class="invoice-meta">
                @if (isset($logo))
                    <img src="{{ $logo }}" alt="Logo">
                @endif
                <p><strong>رقم الطلب:</strong> #{{ $order->id }}</p>
                <p><strong>التاريخ:</strong> {{ $order->created_at->format('d/m/Y') }}</p>
                <p>
                    <strong>حالة الطلب:</strong>
                    <span class="status-badge {{ strtolower($order->status) }}">
                        {{ $order->status }}
                    </span>
                </p>
                @if ($order->tracking_code)
                    <p><strong>رمز التتبع:</strong> {{ $order->tracking_code }}</p>
                @endif
            </div>
        </div>

        <div class="address-details">
            <div class="address-block">
                <h3>مُفوتر إلى:</h3>
                <p>
                    {{ $order->user->name }}<br>
                    {{ $order->user->email }}
                </p>
            </div>

            @if ($order->shippingAddress)
                <div class="address-block">
                    <h3>شُحنت إلى:</h3>
                    <p>
                        {{ $order->shippingAddress->full_name }}<br>
                        {{ $order->shippingAddress->address1 }}<br>
                        @if ($order->shippingAddress->address2)
                            {{ $order->shippingAddress->address2 }}<br>
                        @endif
                        {{ $order->shippingAddress->city }}, {{ $order->shippingAddress->state }} {{ $order->shippingAddress->zipcode }}<br>
                        {{ $order->shippingAddress->country->name }}<br>
                        {{ $order->shippingAddress->phone }}
                    </p>
                </div>
            @endif
        </div>

        <h3>تفاصيل الطلب</h3>
        <table>
            <thead>
                <tr>
                    <th>المنتج</th>
                    <th>الاختلافات</th>
                    <th>سعر الوحدة</th>
                    <th>الكمية</th>
                    <th>الإجمالي</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->orderItems as $item)
                    <tr>
                        <td>{{ $item->product ? $item->product->title : 'غير متوفر' }}</td>
                        <td>
                            @if ($item->variationOptions && $item->variationOptions->count() > 0)
                                @foreach ($item->variationOptions as $option)
                                    {{ $option->variationType->name }}: {{ $option->name }}@if (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            @endif
                        </td>
                        <td>{{ number_format($item->price, 2) }} {{ config('app.currency') }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->price * $item->quantity, 2) }} {{ config('app.currency') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <table class="totals-table">
            <tr>
                <th>المجموع الفرعي:</th>
                <td>{{ number_format($order->subtotal, 2) }} {{ config('app.currency') }}</td>
            </tr>
            @if ($order->tax_amount > 0)
                <tr>
                    <th>الضريبة:</th>
                    <td>{{ number_format($order->tax_amount, 2) }} {{ config('app.currency') }}</td>
                </tr>
            @endif
            @if ($order->shipping_amount > 0)
                <tr>
                    <th>الشحن:</th>
                    <td>{{ number_format($order->shipping_amount, 2) }} {{ config('app.currency') }}</td>
                </tr>
            @endif
            @if ($order->discount_amount > 0)
                <tr>
                    <th>الخصم:</th>
                    <td>-{{ number_format($order->discount_amount, 2) }} {{ config('app.currency') }}</td>
                </tr>
            @endif
            <tr class="grand-total">
                <th>الإجمالي:</th>
                <td>{{ number_format($order->total_price, 2) }} {{ config('app.currency') }}</td>
            </tr>
        </table>

        <div class="footer">
            <p>شكراً لتعاملكم معنا ❤</p>
            <p>للاستفسار يرجى التواصل مع دعم {{ config('app.name') }}</p>
        </div>
    </div>
</body>

</html>

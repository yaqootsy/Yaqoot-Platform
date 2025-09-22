<x-mail::message>
<h1 style="text-align: center; font-size: 24px">
    تهانينا! لديك طلب جديد.
</h1>

<x-mail::button :url="$order->id">
    عرض تفاصيل الطلب
</x-mail::button>

<h3 style="font-size: 20px; margin-bottom: 15px">ملخص الطلب</h3>
<x-mail::table>
    <table>
        <tbody>
        <tr>
            <td>الطلب #</td>
            <td>{{$order->id}}</td>
        </tr>
        <tr>
            <td>تاريخ الطلب</td>
            <td>{{ $order->created_at }}</td>
        </tr>
        <tr>
            <td>إجمالي الطلب</td>
            <td>{{ \Illuminate\Support\Number::currency($order->total_price) }}</td>
        </tr>
        <tr>
            <td>رسوم معالجة الدفع</td>
            <td>{{ \Illuminate\Support\Number::currency($order->online_payment_commission ?: 0) }}</td>
        </tr>
        <tr>
            <td>رسوم المنصة</td>
            <td>{{ \Illuminate\Support\Number::currency($order->website_commission ?: 0) }}</td>
        </tr>
        <tr>
            <td>أرباحك</td>
            <td>{{ \Illuminate\Support\Number::currency($order->vendor_subtotal ?: 0) }}</td>
        </tr>
        </tbody>
    </table>
</x-mail::table>

<hr>

<x-mail::table>
    <table>
        <thead>
        <tr>
            <th>العنصر</th>
            <th>الكمية</th>
            <th>السعر</th>
        </tr>
        </thead>
        <tbody>
        @foreach($order->orderItems as $orderItem)
            <tr>
                <td>
                    <table>
                        <tbody>
                        <tr>
                            <td padding="5" style="padding: 5px">
                                <img style="min-width: 60px; max-width: 60px;" src="{{ $orderItem->product->getImageForOptions($orderItem->variation_type_option_ids) }}" alt="">
                            </td>
                            <td style="font-size: 13px; padding: 5px">
                                {{ $orderItem->product->title }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
                <td>
                    {{ $orderItem->quantity }}
                </td>
                <td>
                    {{ \Illuminate\Support\Number::currency($orderItem->price) }}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</x-mail::table>

<x-mail::panel>
    شكراً لكم على تعاملكم معنا.
</x-mail::panel>

شكراً,<br>
{{ config('app.name') }}
</x-mail::message>

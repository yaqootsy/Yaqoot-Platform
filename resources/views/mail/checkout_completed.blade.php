<x-mail::message>
<h1 style="text-align: center; font-size: 24px">تمت عملية الدفع بنجاح</h1>

@foreach($orders as $order)
<x-mail::table>
    <table>
        <tbody>
        <tr>
            <td>البائع</td>
            <td>
                <a href="{{ url('/') }}">
                    {{ $order->vendorUser->vendor->store_name }}
                </a>
            </td>
        </tr>
        <tr>
            <td>الطلب #</td>
            <td>#{{ $order->id }}</td>
        </tr>
        <tr>
            <td>العناصر</td>
            <td>{{$order->orderItems->count()}}</td>
        </tr>
        <tr>
            <td>الإجمالي</td>
            <td>{{ \Illuminate\Support\Number::currency($order->total_price) }}</td>
        </tr>
        </tbody>
    </table>
</x-mail::table>

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

<x-mail::button :url="$order->id">
    عرض تفاصيل الطلب
</x-mail::button>
@endforeach

{{-- <x-mail::subcopy>
    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam at blanditiis dolores doloribus, eaque error in ipsum libero nihil odio porro quaerat qui quisquam quo rerum tenetur ullam vero voluptatem.
</x-mail::subcopy>

<x-mail::panel>
    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur cum cumque enim inventore magnam optio quisquam quos rerum, similique. Culpa debitis distinctio laboriosam nam qui tempora totam veritatis voluptate voluptates.
</x-mail::panel> --}}

شكراً,<br>
{{ config('app.name') }}
</x-mail::message>

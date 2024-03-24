@component('mail::message')
# Product Status Notification

Your product '{{ $product->name }}' has been {{ $status }}.

@component('mail::button', ['url' => url('/products/' . $product->id)])
View Product
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

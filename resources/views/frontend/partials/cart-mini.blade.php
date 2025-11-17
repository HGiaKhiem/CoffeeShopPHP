@php
    $cart = session('cart', []);
@endphp

<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white text-center">
        Giỏ hàng của bạn
    </div>

    <div class="card-body p-2">

        @if(empty($cart) || count($cart) === 0)

            <p class="text-center text-muted mb-2">Giỏ hàng đang trống.</p>

        @else
            @php $total = 0; @endphp

            @foreach($cart as $item)

                @php 
                    $qty   = $item['quantity'] ?? 1;
                    $price = $item['price'] ?? 0;
                    $line  = $qty * $price;
                    $total += $line;

                    $size      = $item['size'] ?? 'S';
                    $toppings  = $item['toppings'] ?? [];
                @endphp

                <div class="border-bottom py-2">
                    <strong>{{ $item['name'] ?? '---' }}</strong><br>

                    <small>Size: {{ $size }}</small><br>

                    @if(!empty($toppings))
                        <small>Topping: {{ implode(', ', $toppings) }}</small><br>
                    @else
                        <small>Topping: Không</small><br>
                    @endif

                    <span class="float-right">
                        {{ number_format($line) }} đ
                    </span>
                </div>

            @endforeach

            <div class="d-flex justify-content-between mt-3 font-weight-bold">
                <span>Tổng:</span>
                <span>{{ number_format($total) }} đ</span>
            </div>

        @endif
    </div>

    <div class="card-footer text-center">
        <a href="{{ route('cart') }}" class="btn btn-primary btn-sm w-100">
            Xem chi tiết
        </a>
    </div>
</div>

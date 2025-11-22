@extends('frontend.layouts.master')

@section('title', 'Giỏ hàng')

@section('content')
<div class="container py-5" style="padding-top: 140px;">

    <h2 class="fw-bold mb-4">Giỏ hàng của bạn</h2>

    @php
        // =======================
        //  AUTO CLEAR GIỎ HÀNG CŨ
        // =======================
        $invalid = false;

        foreach ($cart as $c) {
            if (!isset($c['size']) || !isset($c['toppings'])) {
                $invalid = true;
                break;
            }
        }

        if ($invalid) {
            session()->forget('cart');
            $cart = [];
        }
    @endphp

    @if(empty($cart) || count($cart) === 0)

        <div class="alert alert-info">Giỏ hàng đang trống.</div>
        <a href="{{ route('menu') }}" class="btn btn-primary">← Quay lại Menu</a>

    @else

        <div class="table-responsive cart-table">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr class="bg-dark text-white">
                        <th>Sản phẩm</th>
                        <th>Đơn giá</th>
                        <th>Số lượng</th>
                        <th>Tổng</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @php $grandTotal = 0; @endphp

                    @foreach($cart as $key => $item)
                        @php 
                            $lineTotal = $item['price'] * $item['quantity'];
                            $grandTotal += $lineTotal;
                        @endphp

                        <tr id="row-{{ $key }}">
                            <td style="width: 35%">
                                <strong>{{ $item['name'] }}</strong>

                                <div class="small text-muted">
                                    Size: <span class="fw-bold">{{ $item['size'] }}</span>
                                </div>

                                <div class="small text-muted">
                                    Topping: 
                                    @if(!empty($item['toppings']))
                                        <span class="fw-bold">{{ implode(', ', $item['toppings']) }}</span>
                                    @else
                                        Không
                                    @endif
                                </div>
                            </td>

                            <td class="fw-bold text-primary">{{ number_format($item['price']) }} đ</td>

                            <td style="width: 160px;">
                                <div class="d-flex align-items-center justify-content-center">
                                    <button class="btn btn-sm btn-outline-secondary qty-btn"
                                            data-type="minus" data-key="{{ $key }}">
                                        -
                                    </button>

                                    <span class="mx-3 fw-bold" id="qty-{{ $key }}">
                                        {{ $item['quantity'] }}
                                    </span>

                                    <button class="btn btn-sm btn-outline-secondary qty-btn"
                                            data-type="plus" data-key="{{ $key }}">
                                        +
                                    </button>
                                </div>
                            </td>

                            <td id="line-total-{{ $key }}" class="fw-bold text-danger">
                                {{ number_format($lineTotal) }} đ
                            </td>

                            <td style="width: 80px">
                                <button class="btn btn-danger btn-sm delete-item" data-key="{{ $key }}">
                                    Xóa
                                </button>
                            </td>
                        </tr>
                    @endforeach

                    <tr class="fw-bold bg-light">
                        <td colspan="3" class="text-end">Tổng cộng:</td>
                        <td colspan="2" id="grand-total" class="text-danger">
                            {{ number_format($grandTotal) }} đ
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <a href="{{ route('cart.clear') }}" class="btn btn-warning mt-3">
            Xóa toàn bộ giỏ
        </a>

        {{-- ✅ BUTTON ĐẶT HÀNG MỚI --}}
        <a href="{{ route('cart.checkout') }}" class="btn btn-success mt-3 ms-2">
            ✔ Đặt hàng
        </a>

    @endif
</div>
@endsection


@push('scripts')
<script>
$(document).ready(function () {

    // ==========================
    //  UPDATE SỐ LƯỢNG AJAX
    // ==========================
    $('.qty-btn').click(function () {
        let key = $(this).data('key');
        let type = $(this).data('type');

        let qtyElement = $("#qty-" + key);
        let currentQty = parseInt(qtyElement.text());

        if (type === "plus") currentQty++;
        else if (type === "minus" && currentQty > 1) currentQty--;

        $.post("{{ route('cart.update.qty') }}", {
            _token: "{{ csrf_token() }}",
            key: key,
            quantity: currentQty
        }, function (res) {
            qtyElement.text(currentQty);
            $("#line-total-" + key).text(res.line_total + " đ");
            $("#grand-total").text(res.grand_total + " đ");
        });
    });


    // ==========================
    //  XÓA MÓN AJAX
    // ==========================
    $('.delete-item').click(function () {
        let key = $(this).data('key');

        $.post("{{ route('cart.delete.item') }}", {
            _token: "{{ csrf_token() }}",
            key: key
        }, function (res) {

            $("#row-" + key).fadeOut(200, function () {
                $(this).remove();
            });

            $("#grand-total").text(res.grand_total + " đ");

            if (res.cart_empty) {
                $(".cart-table").html(`
                    <div class="alert alert-info">Giỏ hàng đang trống.</div>
                    <a href="{{ route('menu') }}" class="btn btn-primary mt-3">← Quay lại Menu</a>
                `);
            }
        });
    });

});
</script>
@endpush

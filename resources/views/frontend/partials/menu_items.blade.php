<!-- Menu Items -->
@php
    $menuItems = [
        ['img' => 'menu-1.jpg', 'name' => 'Black Coffee', 'price' => '$5', 'desc' => 'Sit lorem ipsum et diam elitr est dolor sed duo guberg sea et et lorem dolor.'],
        ['img' => 'menu-2.jpg', 'name' => 'Choco Latte', 'price' => '$7', 'desc' => 'Sit lorem ipsum et diam elitr est dolor sed duo guberg sea et et lorem dolor.'],
        ['img' => 'menu-3.jpg', 'name' => 'Cappuccino', 'price' => '$8', 'desc' => 'Sit lorem ipsum et diam elitr est dolor sed duo guberg sea et et lorem dolor.'],
        ['img' => 'menu-4.jpg', 'name' => 'Cold Brew', 'price' => '$6', 'desc' => 'Sit lorem ipsum et diam elitr est dolor sed duo guberg sea et et lorem dolor.'],
    ];
@endphp

@foreach ($menuItems as $item)
    <div class="d-flex align-items-center justify-content-between mb-3">
        <img class="img-fluid rounded" src="{{ asset('img/' . $item['img']) }}" alt="" style="width: 80px;">
        <div class="w-100 d-flex flex-column text-start px-3">
            <h5 class="d-flex justify-content-between border-bottom pb-2 mb-2">
                <span>{{ $item['name'] }}</span>
                <span class="text-primary">{{ $item['price'] }}</span>
            </h5>
            <small>{{ $item['desc'] }}</small>
        </div>
    </div>
@endforeach
<!-- Menu Items End -->

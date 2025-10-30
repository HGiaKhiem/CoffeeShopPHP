<!-- Service Start -->
<div class="container-fluid pt-5">
    <div class="container">
        <div class="section-title">
            <h4 class="text-primary text-uppercase" style="letter-spacing: 5px;">Our Services</h4>
            <h1 class="display-4">Fresh & Organic Beans</h1>
        </div>
        <div class="row">
            @for ($i = 1; $i <= 4; $i++)
            <div class="col-lg-6 mb-5">
                <div class="row align-items-center">
                    <div class="col-sm-5">
                        <img class="img-fluid mb-3 mb-sm-0" src="{{ asset('img/service-' . $i . '.jpg') }}" alt="">
                    </div>
                    <div class="col-sm-7">
                        <h4><i class="fa fa-coffee service-icon"></i>Service {{ $i }}</h4>
                        <p class="m-0">Sit lorem ipsum et diam elitr est dolor sed duo...</p>
                    </div>
                </div>
            </div>
            @endfor
        </div>
    </div>
</div>
<!-- Service End -->

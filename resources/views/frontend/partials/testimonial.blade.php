<!-- Testimonial Start -->
<div class="container-fluid py-5">
    <div class="container">
        <div class="section-title">
            <h4 class="text-primary text-uppercase" style="letter-spacing: 5px;">Testimonial</h4>
            <h1 class="display-4">Our Clients Say</h1>
        </div>
        <div class="owl-carousel testimonial-carousel">
            @for ($i = 1; $i <= 4; $i++)
            <div class="testimonial-item">
                <div class="d-flex align-items-center mb-3">
                    <img class="img-fluid" src="{{ asset('img/testimonial-' . $i . '.jpg') }}" alt="">
                    <div class="ml-3">
                        <h4>Client Name</h4>
                        <i>Profession</i>
                    </div>
                </div>
                <p class="m-0">Sed ea amet kasd elitr stet rebum et ipsum...</p>
            </div>
            @endfor
        </div>
    </div>
</div>
<!-- Testimonial End -->

<!-- Testimonial Start -->
<div class="container-fluid py-5">
    <div class="container">
        <div class="section-title">
            <h4 class="text-primary text-uppercase" style="letter-spacing: 5px;">TESTIMONIAL</h4>
            <h1 class="display-4">Khách Hàng Nói Gì</h1>
        </div>
        <div class="owl-carousel testimonial-carousel">
            @for ($i = 1; $i <= 4; $i++)
            <div class="testimonial-item">
                <div class="d-flex align-items-center mb-3">
                    <img class="img-fluid" src="{{ asset('img/testimonial-' . $i . '.jpg') }}" alt="">
                    <div class="ml-3">
                        <h4>Tên Khách Hàng</h4>
                        <i>Nghề Nghiệp</i>
                    </div>
                </div>
                <p class="m-0">Đồ uống và đồ ăn tại đây rất tuyệt vời. Không gian ấm cúng, phục vụ chu đáo. Tôi sẽ quay lại lần nữa!</p>
            </div>
            @endfor
        </div>
    </div>
</div>
<!-- Testimonial End -->
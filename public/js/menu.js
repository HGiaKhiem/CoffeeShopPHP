document.addEventListener("DOMContentLoaded", function () {

    const searchInput   = document.getElementById("menuSearch");
    const filterButtons = document.querySelectorAll(".filter-btn");
    const ajaxContainer = document.getElementById("ajaxMenuContainer");

    let searchText = "";
    let filterType = "all";

    const ajaxUrl = "/ajax/menu";

    // Hàm load menu bằng fetch (không cần jQuery)
    function loadMenu(page = 1) {
        const params = new URLSearchParams({
            page: page,
            search: searchText,
            filter: filterType,
        });

        ajaxContainer.style.opacity = "0.5";

        fetch(ajaxUrl + "?" + params.toString())
            .then(res => res.json())
            .then(data => {
                ajaxContainer.innerHTML = data.html;
                ajaxContainer.style.opacity = "1";
                attachPaginationEvents();
            })
            .catch(() => {
                ajaxContainer.style.opacity = "1";
                alert("Không thể tải dữ liệu menu. Hãy thử lại!");
            });
    }

    // Gắn sự kiện cho pagination sau mỗi lần render
    function attachPaginationEvents() {
        const links = ajaxContainer.querySelectorAll(".ajax-pagination a");

        links.forEach(link => {
            link.addEventListener("click", function (e) {
                e.preventDefault();
                const url  = new URL(this.href);
                const page = url.searchParams.get("page") || 1;
                loadMenu(page);
            });
        });
    }

    // Search
    if (searchInput) {
        searchInput.addEventListener("input", function () {
            searchText = this.value;
            loadMenu(1);
        });
    }

    // Filter
    filterButtons.forEach(btn => {
        btn.addEventListener("click", function () {
            filterButtons.forEach(b => b.classList.remove("active"));
            this.classList.add("active");

            filterType = this.getAttribute("data-filter");
            loadMenu(1);
        });
    });

    // Lần đầu vào: gắn event cho pagination render từ Blade
    attachPaginationEvents();
});

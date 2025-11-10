document.addEventListener("DOMContentLoaded", () => {
  const searchInput = document.querySelector("#menuSearch");
  const filterButtons = document.querySelectorAll(".filter-btn");
  const cards = document.querySelectorAll(".menu-card");

  // Lọc theo loại món
  filterButtons.forEach(btn => {
    btn.addEventListener("click", () => {
      filterButtons.forEach(b => b.classList.remove("active"));
      btn.classList.add("active");
      const type = btn.dataset.filter;

      cards.forEach(card => {
        const match = type === "all" || card.dataset.type === type;
        card.style.display = match ? "flex" : "none";
      });
    });
  });

  // Tìm kiếm theo tên
  searchInput.addEventListener("input", e => {
    const keyword = e.target.value.toLowerCase();
    cards.forEach(card => {
      const match = card.dataset.name.includes(keyword);
      card.style.display = match ? "flex" : "none";
    });
  });
});

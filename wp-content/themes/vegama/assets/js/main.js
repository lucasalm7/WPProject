// Vegama — main.js
document.querySelectorAll(".rail-btn").forEach(button => {
  const rail = document.getElementById(button.dataset.rail);
  if (!rail) {
    return;
  }

  const reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
  const buttons = document.querySelectorAll('.rail-btn[data-rail="' + rail.id + '"]');

  function updateButtons() {
    const maxScroll = rail.scrollWidth - rail.clientWidth - 2;
    buttons.forEach(btn => {
      btn.hidden = btn.dataset.dir === "-1" ? rail.scrollLeft <= 2 : rail.scrollLeft >= maxScroll;
    });
  }

  button.addEventListener("click", () => {
    rail.scrollBy({
      left: Number(button.dataset.dir) * rail.clientWidth * 0.8,
      behavior: reduceMotion ? "auto" : "smooth"
    });
  });

  rail.addEventListener("scroll", updateButtons, { passive: true });
  window.addEventListener("resize", updateButtons);
  updateButtons();
});

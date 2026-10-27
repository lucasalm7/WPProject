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

const reels = document.querySelectorAll("video[data-autoplay]");
if (reels.length && "IntersectionObserver" in window) {
  const reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
  const reelObserver = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting && !reduceMotion) {
        entry.target.play().catch(() => {});
      } else {
        entry.target.pause();
      }
    });
  }, { threshold: 0.25 });
  reels.forEach(reel => reelObserver.observe(reel));
}

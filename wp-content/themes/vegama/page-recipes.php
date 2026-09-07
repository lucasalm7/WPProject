/* ===== Recipes video ===== */
.recipes-video-wrap {
  max-width: 400px;
  margin: 0 auto 40px;
  aspect-ratio: 9 / 16;
  border-radius: 20px;
  overflow: hidden;
}
.recipes-video-wrap iframe {
  width: 100%;
  height: 100%;
  border: none;
  display: block;
}

/* ===== Recipe filters ===== */
.recipe-filters {
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  gap: 0.6rem;
  margin-bottom: 1rem;
}
.filter-label {
  font-size: 0.8rem;
  font-weight: 700;
  color: var(--lime);
  text-transform: uppercase;
  letter-spacing: 1px;
  margin-right: 0.4rem;
}
.cat-pill {
  padding: 0.4rem 1rem;
  border-radius: 20px;
  background: rgba(255,255,255,.08);
  color: var(--parch);
  text-decoration: none;
  font-size: 0.85rem;
  border: 1px solid rgba(255,255,255,.15);
  transition: background .2s;
}
.cat-pill:hover {
  background: rgba(255,255,255,.15);
}
.cat-pill.active {
  background: var(--lime);
  color: var(--sage);
  font-weight: 700;
  border-color: var(--lime);
}
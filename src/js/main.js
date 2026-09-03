import { initHeader } from './components/header.js';
import { observeMotion } from './components/motion.js';
import { initBlog } from './components/blog.js';


function syncSwiperNavigationCenter(block) {
  const swiper = Array.from(block.children).find((child) => child.classList && child.classList.contains('swiper')) || block.querySelector('.swiper');
  if (!swiper) return;

  const slide = swiper.querySelector('.swiper-slide-active.wpbb-swiper-slide, .swiper-slide-visible.wpbb-swiper-slide, .wpbb-swiper-slide');
  let y = 0;
  if (slide) {
    const blockRect = block.getBoundingClientRect();
    const slideRect = slide.getBoundingClientRect();
    if (slideRect.height > 0) y = (slideRect.top - blockRect.top) + (slideRect.height / 2);
  }
  if (!(Number.isFinite(y) && y > 0)) y = swiper.offsetTop + (swiper.clientHeight / 2);
  if (Number.isFinite(y) && y > 0) block.style.setProperty('--wpbb-swiper-nav-y', `${Math.round(y)}px`);
}


function normalizePartnerSwipers() {
  document.querySelectorAll('.wp-theme-partners-section .swiper').forEach((swiperElement) => {
    const swiper = swiperElement.swiper;
    if (!swiper || !swiper.params) return;

    const normalize = (params) => {
      if (!params) return;
      params.centeredSlides = false;
      params.centeredSlidesBounds = false;
      params.centerInsufficientSlides = false;
      params.slidesOffsetBefore = 0;
      params.slidesOffsetAfter = 0;
    };
    normalize(swiper.params);
    normalize(swiper.originalParams);
    swiper.update();
  });
}

function syncAllSwiperNavigationCenters() {
  document.querySelectorAll('.wpbb-swiper-block--nav-gutter').forEach(syncSwiperNavigationCenter);
}

function moveTestimonialNavigationToOuterGutter() {
  document.querySelectorAll('.wpbb-swiper-block').forEach((block) => {
    const cards = block.querySelector('.wpbb-swiper--cards');
    const explicitTestimonials = block.closest('.business-testimonials, .wp-theme-testimonials-section');
    if (!cards && !explicitTestimonials) return;
    if (block.querySelector('.wpbb-swiper--hero, .wpbb-swiper--gallery, .wpbb-swiper--logos')) return;

    const prev = block.querySelector('.swiper-button-prev');
    const next = block.querySelector('.swiper-button-next');
    if (!prev && !next) return;

    block.classList.add('wpbb-swiper-block--nav-gutter');
    if (prev && prev.parentElement !== block) block.appendChild(prev);
    if (next && next.parentElement !== block) block.appendChild(next);
    syncSwiperNavigationCenter(block);
  });
}

function initPresentationGeometry() {
  let resizeTimer = 0;
  const run = () => {
    moveTestimonialNavigationToOuterGutter();
    normalizePartnerSwipers();
    window.setTimeout(() => {
      moveTestimonialNavigationToOuterGutter();
      normalizePartnerSwipers();
      syncAllSwiperNavigationCenters();
    }, 600);
  };
  window.addEventListener('resize', () => {
    window.clearTimeout(resizeTimer);
    resizeTimer = window.setTimeout(() => {
      normalizePartnerSwipers();
      syncAllSwiperNavigationCenters();
    }, 100);
  }, { passive: true });
  if (document.readyState === 'complete') run();
  else window.addEventListener('load', run, { once: true });
}


function initQuoteDrawer() {
  const trigger = document.querySelector('.wp-theme-quote-float');
  if (!trigger || document.body.classList.contains('wpbb-request-quote-disabled')) return;
  const directLink = trigger.matches('a') ? trigger : trigger.querySelector('a');
  const href = (directLink && directLink.getAttribute('href')) || '/request-a-quote/';
  const countNode = trigger.querySelector('.wp-theme-quote-count, .count, [data-quote-count]');
  const count = countNode ? countNode.textContent.trim() : (trigger.textContent.match(/\d+/) || ['0'])[0];

  const backdrop = document.createElement('div');
  backdrop.className = 'wp-theme-quote-drawer-backdrop';
  backdrop.hidden = true;
  const drawer = document.createElement('aside');
  drawer.className = 'wp-theme-quote-drawer';
  drawer.setAttribute('aria-hidden', 'true');
  drawer.innerHTML = `
    <div class="wp-theme-quote-drawer__head">
      <div><span class="wp-theme-sector-eyebrow">Quote</span><h2>Your quote</h2></div>
      <button type="button" class="wp-theme-quote-drawer__close" aria-label="Close quote">×</button>
    </div>
    <div class="wp-theme-quote-drawer__body">
      <p class="wp-theme-quote-drawer__count"><strong>${count}</strong> item${count === '1' ? '' : 's'} currently saved for quotation.</p>
      <p>Review the selected items, add your contact details and send one quotation request when you are ready.</p>
    </div>
    <div class="wp-theme-quote-drawer__actions"><a class="wp-theme-btn wp-theme-btn--primary" href="${href}">Review quote</a></div>`;
  document.body.append(backdrop, drawer);
  const close = () => { drawer.classList.remove('is-open'); drawer.setAttribute('aria-hidden', 'true'); backdrop.hidden = true; document.body.classList.remove('wp-theme-quote-drawer-open'); };
  const open = (event) => { if (event) event.preventDefault(); backdrop.hidden = false; requestAnimationFrame(() => drawer.classList.add('is-open')); drawer.setAttribute('aria-hidden', 'false'); document.body.classList.add('wp-theme-quote-drawer-open'); drawer.querySelector('.wp-theme-quote-drawer__close').focus(); };
  trigger.addEventListener('click', open);
  backdrop.addEventListener('click', close);
  drawer.querySelector('.wp-theme-quote-drawer__close').addEventListener('click', close);
  document.addEventListener('keydown', (event) => { if (event.key === 'Escape' && drawer.classList.contains('is-open')) close(); });
}



function applyChildThemeTablerIcons() {
  const cfg = window.wpbbChildVisuals;
  if (!cfg || !cfg.base || !Array.isArray(cfg.icons) || !cfg.icons.length) return;
  const slots = Array.from(document.querySelectorAll('#wp-theme-main .wp-theme-card-icon, #wp-theme-main .wp-theme-sector-card__icon, #wp-theme-main .wp-theme-icon-box'))
    .filter((node) => !node.closest('.wp-theme-contact-detail'));
  slots.forEach((slot, index) => {
    if (slot.querySelector('.wp-theme-tabler-icon')) return;
    const icon = cfg.icons[index % cfg.icons.length];
    if (!icon) return;
    slot.querySelectorAll('svg, img').forEach((legacy) => { legacy.setAttribute('aria-hidden', 'true'); legacy.style.display = 'none'; });
    const span = document.createElement('span');
    span.className = 'wp-theme-tabler-icon';
    span.setAttribute('aria-hidden', 'true');
    const safeUrl = `${cfg.base.replace(/\/$/, '')}/assets/icons/tabler/${icon}.svg`;
    span.style.setProperty('--wp-theme-tabler-icon', `url("${safeUrl}")`);
    slot.appendChild(span);
  });
}

function boot() {
  initHeader();
  applyChildThemeTablerIcons();
  observeMotion();
  initBlog();
  initPresentationGeometry();
  initQuoteDrawer();
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', boot, { once: true });
} else {
  boot();
}

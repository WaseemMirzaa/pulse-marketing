/*
 * PulseLyft skin — progressive enhancement for the Gecko build.
 * Reveal-on-scroll for elements carrying the `.pl-reveal` class. No-JS and
 * reduced-motion users always see fully-rendered content.
 */
(function () {
  "use strict";

  // Mark that JS is available so the CSS can hide-then-reveal.
  document.documentElement.classList.add("js");

  var reduce = window.matchMedia && window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  function ready(fn) {
    if (document.readyState !== "loading") { fn(); }
    else { document.addEventListener("DOMContentLoaded", fn); }
  }

  ready(function () {
    var items = document.querySelectorAll(".pl-reveal");
    if (!items.length) { return; }

    if (reduce || !("IntersectionObserver" in window)) {
      items.forEach(function (el) { el.classList.add("pl-in"); });
      return;
    }

    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add("pl-in");
          io.unobserve(entry.target);
        }
      });
    }, { rootMargin: "0px 0px -8% 0px", threshold: 0.08 });

    items.forEach(function (el) { io.observe(el); });
  });
})();

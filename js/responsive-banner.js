(() => {
  "use strict";

  // Keep the third-party document at its native size; scale the whole frame.
  document.querySelectorAll(".martinus-banner-container").forEach((container) => {
    const frame = container.querySelector("iframe");
    if (!frame) return;

    const resize = () => {
      const scale = Math.min(1, container.getBoundingClientRect().width / 300);
      frame.style.transform = `scale(${scale})`;
    };
    resize();
    if (typeof ResizeObserver !== "undefined") {
      new ResizeObserver(resize).observe(container);
    } else {
      window.addEventListener("resize", resize);
    }
  });
})();

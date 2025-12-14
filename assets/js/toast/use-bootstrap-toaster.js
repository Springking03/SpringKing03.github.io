var toast = function() {
  "use strict";
  const defaultOptions = {
    animation: true,
    autohide: true,
    delay: 4e3,
    gap: 16,
    margin: "1rem",
    placement: "top-right",
    classes: "",
    body: ""
  };
  function createElement(tagName, attributes) {
    const element = document.createElement(tagName);
    return Object.assign(element, attributes);
  }
  function stack(placement, gap) {
    const toasts = document.body.querySelectorAll(`:scope > .toast-${placement}`);
    const pos = placement.split("-");
    const vPosition = pos[0];
    const yAxis = [];
    toasts.forEach((el, index) => {
      index === 0 && yAxis.push(0);
      if (toasts[index + 1] instanceof HTMLElement) {
        yAxis.push(yAxis[index] + el.offsetHeight);
      }
      el.style[vPosition] = `${yAxis[index] + gap * index}px`;
    });
  }
  function getToaster(BootstrapToast) {
    var _a;
    return BootstrapToast || ((_a = window.bootstrap) == null ? void 0 : _a.Toast);
  }
  const toast2 = (input, BootstrapToast) => {
    const Toaster = getToaster(BootstrapToast);
    if (Toaster === void 0) {
      throw new Error("Bootstrap Toast is not defined.");
    } else {
      const {
        animation,
        autohide,
        body,
        delay,
        gap,
        margin,
        placement,
        classes,
        header
      } = {
        ...defaultOptions,
        ...window.UseBootstrapToasterOptions,
        ...typeof input === "string" ? {} : input
      };
      const pos = placement.split("-");
      const vPosition = pos[0];
      const hPosition = pos[1];
      const toastElement = createElement("div", {
        className: `use-bootstrap-toaster toast position-fixed toast-${placement} ${classes}`,
        role: "alert",
        ariaLive: "assertive",
        ariaAtomic: "true"
      });
      toastElement.style.margin = margin;
      toastElement.style.zIndex = "var(--bs-toast-zindex)";
      toastElement.style[vPosition] = "0";
      toastElement.style[hPosition] = animation ? "-50%" : "0";
      if (header !== void 0) {
        const toastHeader = createElement("div", {
          className: "toast-header"
        });
        if (typeof header === "string") {
          toastHeader.insertAdjacentHTML("beforeend", header);
        } else {
          const {
            icon,
            title,
            ago,
            closeBtn
          } = header;
          if (icon) {
            toastHeader.insertAdjacentHTML("beforeend", icon);
          }
          if (title) {
            toastHeader.insertAdjacentElement("beforeend", createElement("strong", {
              className: "me-auto",
              textContent: title
            }));
          }
          if (ago) {
            toastHeader.insertAdjacentElement("beforeend", createElement("small", {
              textContent: ago
            }));
          }
          if (closeBtn) {
            const button = createElement("button", {
              type: "button",
              className: "btn-close",
              ariaLabel: "Close"
            });
            button.setAttribute("data-bs-dismiss", "toast");
            toastHeader.insertAdjacentElement("beforeend", button);
          }
        }
        toastElement.append(toastHeader);
      }
      toastElement.insertAdjacentElement("beforeend", createElement("div", {
        className: "toast-body",
        innerHTML: typeof input === "string" ? input : body
      }));
      document.body.insertAdjacentElement("afterbegin", toastElement);
      const toast22 = Toaster.getOrCreateInstance(toastElement, {
        animation,
        autohide,
        delay
      });
      toastElement.addEventListener("hidden.bs.toast", () => {
        toastElement.remove();
        stack(placement, gap);
      });
      toastElement.addEventListener("show.bs.toast", () => {
        const timer = setInterval(myFunction, 0);
        function myFunction() {
          if (toastElement.offsetHeight > 0) {
            clearInterval(timer);
            if (animation) {
              const transition = Number.parseFloat(getComputedStyle(toastElement).transitionDuration) * 1e3;
              toastElement.style.transition = `all ${transition * 4}ms cubic-bezier(0.16, 1, 0.3, 1), opacity ${transition}ms linear`;
              toastElement.style[hPosition] = "0";
            }
            stack(placement, gap);
          }
        }
      });
      toast22.show();
      return {
        hide: () => toast22.hide()
      };
    }
  };
  toast2.hide = (BootstrapToast) => {
    const Toaster = getToaster(BootstrapToast);
    if (Toaster === void 0) {
      throw new Error("Bootstrap Toast is not defined.");
    } else {
      document.body.querySelectorAll(":scope > .toast").forEach((el) => {
        const toast22 = Toaster.getOrCreateInstance(el);
        toast22.hide();
      });
    }
  };
  return toast2;
}();

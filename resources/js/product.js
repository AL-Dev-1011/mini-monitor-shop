import './product';

// ======================================================
// PRODUCT FORM LIVE PREVIEW
// ======================================================

const form = document.getElementById("product-form");

if (form) {
  // ======================================================
  // HELPERS
  // ======================================================

  function setText(id, value, fallback = "-") {
    const element = document.getElementById(id);

    if (!element) return;

    element.innerText = value || fallback;
  }

  function getFormData() {
    const formData = new FormData(form);
    const data = {};

    for (let [key, value] of formData.entries()) {
      data[key] = value;
    }

    form.querySelectorAll('input[type="checkbox"]').forEach((checkbox) => {
      data[checkbox.name] = checkbox.checked;
    });

    return data;
  }

  // ======================================================
  // COLOR BIT AUTO FILL
  // ======================================================

  const colorBit = document.getElementById("color_bit");
  const colorDepth = document.getElementById("color_depth");

  function updateColorDepth() {
    if (!colorBit || !colorDepth) return;

    if (colorBit.value === "8-bit") {
      colorDepth.value = "16.7 million colors";
    } else if (colorBit.value === "10-bit") {
      colorDepth.value = "1.07 billion colors";
    } else {
      colorDepth.value = "";
    }
  }

  // ======================================================
  // MAIN PREVIEW UPDATE
  // ======================================================

  function updatePreview() {
    const data = getFormData();

    // ------------------------------
    // LIVE CARD PREVIEW
    // ------------------------------

    setText("preview-brand", data.brand, "BRAND");

    setText(
      "preview-application",
      data.application,
      "business / personal"
    );

    if (data.display_size && data.display_size.trim() !== "") {
      setText("preview-size-text", `${data.display_size.trim()}"`);
    } else {
      setText("preview-size-text", "Monitor size");
    }

    setText("preview-brand-text", data.brand, "Monitor brand");
    setText("preview-name", data.name, "Monitor name");

    setText("preview-resolution", data.resolution);
    setText("preview-refresh", data.refresh_rate);
    setText("preview-aspect-ratio", data.aspect_ratio);
    setText("preview-panel", data.panel_type);

    // ------------------------------
    // COLOR GAMUT PREVIEW
    // ------------------------------

    // const gamutLabels = {
    //   sRGB: "sRGB",
    //   Adobe_RGB: "Adobe RGB",
    //   DCI_P3: "DCI-P3",
    //   Rec_2020_BT_2020: "Rec. 2020 / BT. 2020",
    // };

    // const activeGamuts = [];

    // Object.keys(gamutLabels).forEach((key) => {
    //   if (data[`gamut_enable_${key}`]) {
    //     const percent = data[`gamut_percent_${key}`] || "";

    //     activeGamuts.push(
    //       `${percent ? percent + "% " : ""}${gamutLabels[key]}`
    //     );
    //   }
    // });

    // setText(
    //   "preview-color-gamut",
    //   activeGamuts.join(" / "),
    //   "-"
    // );

    // ------------------------------
    // IMAGE PREVIEW
    // ------------------------------

    const imgPreview = document.getElementById("preview-image");

    if (imgPreview) {
      imgPreview.src =
        data.image && data.image.trim() !== ""
          ? data.image
          : "https://placehold.co/600x400/f3f4f6/a3a3a3?text=No+Image";
    }

    // ------------------------------
    // FIXED DISCOUNT PRICE PREVIEW
    // ------------------------------

    const basePrice = parseFloat(data.price) || 0;
    const discountValue = parseFloat(data.discount) || 0;

    let finalPrice = basePrice;

    const discountBadge = document.getElementById("preview-discount");
    const originalPriceSpan = document.getElementById(
      "preview-original-price"
    );

    if (discountValue > 0 && basePrice > 0) {
      finalPrice = Math.max(0, basePrice - discountValue);

      if (discountBadge) {
        discountBadge.classList.remove("hidden");
        discountBadge.innerText = `-$${discountValue}`;
      }

      if (originalPriceSpan) {
        originalPriceSpan.classList.remove("hidden");
        originalPriceSpan.innerText = "$" + basePrice.toFixed(2);
      }
    } else {
      if (discountBadge) {
        discountBadge.classList.add("hidden");
      }

      if (originalPriceSpan) {
        originalPriceSpan.classList.add("hidden");
      }
    }

    setText(
      "preview-price",
      "$" + finalPrice.toFixed(2),
      "$0.00"
    );

    // ------------------------------
    // SPECIFICATION TABLE
    // ------------------------------

    setText("table-brand", data.brand, "");
    setText("table-name", data.name, "");

    if (data.display_size && data.display_size.trim() !== "") {
      setText("table-display-size", `${data.display_size.trim()}"`);
    } else {
      setText("table-display-size");
    }

    setText("table-resolution", data.resolution);
    setText("table-refresh", data.refresh_rate);
    setText("table-panel", data.panel_type);
    setText("table-aspect-ratio", data.aspect_ratio);

    // Response time auto add "ms"
    if (data.response_time && data.response_time.trim() !== "") {
      const responseTime = data.response_time.trim();

      setText(
        "table-response-time",
        responseTime.toLowerCase().includes("ms")
          ? responseTime
          : responseTime + " ms"
      );
    } else {
      setText("table-response-time");
    }

    setText("table-curvature", data.screen_curvature);
    setText("table-brightness", data.brightness);

    const colorText = [];

    if (data.color_bit) colorText.push(data.color_bit);
    if (data.color_depth) colorText.push(data.color_depth);

    setText("table-color", colorText.join(" / "), "-");

    // ------------------------------
    // CONNECTION TYPES TABLE
    // ------------------------------

    const ports = [
      "HDMI",
      "DisplayPort",
      "USB-C",
      "Thunderbolt",
      "VGA",
      "USB",
      "RJ45",
    ];

    let connectionHTML = "";

    ports.forEach((port) => {
      if (data[`connection_enable_${port}`]) {
        const count = data[`connection_count_${port}`] || 1;
        connectionHTML += `<div class="block">${count} x ${port}</div>`;
      }
    });

    const connectivityTable = document.getElementById(
      "table-connectivity"
    );

    if (connectivityTable) {
      connectivityTable.innerHTML = connectionHTML || "-";
    }

    // setText("table-gamut", activeGamuts.join(", "), "-");

    // ------------------------------
    // DIMENSION TABLE
    // ------------------------------

    if (
      data.dimension_width ||
      data.dimension_height ||
      data.dimension_depth
    ) {
      const width = data.dimension_width || "0";
      const height = data.dimension_height || "0";
      const depth = data.dimension_depth || "0";

      setText(
        "table-dimension",
        `${width} x ${height} x ${depth} cm`
      );
    } else {
      setText("table-dimension");
    }

    setText("table-accessory", data.accessory_in_box);
  }

  // ======================================================
  // EVENT LISTENERS
  // ======================================================

  form.addEventListener("input", () => {
    updateColorDepth();
    updatePreview();
  });

  form.addEventListener("change", () => {
    updateColorDepth();
    updatePreview();
  });

  window.addEventListener("DOMContentLoaded", () => {
    updateColorDepth();
    updatePreview();
  });
}
// อ้างอิง Element ฟอร์ม เพื่อใช้จับ Event การกรอกข้อมูล
const form = document.getElementById("product-form");

// ฟังก์ชันหลักที่ทำงานทุกครั้งเมื่อมีการพิมพ์/เปลี่ยนแปลงข้อมูลในฟอร์ม
function updatePreview() {
  const formData = new FormData(form);
  const data = {};

  // แปลงข้อมูลจาก FormData ไปเก็บในรูปแบบ Object (ดึงง่ายขึ้น เช่น data.name)
  for (let [key, value] of formData.entries()) {
    data[key] = value;
  }

  // วนลูปดึงสถานะ Checkbox ทุกอันเพิ่มใน Object ดาต้า (เนื่องจากปกติ FormData จะละเว้น checkbox ที่ไม่ได้ติ๊ก)
  form.querySelectorAll('input[type="checkbox"]').forEach((checkbox) => {
    data[checkbox.name] = checkbox.checked;
  });

  // ------------------------------------------
  // SUB-PART A: การจัดการข้อมูลบน LIVE CARD PREVIEW
  // ------------------------------------------

  // 1. ผูกข้อความส่วนหัวการ์ดสั้น
  document.getElementById("preview-brand").innerText = data.brand || "BRAND";
  document.getElementById("preview-application").innerText =
    data.application || "business / personal";

  // 2. [อัปเดตระบบฉีดฟันหนูอัตโนมัติ] หากมีการกรอกหน้าจอ จะแถมสัญลักษณ์นิ้ว (") ต่อท้ายทันที ถ้าว่างให้คงข้อความเริ่มต้นไว้
  if (data.display_size && data.display_size.trim() !== "") {
    document.getElementById("preview-size-text").innerText =
      data.display_size.trim() + '"';
  } else {
    document.getElementById("preview-size-text").innerText = "Monitor size";
  }
  document.getElementById("preview-brand-text").innerText =
    data.brand || "Monitor brand";
  document.getElementById("preview-name").innerText =
    data.name || "Monitor name";

  // 3. แนบข้อมูลให้กับกล่องสเปกย่อย 4 ตัวด้านบนของการ์ด
  document.getElementById("preview-resolution").innerText =
    data.resolution || "-";
  document.getElementById("preview-refresh").innerText =
    data.refresh_rate || "-";
  document.getElementById("preview-aspect-ratio").innerText =
    data.aspect_ratio || "-";
  document.getElementById("preview-panel").innerText = data.panel_type || "-";

  // วนเช็คขอบเขตสีของ Gamut ที่ถูกติ๊กเลือก เพื่อรวบรวมนำไปแสดงผลเรียงบรรทัดล่างสุด
  const gamutKeys = ["sRGB", "Adobe_RGB", "DCI_P3", "Rec_2020_BT_2020"];
  let activeGamuts = [];
  gamutKeys.forEach((gamut) => {
    if (data[`gamut_enable_${gamut}`]) {
      const percent = data[`gamut_percent_${gamut}`] || "";
      // แปลงชื่อจากขีดล่างสเปซ และเติม % ต่อท้ายถ้ากรอกตัวเลขสัดส่วนมา
      activeGamuts.push(
        `${gamut.replace("_", " ")} ${percent ? percent + "%" : ""}`,
      );
    }
  });
  document.getElementById("preview-color-gamut").innerText =
    activeGamuts.join(" / ") || "-";

  // 4. แสดงผลรูปภาพ หากช่องป้อน URL ว่างเปล่า จะดึงภาพ placeholder พื้นหลังสีเทามาสแตนด์บายแทน
  const imgPreview = document.getElementById("preview-image");
  if (data.image && data.image.trim() !== "") {
    imgPreview.src = data.image;
  } else {
    imgPreview.src = "https://placehold.co/600x400/f3f4f6/a3a3a3?text=No+Image";
  }

  // 5. อัลกอริทึมคำนวณราคาส่วนลด (รองรับระบบหัก % และลบราคาสุทธิเงินสดแบบคงที่ Fixed)
  const basePrice = parseFloat(data.price) || 0;
  const discountVal = parseFloat(data.discount) || 0;
  const discountType = data.discount_type;
  let finalPrice = basePrice;

  const discountBadge = document.getElementById("preview-discount");
  const originalPriceSpan = document.getElementById("preview-original-price");

  // ตรวจสอบเงื่อนไขว่า มีราคาตั้งต้น และ มีมูลค่าส่วนลดมากกว่า 0 หรือไม่
  if (discountVal > 0 && basePrice > 0) {
    discountBadge.classList.remove("hidden"); // แสดงป้ายลดราคา
    originalPriceSpan.classList.remove("hidden"); // แสดงราคาเต็มขีดฆ่า
    originalPriceSpan.innerText = "$" + basePrice.toFixed(2);

    if (discountType === "percent") {
      discountBadge.innerText = `-${discountVal}%`;
      finalPrice = basePrice - basePrice * (discountVal / 100);
    } else if (discountType === "fixed") {
      discountBadge.innerText = `-$${discountVal}`;
      finalPrice = Math.max(0, basePrice - discountVal); // Math.max เพื่อป้องกันไม่ให้ราคากลายเป็นติดลบ
    }
  } else {
    // หากไม่มีส่วนลด ให้ซ่อนส่วนประกอบโปรโมชั่นทั้งหมดออกไป
    discountBadge.classList.add("hidden");
    originalPriceSpan.classList.add("hidden");
  }
  document.getElementById("preview-price").innerText =
    "$" + finalPrice.toFixed(2);

  // ------------------------------------------
  // SUB-PART B: การแมปข้อมูลใส่ตารางคุณสมบัติจำลอง (SPECIFICATION TABLE)
  // ------------------------------------------
  document.getElementById("table-brand").innerText = data.brand || "";
  document.getElementById("table-name").innerText = data.name || "";

  // แปลงข้อมูลขนาดหน้าจอให้มีสัญลักษณ์นิ้ว (") ในตารางเช่นกัน
  document.getElementById("table-display-size").innerText =
    data.display_size && data.display_size.trim() !== ""
      ? data.display_size.trim() + '"'
      : "-";

  document.getElementById("table-resolution").innerText =
    data.resolution || "-";
  document.getElementById("table-refresh").innerText = data.refresh_rate || "-";
  document.getElementById("table-panel").innerText = data.panel_type || "-";
  document.getElementById("table-aspect-ratio").innerText =
    data.aspect_ratio || "-";

  // [อัปเดตระบบเติม ms อัตโนมัติ] ตรวจเช็คค่า Response Time ถ้าพิมพ์แค่ตัวเลข ระบบจะเติมหน่วย "ms" ให้ในตารางพรีวิวทันที
  if (data.response_time && data.response_time.trim() !== "") {
    let rt = data.response_time.trim();
    document.getElementById("table-response-time").innerText = rt
      .toLowerCase()
      .includes("ms")
      ? rt
      : rt + " ms";
  } else {
    document.getElementById("table-response-time").innerText = "-";
  }

  document.getElementById("table-curvature").innerText =
    data.screen_curvature || "-";
  document.getElementById("table-brightness").innerText =
    data.brightness || "-";

  // ผูกข้อมูล Bit และความลึกสีเข้าคู่กันโดยคั่นด้วยเครื่องหมาย /
  let colorText = [];
  if (data.color_bit) colorText.push(data.color_bit);
  if (data.color_depth) colorText.push(data.color_depth);
  document.getElementById("table-color").innerText =
    colorText.join(" / ") || "-";

  // พอร์ตการเชื่อมต่อ: ตรวจสอบพอร์ตที่เลือกเปิดใช้งานทั้งหมดเพื่อสร้างบรรทัดรายการ "จำนวนพอร์ต x ชื่อพอร์ต" ลงในช่องเดียว
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
  document.getElementById("table-connectivity").innerHTML =
    connectionHTML || "-";

  // นำชุดข้อมูล Gamut สีทั้งหมดที่คำนวณไว้ข้างบนมาคั่นด้วยจุลภาคแสดงในตาราง
  document.getElementById("table-gamut").innerText =
    activeGamuts.join(", ") || "-";

  // ตรวจสอบขนาดมิติเครื่อง หากมีการป้อนส่วนใดส่วนหนึ่ง จะนำมาเรียงเขียนเป็นคอร์ส x ซม.
  if (data.dimension_width || data.dimension_height || data.dimension_depth) {
    const w = data.dimension_width || "0";
    const h = data.dimension_height || "0";
    const d = data.dimension_depth || "0";
    document.getElementById("table-dimension").innerText =
      `${w} x ${h} x ${d} cm`;
  } else {
    document.getElementById("table-dimension").innerText = "-";
  }

  document.getElementById("table-accessory").innerText =
    data.accessory_in_box || "-";
}

// ผูกคำสั่งรับแรงกระตุ้น (Event Listeners) เพื่อให้หน้าจอพรีวิวขยับอัปเดตสดๆ ตลอดเวลา
form.addEventListener("input", updatePreview); // ดักจับเมื่อผู้ใช้เริ่มป้อนตัวหนังสือใดๆ (เช่น ช่อง Input Text)
form.addEventListener("change", updatePreview); // ดักจับเมื่อเกิดการเลือกตัวแปรใหม่ (เช่น การคลิก Select หรือ Checkbox)
window.addEventListener("DOMContentLoaded", updatePreview); // สั่งงานครั้งแรกตอนเปิดหน้าเว็บโหลดข้อมูลดิบสำเร็จ

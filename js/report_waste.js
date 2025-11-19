// IMAGE PREVIEW
const fileInput = document.getElementById("wasteImage");
const previewImg = document.getElementById("previewImg");

fileInput.addEventListener("change", () => {
    const file = fileInput.files[0];
    previewImg.src = URL.createObjectURL(file);
    previewImg.style.display = "block";
});

// TOGGLE DROPDOWN
document.getElementById("dropdownBtn").onclick = () => {
    const box = document.getElementById("dropdownContent");
    box.style.display = box.style.display === "block" ? "none" : "block";
};

// SHOW/HIDE "OTHER" INPUT
document.getElementById("otherCheckbox").addEventListener("change", function () {
    const input = document.getElementById("otherWasteInput");
    input.style.display = this.checked ? "block" : "none";
});

// COLLECT SELECTED WASTE TYPES BEFORE SUBMIT
document.getElementById("reportForm").addEventListener("submit", () => {
    const selected = [];
    document.querySelectorAll(".wasteOption:checked").forEach(opt => {
        selected.push(opt.value);
    });

    document.getElementById("selectedWasteTypes").value = selected.join(", ");

    const otherValue = document.getElementById("otherCheckbox").checked
        ? document.getElementById("otherWasteInput").value
        : "";

    document.getElementById("otherWasteValue").value = otherValue;
});

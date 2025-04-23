document.addEventListener("DOMContentLoaded", function () {
    const dropArea = document.getElementById("drop-area");
    const fileInput = document.getElementById("file");
    const fileNameDisplay = document.getElementById("file-name");


    // Update file name on selection
    fileInput.addEventListener("change", function () {
        if (fileInput.files.length > 0) {
            fileNameDisplay.textContent = "Selected: " + fileInput.files[0].name;
        }
    });

    // Drag & Drop Events
    dropArea.addEventListener("dragover", (e) => {
        e.preventDefault();
        dropArea.classList.add("drag-over");
    });

    dropArea.addEventListener("dragleave", () => {
        dropArea.classList.remove("drag-over");
    });

    dropArea.addEventListener("drop", (e) => {
        e.preventDefault();
        dropArea.classList.remove("drag-over");

        if (e.dataTransfer.files.length > 0) {
            fileInput.files = e.dataTransfer.files; // Assign dropped file
            fileNameDisplay.textContent = "Selected: " + fileInput.files[0].name;
        }
    });
});


function uploadID() {
    const fileInput = document.getElementById('id-document');
    const uploadStatus = document.getElementById('upload-status');

    if (fileInput.files.length > 0) {
        const file = fileInput.files[0];
        // Simulate file upload (replace with actual API call)
        uploadStatus.textContent = `Uploading ${file.name}...`;
        setTimeout(() => {
            uploadStatus.textContent = "ID uploaded successfully!";
        }, 2000);
    } else {
        uploadStatus.textContent = "Please select a file to upload.";
    }
}

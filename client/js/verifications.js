// Fetch verification status
function fetchVerificationStatus(userId) {
    axios.get(`http://your-backend-url/server/user/v1/APIs/verifications.php?user_id=${userId}`)
        .then(response => {
            console.log('Verification Status:', response.data);
            // Display the verification status in the UI
        })
        .catch(error => {
            console.error('Error fetching verification status:', error);
        });
}

// Submit a new verification
function submitVerification(userId, documentType, documentUrl) {
    axios.post(`http://your-backend-url/server/user/v1/APIs/verifications.php?user_id=${userId}`, {
        document_type: documentType,
        document_url: documentUrl
    })
    .then(response => {
        console.log('Verification Submitted:', response.data);
        // Handle success (e.g., show a success message and refresh the status)
        fetchVerificationStatus(userId); // Refresh the verification status
    })
    .catch(error => {
        console.error('Error submitting verification:', error);
    });
}

// Example usage
const userId = 1; // Replace with the actual user ID
fetchVerificationStatus(userId);

// Call this function when the user submits a verification
submitVerification(userId, 'passport', 'https://example.com/passport.jpg');